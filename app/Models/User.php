<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'phone',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* =========================
     | Role Helpers (IMPORTANT)
     ========================= */

    public function isAdmin(): bool
    {
        return strtolower((string) $this->role) === 'admin';
    }

    public function isRider(): bool
    {
        return strtolower((string) $this->role) === 'rider';
    }

    public function isCustomer(): bool
    {
        $role = strtolower((string) $this->role);
        return $role === 'customer' || $role === '' || $role === 'user';
    }

    /* =========================
     | Scopes (OPTIONAL CLEAN)
     ========================= */

    public function scopeAdmins($query)
    {
        return $query->whereRaw('LOWER(role) = ?', ['admin']);
    }

    public function scopeRiders($query)
    {
        return $query->whereRaw('LOWER(role) = ?', ['rider']);
    }

    public function scopeCustomers($query)
    {
        return $query->whereIn('role', ['customer', 'user', null]);
    }

    /* =========================
     | Relationships
     ========================= */

    public function customerOrders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function riderOrders()
    {
        return $this->hasMany(Order::class, 'rider_id');
    }
}
