<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'payment_id',
        'url',
        'event',
        'payload',
        'response_code',
        'response_body',
        'status',
        'retry_count',
        'last_attempt_at',
    ];

    protected $casts = [
        'payload' => 'json',
        'response_body' => 'json',
        'last_attempt_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
}
