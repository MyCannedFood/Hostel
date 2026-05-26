<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetRequestItem extends Model
{
    protected $fillable = [
        'budget_request_id',
        'title',
        'estimated_amount',
        'notes',
        'invoice_path',
        'payment_method',
    ];

    public function budgetRequest()
    {
        return $this->belongsTo(BudgetRequest::class);
    }
}