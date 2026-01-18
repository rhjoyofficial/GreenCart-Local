<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesSummaryDaily extends Model
{
    protected $table = 'sales_summary_daily';

    protected $fillable = ['date', 'total_orders', 'total_amount'];

    protected $casts = [
        'date' => 'date',
        'total_amount' => 'decimal:2'
    ];
}
