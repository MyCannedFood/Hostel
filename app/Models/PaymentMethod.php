<?php

// app/Models/PaymentMethod.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'provider_name',
        'account_number',
        'email_username',
        'is_default',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active'  => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function setAsDefault(): void
    {
        static::where('id', '!=', $this->id)->update(['is_default' => false]);
        $this->update(['is_default' => true]);
    }
}