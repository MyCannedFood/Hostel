<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\ExperienceBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExperienceController extends Controller
{
    // ──────────────────────────────────────────
    // STEP 0 — List semua experience (publik)
    // ──────────────────────────────────────────
    public function index()
    {
        $experiences = Experience::where('status', 'Active')->get();
        return view('pages.experience', compact('experiences'));
    }

    // ──────────────────────────────────────────
    // STEP 1 — Booking Detail Form
    // GET /experience/{experience}/booking
    // ──────────────────────────────────────────
    public function bookingDetail(Experience $experience)
    {
        if ($experience->status !== 'Active') {
            abort(404);
        }

        $old = session('exp_booking_step1', []);

        return view('pages.experience-booking-detail', compact('experience', 'old'));
    }

    // ──────────────────────────────────────────
    // STEP 1 — POST: Simpan ke session
    // POST /experience/{experience}/booking
    // ──────────────────────────────────────────
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
                'promo_discount' => 0,
                'total_amount'   => $totalAmount,
            ],
        ]);

        return redirect()->route('experience.payment-method');
    }

    // ──────────────────────────────────────────
    // STEP 2 — Payment Method
    // GET /experience/payment-method
    // ──────────────────────────────────────────
    public function paymentMethod()
    {
        $booking = session('exp_booking');
        if (!$booking) {
            return redirect()->route('experience');
        }

        $experience = Experience::findOrFail($booking['experience_id']);

        return view('pages.experience-payment-method', compact('booking', 'experience'));
    }

    // ──────────────────────────────────────────
    // STEP 2 — POST: Simpan payment method, generate Snap Token
    // POST /experience/payment-method
    // ──────────────────────────────────────────
    public function storePaymentMethod(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:QRIS,Virtual Account,Credit Card',
        ]);

        $booking = session('exp_booking');
        if (!$booking) {
            return redirect()->route('experience');
        }

        // Promo code
        $promoDiscount = 0;
        if ($request->filled('promo_code')) {
            // TODO: validasi promo code dari DB
            // if ($request->promo_code === 'ALASARE10') $promoDiscount = 50000;
        }

        // Generate order ID unik untuk Midtrans
        if (empty($booking['pending_ticket_id'])) {
            $booking['pending_ticket_id'] = 'ALS-' . strtoupper(Str::random(8));
        }

        $booking['payment_method'] = $request->payment_method;
        $booking['promo_code']     = $request->promo_code;
        $booking['promo_discount'] = $promoDiscount;
        $booking['total_amount']   = $booking['subtotal'] - $promoDiscount;
        $booking['snap_token']     = null; // akan diisi saat Midtrans aktif

        // ══════════════════════════════════════════════════════
        // MIDTRANS SNAP TOKEN — Uncomment saat akun siap
        // ══════════════════════════════════════════════════════
        //
        // Langkah aktivasi:
        // 1. composer require midtrans/midtrans-php
        // 2. Tambahkan ke .env:
        //    MIDTRANS_SERVER_KEY=SB-Mid-server-xxxx
        //    MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxx
        //    MIDTRANS_IS_PRODUCTION=false
        // 3. Buat file config/midtrans.php (sudah disediakan terpisah)
        // 4. Uncomment blok di bawah ini:
        //
        // try {
        //     \Midtrans\Config::$serverKey    = config('midtrans.server_key');
        //     \Midtrans\Config::$isProduction = config('midtrans.is_production');
        //     \Midtrans\Config::$isSanitized  = true;
        //     \Midtrans\Config::$is3ds        = true;
        //
        //     $params = [
        //         'transaction_details' => [
        //             'order_id'     => $booking['pending_ticket_id'],
        //             'gross_amount' => (int) $booking['total_amount'],
        //         ],
        //         'customer_details' => [
        //             'first_name' => $booking['guest_name'],
        //             'phone'      => $booking['guest_whatsapp'],
        //         ],
        //         'item_details' => [[
        //             'id'       => $booking['experience_id'],
        //             'price'    => (int) Experience::find($booking['experience_id'])->price,
        //             'quantity' => (int) $booking['guest_count'],
        //             'name'     => Experience::find($booking['experience_id'])->name,
        //         ]],
        //         // Filter metode pembayaran sesuai pilihan user:
        //         // 'enabled_payments' => match($request->payment_method) {
        //         //     'QRIS'           => ['gopay', 'shopeepay', 'other_qris'],
        //         //     'Virtual Account'=> ['bca_va', 'bni_va', 'bri_va', 'permata_va'],
        //         //     'Credit Card'    => ['credit_card'],
        //         //     default          => [],
        //         // },
        //     ];
        //
        //     $booking['snap_token'] = \Midtrans\Snap::getSnapToken($params);
        // } catch (\Exception $e) {
        //     \Log::error('Midtrans Snap token error: ' . $e->getMessage());
        // }
        // ══════════════════════════════════════════════════════

        session(['exp_booking' => $booking]);

        return redirect()->route('experience.payment');
    }

    // ──────────────────────────────────────────
    // STEP 3 — Payment Page
    // GET /experience/payment
    // ──────────────────────────────────────────
    public function payment()
    {
        $booking = session('exp_booking');
        if (!$booking || empty($booking['payment_method'])) {
            return redirect()->route('experience.payment-method');
        }

        $experience = Experience::findOrFail($booking['experience_id']);

        // QR placeholder — diganti Midtrans saat aktif
        $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data="
            . urlencode($booking['pending_ticket_id']);

        // snap_token null sampai Midtrans aktif
        $snapToken = $booking['snap_token'] ?? null;

        return view('pages.experience-payment', compact('booking', 'experience', 'qrCodeUrl', 'snapToken'));
    }

    // ──────────────────────────────────────────
    // STEP 3 — POST: Konfirmasi bayar → simpan ke DB
    // POST /experience/payment/confirm
    // ──────────────────────────────────────────
    public function confirmPayment(Request $request)
    {
        $booking = session('exp_booking');
        if (!$booking) {
            return redirect()->route('experience');
        }

        // Cegah double submit — hanya blokir jika ticket_id sama persis
        // (bukan blokir semua booking baru berdasarkan session lama)

        $ticketId = $booking['pending_ticket_id'];

        // Cegah duplicate ticket_id — jika ticket sudah ada di DB
        // (terjadi saat user back/refresh setelah booking berhasil)
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

            session(['exp_booking_confirmed_id' => $expBooking->id]);
            session()->forget('exp_booking');

            return redirect()->route('experience.success');

        } catch (\Exception $e) {
            \Log::error('ExperienceBooking create failed: ' . $e->getMessage());
            return redirect()->route('experience.payment')
                ->with('error', 'Terjadi kesalahan saat menyimpan booking. Silakan coba lagi.');
        }
    }

    // ──────────────────────────────────────────
    // STEP 4 — Success Page
    // GET /experience/success
    // ──────────────────────────────────────────
    public function success()
    {
        $bookingId = session('exp_booking_confirmed_id');
        if (!$bookingId) {
            return redirect()->route('experience');
        }

        $expBooking = ExperienceBooking::with('experience')->findOrFail($bookingId);

        $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data="
            . urlencode($expBooking->ticket_id);

        // Hapus session setelah halaman ditampilkan
        // agar booking berikutnya bisa diproses dengan benar
        session()->forget('exp_booking_confirmed_id');

        return view('pages.experience-success', compact('expBooking', 'qrCodeUrl'));
    }
}