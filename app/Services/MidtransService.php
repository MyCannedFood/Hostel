<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\PaymentSetting;

class MidtransService
{
    public function __construct()
    {
        $this->configure();
    }

    protected function configure(): void
    {
        $settings = PaymentSetting::instance();

        $serverKey = $settings->midtrans_server_key ?: config('midtrans.server_key');
        $clientKey = $settings->midtrans_client_key ?: config('midtrans.client_key');

        $hasDbKeys = $settings->midtrans_enabled && $settings->midtrans_server_key;
        $isProduction = $hasDbKeys
            ? $settings->midtrans_production
            : config('midtrans.is_production');

        \Midtrans\Config::$serverKey = $serverKey;
        \Midtrans\Config::$clientKey = $clientKey;
        \Midtrans\Config::$isProduction = $isProduction;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    public function createSnapToken(string $orderId, int $amount, array $customerDetails = []): ?string
    {
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => $customerDetails,
        ];

        try {
            return \Midtrans\Snap::createTransaction($params)->token;
        } catch (\Exception $e) {
            \Log::error('Midtrans createSnapToken failed: ' . $e->getMessage());
            return null;
        }
    }

    public function createSnapRedirectUrl(string $orderId, int $amount, array $customerDetails = []): ?string
    {
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => $customerDetails,
        ];

        try {
            return \Midtrans\Snap::createTransaction($params)->redirect_url;
        } catch (\Exception $e) {
            \Log::error('Midtrans createSnapRedirectUrl failed: ' . $e->getMessage());
            return null;
        }
    }

    public static function transactionStatus(string $orderId): ?object
    {
        try {
            return \Midtrans\Transaction::status($orderId);
        } catch (\Exception $e) {
            \Log::error('Midtrans transactionStatus failed: ' . $e->getMessage());
            return null;
        }
    }

    public static function handleNotification(): object
    {
        (new self())->configure();
        return new \Midtrans\Notification();
    }

    public function createAndSavePayment($booking, string $orderId, ?string $snapToken = null): Payment
    {
        return Payment::create([
            'booking_id' => $booking->id,
            'midtrans_order_id' => $orderId,
            'payment_method' => $booking->payment_method,
            'amount' => $booking->total_price,
            'status' => 'pending',
        ]);
    }
}
