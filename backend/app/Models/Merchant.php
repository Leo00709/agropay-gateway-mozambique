<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'business_email',
        'phone',
        'website',
        'nib',
        'status',
        'commission_rate',
        'balance',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'commission_rate' => 'decimal:4',
        'balance' => 'decimal:10',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function apiKeys()
    {
        return $this->hasMany(ApiKey::class);
    }

    public function webhooks()
    {
        return $this->hasMany(Webhook::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeApproved($query)
    {
        return $query->whereNotNull('approved_at');
    }

    /**
     * Methods
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isApproved()
    {
        return !is_null($this->approved_at);
    }

    public function getTotalTransactionAmount()
    {
        return $this->payments()
            ->where('status', 'completed')
            ->sum('amount');
    }
}
