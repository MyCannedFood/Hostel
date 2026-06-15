<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $fillable = [
        'type',
        'code',
        'discount_value',
        'discount_type',
        'start_date',
        'end_date',
        'quota',
        'used',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'discount_value' => 'decimal:2',
    ];

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Apply promo to a given subtotal.
     *
     * @param int|float $subtotal
     * @return array{valid:bool, discount:float, message?:string}
     */
    public function apply(float|int $subtotal): array
    {
        $subtotal = max(0, (float) $subtotal);

        // Status
        if (($this->status ?? null) !== 'active') {
            return [
                'valid' => false,
                'discount' => 0,
                'message' => 'Promo code is not active.',
            ];
        }

        // Date window
        $now = Carbon::now();
        if (!empty($this->start_date) && Carbon::parse($this->start_date)->isFuture()) {
            return [
                'valid' => false,
                'discount' => 0,
                'message' => 'Promo code is not started yet.',
            ];
        }
        if (!empty($this->end_date) && Carbon::parse($this->end_date)->isPast()) {
            return [
                'valid' => false,
                'discount' => 0,
                'message' => 'Promo code has expired.',
            ];
        }

        // Quota check (support both: quota/used or quota/used_count-like)
        $quota = $this->quota ?? null;
        $used = $this->used ?? null;
        if ($quota !== null && (int) $quota > 0) {
            $usedInt = $used !== null ? (int) $used : 0;
            if ($usedInt >= (int) $quota) {
                return [
                    'valid' => false,
                    'discount' => 0,
                    'message' => 'Promo quota has been reached.',
                ];
            }
        }

        // Calculate discount
        $discount = 0.0;
        $discountType = $this->discount_type ?? 'percentage';
        $value = (float) ($this->discount_value ?? 0);

        if ($value <= 0) {
            return [
                'valid' => false,
                'discount' => 0,
                'message' => 'Promo discount value is invalid.',
            ];
        }

        if ($discountType === 'percentage') {
            $discount = $subtotal * ($value / 100);
        } elseif ($discountType === 'flat') {
            $discount = $value;
        } else {
            return [
                'valid' => false,
                'discount' => 0,
                'message' => 'Promo discount type is invalid.',
            ];
        }

        // Cap discount to subtotal
        $discount = max(0.0, min($discount, $subtotal));

        return [
            'valid' => true,
            'discount' => $discount,
        ];
    }
}

