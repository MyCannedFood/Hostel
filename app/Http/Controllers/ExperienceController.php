<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\ExperienceBooking;
use App\Models\PromoCode;
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
                'total_amount'   => $totalAmount,
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

        $experience = Experience::findOrFail($booking['experience_id']);

        return view('pages.experience-payment-method', compact('booking', 'experience'));
    }

    public function storePaymentMethod(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:QRIS,Virtual Account,Credit Card',
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

        session(['exp_booking' => $booking]);

        return redirect()->route('experience.payment');
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

        // Simpan ke session
        $booking['promo_code']     = $promo->code;
        $booking['promo_discount'] = $result['discount'];
        $booking['total_amount']   = max(0, $booking['subtotal'] - $result['discount']);
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

        $booking['promo_code']     = null;
        $booking['promo_discount'] = 0;
        $booking['total_amount']   = $booking['subtotal'];
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
            return redirect()->route('experience');
        }

        $ticketId = $booking['pending_ticket_id'];

        $existing = ExperienceBooking::where('ticket_id', $ticketId)->first();
        if ($existing) {
            session(['exp_booking_confirmed_id' => $existing->id]);
            session()->forget('exp_booking');
            return redirect()->route('experience.success');
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
                // Field di promo_codes: `used`
                PromoCode::where('code', $booking['promo_code'])->increment('used');
            }


            session(['exp_booking_confirmed_id' => $expBooking->id]);
            session()->forget('exp_booking');

            return redirect()->route('experience.success');

        } catch (\Exception $e) {
            \Log::error('ExperienceBooking create failed: ' . $e->getMessage());
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