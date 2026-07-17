<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'gateway_transaction_id',
        'gateway',
        'amount',
        'currency',
        'status',
        'response_data',
        'error_message',
    ];

    protected $casts = [
        'response_data' => 'json',
        'amount' => 'decimal:10',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
