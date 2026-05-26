<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LjpReport extends Model
{
    protected $table = 'lpj_reports'; // ← wajib karena nama class Ljp bukan Lpj

    protected $fillable = [
        'budget_request_id',
        'request_code',
        'total_estimated_amount',
        'total_actual_amount',
        'status',
        'approved_at',
        'rejection_reason',
        'invoice_path',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function budgetRequest()
    {
        return $this->belongsTo(BudgetRequest::class);
    }
}