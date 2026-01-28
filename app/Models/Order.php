<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'rider_id',
        'total',
        'delivery_fee',
        'tip',
        'distance_km',
        'status',
        'delivery_address',
        'payment_method',
        'assigned_at',
        'picked_up_at',
        'delivered_at',
    ];

    protected $casts = [
        'assigned_at'  => 'datetime',
        'picked_up_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Customer who placed the order
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Rider assigned to deliver
    public function rider(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rider_id');
    }
}
