<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_price',
        'status',
        'payment_method',
        'payment_status',
        'shipping_address',
        'notes',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke OrderDetails
    public function items()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Status badge
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => '⏳ Pending',
            'processing' => '🔄 Processing',
            'completed' => '✅ Completed',
            'cancelled' => '❌ Cancelled',
            default => '📦 ' . ucfirst($this->status),
        };
    }

    // Status color
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending' => 'warning',
            'processing' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }
}