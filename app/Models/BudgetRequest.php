<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetRequest extends Model
{
    protected $fillable = [
        'request_code',
        'title',
        'type',
        'category',
        'estimated_total_amount',
        'status',
        'approved_at',
        'rejected_at',
        'rejection_reason',
        'notes',
        'requested_by',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(BudgetRequestItem::class);
    }

    public function lpjReports()
    {
        return $this->hasMany(LjpReport::class);
    }
}