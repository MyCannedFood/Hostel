<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralLedger extends Model
{
    protected $table = 'general_ledger';

    protected $fillable = [
        'trans_code',
        'lpj_report_id',
        'description',
        'category',
        'type',
        'amount',
    ];

    public function lpjReport()
    {
        return $this->belongsTo(LjpReport::class, 'lpj_report_id');
    }
}