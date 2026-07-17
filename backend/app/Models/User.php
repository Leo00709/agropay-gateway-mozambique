<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use PHPOpenSourceSaver\JwtAuth\Contracts\JwtSubject;

class User extends Authenticatable implements JwtSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'status',
        'email_verified_at',
        'two_factor_enabled',
        'two_factor_secret',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'two_factor_enabled' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the JWT Subject
     */
    public function getJwtSubject()
    {
        return $this->getKey();
    }

    /**
     * Get JWT custom claims
     */
    public function getJwtCustomClaims()
    {
        return [
            'role' => $this->role,
            'email' => $this->email,
        ];
    }

    /**
     * Relationships
     */
    public function merchants()
    {
        return $this->hasMany(Merchant::class);
    }

    public function apiKeys()
    {
        return $this->hasMany(ApiKey::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeMerchant($query)
    {
        return $query->where('role', 'merchant');
    }

    /**
     * Checks
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isMerchant()
    {
        return $this->role === 'merchant';
    }

    public function isActive()
    {
        return $this->status === 'active';
    }
}
