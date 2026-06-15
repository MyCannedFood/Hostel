<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PromoCode extends Model
{
    protected $fillable = [
        'code',
        'discount_value',
        'discount_type',
        'start_date',
        'end_date',
        'quota',
        'used_count',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    /**
     * Validate if this promo code is currently usable.
     * Returns ['valid' => true, 'discount' => X] or ['valid' => false, 'message' => '...']
     */
    public function apply(int $subtotal): array
    {
        if ($this->status !== 'active') {
            return ['valid' => false, 'message' => 'Promo code is not active.'];
        }

        $today = Carbon::today();
        if ($today->lt($this->start_date)) {
            return ['valid' => false, 'message' => 'Promo code is not yet valid.'];
        }
        if ($today->gt($this->end_date)) {
            return ['valid' => false, 'message' => 'Promo code has expired.'];
        }

        if ($this->quota > 0 && $this->used_count >= $this->quota) {
            return ['valid' => false, 'message' => 'Promo code quota has been reached.'];
        }

        $discount = $this->discount_type === 'percentage'
            ? (int) round($subtotal * $this->discount_value / 100)
            : (int) $this->discount_value;

        // Discount tidak boleh melebihi subtotal
        $discount = min($discount, $subtotal);

        return ['valid' => true, 'discount' => $discount];
    }

    public function incrementUsed(): void
    {
        $this->increment('used_count');
    }
}