<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        \Log::info('Midtrans webhook received', $request->all());

        try {
            $notification = MidtransService::handleNotification();

            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $transactionId = $notification->transaction_id ?? null;
            $paymentType = $notification->payment_type ?? null;
            $fraudStatus = $notification->fraud_status ?? null;

            $payment = Payment::where('midtrans_order_id', $orderId)->first();

            if (!$payment) {
                \Log::warning('Midtrans webhook: payment not found for order ' . $orderId);
                return response()->json(['status' => 'ok']);
            }

            $payment->midtrans_transaction_id = $transactionId;
            $payment->payment_channel = $paymentType;
            $payment->midtrans_response = $request->all();

            $statusMap = [
                'settlement' => 'paid',
                'capture' => 'paid',
                'accept' => 'paid',
                'pending' => 'pending',
                'deny' => 'failed',
                'cancel' => 'failed',
                'expire' => 'expired',
                'failure' => 'failed',
                'refund' => 'refunded',
                'partial_refund' => 'partial_refund',
                'authorize' => 'authorized',
            ];

            $payment->status = $statusMap[$transactionStatus] ?? 'unknown';

            if (in_array($payment->status, ['paid', 'authorized'])) {
                $payment->paid_at = now();
            }

            $payment->save();

            if ($payment->status === 'paid' || $payment->status === 'authorized') {
                $booking = Booking::find($payment->booking_id);
                if ($booking) {
                    // Update status booking menjadi CONFIRMED (karena 'PAID' bukan nilai enum yang sah)
                    if ($booking->status === 'PENDING') {
                        $booking->status = 'CONFIRMED';
                    }
                    
                    // Update metode bayar di booking dengan tipe spesifik dari Midtrans (misal: qris)
                    if ($paymentType) {
                        $booking->payment_method = $paymentType;
                    }
                    
                    $booking->save();
                }
            }

            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            \Log::error('Midtrans webhook error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
