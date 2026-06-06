<?php

// app/Models/PaymentSetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $fillable = [
        'cash_enabled',
        'cash_instruction',
        'qris_enabled',
        'qris_merchant_id',
        'qris_image_path',
        'midtrans_enabled',
        'midtrans_client_key',
        'midtrans_server_key',
        'midtrans_production',
    ];

    protected $casts = [
        'cash_enabled'        => 'boolean',
        'qris_enabled'        => 'boolean',
        'midtrans_enabled'    => 'boolean',
        'midtrans_production' => 'boolean',
    ];

    /**
     * Always work with a single settings row (singleton pattern).
     */
    public static function instance(): static
    {
        return static::firstOrCreate([], [
            'cash_enabled'     => true,
            'cash_instruction' => 'Please prepare exact cash in IDR upon arrival at the front desk.',
            'qris_enabled'     => false,
            'midtrans_enabled' => false,
        ]);
    }

    // ── Encrypt Midtrans server key at rest ──────────────────────────────
    public function setMidtransServerKeyAttribute(?string $value): void
    {
        $this->attributes['midtrans_server_key'] = $value ? encrypt($value) : null;
    }

    public function getMidtransServerKeyAttribute(?string $value): ?string
    {
        if (!$value) return null;
        try {
            return decrypt($value);
        } catch (\Throwable) {
            return null;
        }
    }
}