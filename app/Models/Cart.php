<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_price',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke CartItems
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // Hitung total harga di cart
    public function calculateTotal()
    {
        $total = $this->items()->sum('price');
        $this->update(['total_price' => $total]);
        return $total;
    }

    // Hitung total item di cart
    public function getTotalItemsAttribute()
    {
        return $this->items()->sum('quantity');
    }
}