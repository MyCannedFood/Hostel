<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\ExperienceBooking;
use App\Models\PromoCode;
use App\Models\Guest;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::where('status', 'Active')->get();
        return view('pages.experience', compact('experiences'));
    }

    public function bookingDetail(Experience $experience)
    {
        if ($experience->status !== 'Active') {
            abort(404);
        }

        $old = session('exp_booking_step1', []);

        return view('pages.experience-booking-detail', compact('experience', 'old'));
    }

    public function storeBookingDetail(Request $request, Experience $experience)
    {
        $validated = $request->validate([
            'scheduled_date' => 'required|date|after_or_equal:today',
            'time_slot'      => 'required|string',
            'guest_count'    => 'required|integer|min:1|max:50',
            'guest_name'     => 'required|string|max:255',
            'guest_whatsapp' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'special_notes'  => 'nullable|string|max:1000',
            'agree'          => 'accepted',
        ], [
            'scheduled_date.after_or_equal' => 'Tanggal tidak boleh di masa lalu.',
            'agree.accepted'                => 'Kamu harus menyetujui Sanctuary Rules.',
            'guest_whatsapp.regex'          => 'Nomor WhatsApp hanya boleh berisi angka.',
        ]);

        $totalAmount = $experience->price * $validated['guest_count'];

        // Get tax & service charge settings
        $settings = \App\Models\GeneralSetting::getSection('operational_policies')->data;
        $taxIncluded = !($settings['tax_included'] ?? true);
        $totalTaxPercent = ($settings['government_tax'] ?? 11) + ($settings['service_charge'] ?? 5);

        $totalAmountVal = $totalAmount;
        if (!$taxIncluded) {
            $totalAmountVal = $totalAmount + ($totalAmount * $totalTaxPercent / 100);
        }

        session([
            'exp_booking' => [
                'experience_id'  => $experience->id,
                'scheduled_date' => $validated['scheduled_date'],
                'time_slot'      => $validated['time_slot'],
                'guest_count'    => $validated['guest_count'],
                'guest_name'     => $validated['guest_name'],
                'guest_whatsapp' => $validated['guest_whatsapp'],
                'special_notes'  => $validated['special_notes'] ?? null,
                'subtotal'       => $totalAmount,
                'promo_code'     => null,
                'promo_discount' => 0,
                'total_amount'   => $totalAmountVal,
            ],
        ]);

        return redirect()->route('experience.payment-method');
    }

    public function paymentMethod()
    {
        $booking = session('exp_booking');
        if (!$booking) {
            return redirect()->route('experience');
        }

        // Recalculate total_amount to ensure it's fresh and correct
        $settings = \App\Models\GeneralSetting::getSection('operational_policies')->data;
        $taxIncluded = !($settings['tax_included'] ?? true);
        $totalTaxPercent = ($settings['government_tax'] ?? 11) + ($settings['service_charge'] ?? 5);

        \Log::info('Database Connection Details in web request:', [
            'database_name' => \DB::connection()->getDatabaseName(),
            'db_username' => config('database.connections.mysql.username'),
            'db_database_config' => config('database.connections.mysql.database'),
        ]);

        \Log::info('Tax Settings in paymentMethod:', [
            'tax_included' => $taxIncluded,
            'settings_tax_included' => $settings['tax_included'] ?? 'not_set',
            'raw_settings' => $settings,
            'booking_subtotal' => $booking['subtotal'] ?? 0,
            'booking_total_amount' => $booking['total_amount'] ?? 0
        ]);

        $afterDiscount = max(0, ($booking['subtotal'] ?? 0) - ($booking['promo_discount'] ?? 0));
        $taxServiceVal = 0;
        if (!$taxIncluded) {
            $taxServiceVal = $afterDiscount * $totalTaxPercent / 100;
            $booking['total_amount'] = $afterDiscount + $taxServiceVal;
        } else {
            $booking['total_amount'] = $afterDiscount;
        }
        session(['exp_booking' => $booking]);

        $experience = Experience::findOrFail($booking['experience_id']);

        return view('pages.experience-payment-method', compact('booking', 'experience', 'taxIncluded', 'totalTaxPercent', 'taxServiceVal'));
    }

    public function storePaymentMethod(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $booking = session('exp_booking');
        if (!$booking) {
            return redirect()->route('experience');
        }

        // Generate ticket ID jika belum ada
        if (empty($booking['pending_ticket_id'])) {
            $booking['pending_ticket_id'] = 'ALS-' . strtoupper(Str::random(8));
        }

        $booking['payment_method'] = $request->payment_method;
        $booking['snap_token']     = null;

        // Recalculate total_amount to ensure it's fresh and correct
        $settings = \App\Models\GeneralSetting::getSection('operational_policies')->data;
        $taxIncluded = !($settings['tax_included'] ?? true);
        $totalTaxPercent = ($settings['government_tax'] ?? 11) + ($settings['service_charge'] ?? 5);

        $afterDiscount = max(0, $booking['subtotal'] - ($booking['promo_discount'] ?? 0));
        if (!$taxIncluded) {
            $booking['total_amount'] = $afterDiscount + ($afterDiscount * $totalTaxPercent / 100);
        } else {
            $booking['total_amount'] = $afterDiscount;
        }

        // Generate Snap token jika Midtrans
        if ($request->payment_method === 'Midtrans') {
            $booking['snap_token'] = $this->generateSnapToken($booking);
        }

        session(['exp_booking' => $booking]);

        return redirect()->route('experience.payment');
    }

    protected function generateSnapToken(array $booking): ?string
    {
        $orderId = 'EXP-' . $booking['pending_ticket_id'] . '-' . time();

        $midtrans = new MidtransService();
        $snapToken = $midtrans->createSnapToken(
            $orderId,
            (int) $booking['total_amount'],
            [
                'first_name' => $booking['guest_name'],
                'phone' => $booking['guest_whatsapp'],
            ]
        );

        if ($snapToken) {
            $booking['midtrans_order_id'] = $orderId;
            session(['exp_booking' => $booking]);
        }

        return $snapToken;
    }

    /**
     * AJAX: Apply promo code
     * POST /experience/promo/apply
     */
    public function applyPromo(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $booking = session('exp_booking');
        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Session expired.'], 422);
        }

        $promo = PromoCode::where('code', strtoupper(trim($request->code)))->first();

        if (!$promo) {
            return response()->json(['success' => false, 'message' => 'Promo code not found.'], 404);
        }

        $result = $promo->apply((int) $booking['subtotal']);

        if (!$result['valid']) {
            return response()->json(['success' => false, 'message' => $result['message']], 422);
        }

        // Get tax & service charge settings
        $settings = \App\Models\GeneralSetting::getSection('operational_policies')->data;
        $taxIncluded = !($settings['tax_included'] ?? true);
        $totalTaxPercent = ($settings['government_tax'] ?? 11) + ($settings['service_charge'] ?? 5);

        // Simpan ke session
        $booking['promo_code']     = $promo->code;
        $booking['promo_discount'] = $result['discount'];

        $afterDiscount = max(0, $booking['subtotal'] - $result['discount']);
        if (!$taxIncluded) {
            $booking['total_amount']   = $afterDiscount + ($afterDiscount * $totalTaxPercent / 100);
        } else {
            $booking['total_amount']   = $afterDiscount;
        }
        session(['exp_booking' => $booking]);

        return response()->json([
            'success'        => true,
            'discount'       => $result['discount'],
            'total_amount'   => $booking['total_amount'],
            'discount_label' => $promo->discount_type === 'percentage'
                ? $promo->discount_value . '%'
                : 'IDR ' . number_format($promo->discount_value, 0, ',', '.'),
        ]);
    }

    /**
     * AJAX: Remove promo code
     * POST /experience/promo/remove
     */
    public function removePromo(Request $request)
    {
        $booking = session('exp_booking');
        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Session expired.'], 422);
        }

        // Get tax & service charge settings
        $settings = \App\Models\GeneralSetting::getSection('operational_policies')->data;
        $taxIncluded = !($settings['tax_included'] ?? true);
        $totalTaxPercent = ($settings['government_tax'] ?? 11) + ($settings['service_charge'] ?? 5);

        $booking['promo_code']     = null;
        $booking['promo_discount'] = 0;
        if (!$taxIncluded) {
            $booking['total_amount']   = $booking['subtotal'] + ($booking['subtotal'] * $totalTaxPercent / 100);
        } else {
            $booking['total_amount']   = $booking['subtotal'];
        }
        session(['exp_booking' => $booking]);

        return response()->json([
            'success'      => true,
            'total_amount' => $booking['total_amount'],
        ]);
    }

    public function payment()
    {
        $booking = session('exp_booking');
        if (!$booking || empty($booking['payment_method'])) {
            return redirect()->route('experience.payment-method');
        }

        // Recalculate total_amount to ensure it's fresh and correct
        $settings = \App\Models\GeneralSetting::getSection('operational_policies')->data;
        $taxIncluded = !($settings['tax_included'] ?? true);
        $totalTaxPercent = ($settings['government_tax'] ?? 11) + ($settings['service_charge'] ?? 5);

        $afterDiscount = max(0, $booking['subtotal'] - ($booking['promo_discount'] ?? 0));
        if (!$taxIncluded) {
            $booking['total_amount'] = $afterDiscount + ($afterDiscount * $totalTaxPercent / 100);
        } else {
            $booking['total_amount'] = $afterDiscount;
        }
        session(['exp_booking' => $booking]);

        $experience = Experience::findOrFail($booking['experience_id']);

        $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data="
            . urlencode($booking['pending_ticket_id']);

        $snapToken = $booking['snap_token'] ?? null;

        return view('pages.experience-payment', compact('booking', 'experience', 'qrCodeUrl', 'snapToken'));
    }

    public function confirmPayment(Request $request)
    {
        $booking = session('exp_booking');
        if (!$booking) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Session expired.'], 422);
            }
            return redirect()->route('experience');
        }

        $ticketId = $booking['pending_ticket_id'];

        $existing = ExperienceBooking::where('ticket_id', $ticketId)->first();
        if ($existing) {
            session(['exp_booking_confirmed_id' => $existing->id]);
            session()->forget('exp_booking');
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'redirect_url' => route('experience.success')]);
            }
            return redirect()->route('experience.success');
        }

        // Jika Midtrans, validasi hasil dari Snap callback
        if ($booking['payment_method'] === 'Midtrans' && $request->input('midtrans_result')) {
            $midtransResult = $request->input('midtrans_result');
            $status = $midtransResult['transaction_status'] ?? '';
            // Di sandbox/onSuccess, status transaksinya bisa settlement, capture, atau pending
            if ($status !== 'settlement' && $status !== 'capture' && $status !== 'pending') {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Pembayaran belum diselesaikan. Status: ' . $status
                    ], 422);
                }
                return redirect()->route('experience.payment')
                    ->with('error', 'Pembayaran belum selesai. Silakan selesaikan pembayaran terlebih dahulu.');
            }
        }

        try {
            $expBooking = ExperienceBooking::create([
                'experience_id'  => $booking['experience_id'],
                'user_id'        => null,
                'ticket_id'      => $ticketId,
                'guest_name'     => $booking['guest_name'],
                'guest_email'    => null,
                'guest_whatsapp' => $booking['guest_whatsapp'],
                'scheduled_date' => $booking['scheduled_date'],
                'time_slot'      => $booking['time_slot'],
                'guest_count'    => $booking['guest_count'],
                'special_notes'  => $booking['special_notes'] ?? null,
                'total_amount'   => $booking['total_amount'],
                'payment_method' => $booking['payment_method'],
                'payment_status' => 'Paid',
                'status'         => 'Awaiting',
            ]);

            // Increment promo used count
            if (!empty($booking['promo_code'])) {
                PromoCode::where('code', $booking['promo_code'])->increment('used');
            }

            session(['exp_booking_confirmed_id' => $expBooking->id]);
            session()->forget('exp_booking');

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'redirect_url' => route('experience.success')]);
            }
            return redirect()->route('experience.success');

        } catch (\Exception $e) {
            \Log::error('ExperienceBooking create failed: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan booking: ' . $e->getMessage()], 500);
            }
            return redirect()->route('experience.payment')
                ->with('error', 'Terjadi kesalahan saat menyimpan booking. Silakan coba lagi.');
        }
    }

    public function success()
    {
        $bookingId = session('exp_booking_confirmed_id');
        if (!$bookingId) {
            return redirect()->route('experience');
        }

        $expBooking = ExperienceBooking::with('experience')->findOrFail($bookingId);

        $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data="
            . urlencode($expBooking->ticket_id);

        session()->forget('exp_booking_confirmed_id');

        return view('pages.experience-success', compact('expBooking', 'qrCodeUrl'));
    }
}