<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;

    protected $fillable = [
        'order_id',
        'transaction_id',
        'amount',
        'status',
        'payment_gateway_details'
    ];

    protected $casts = [
        'payment_gateway_details' => 'array',
        'amount' => 'decimal:2',
    ];

    public function order(): BelongsTo{
        return $this->belongsTo(Order::class);
    }
}
