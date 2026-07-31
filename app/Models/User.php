<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ============================================
    // RELASI
    // ============================================

    /**
     * Relasi ke Cart (Keranjang Belanja)
     * Satu user bisa punya satu cart aktif
     */
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    /**
     * Relasi ke CartItem melalui Cart
     * User bisa punya banyak cart items
     */
    public function cartItems()
    {
        return $this->hasManyThrough(CartItem::class, Cart::class);
    }

    /**
     * Relasi ke Orders (Pesanan)
     * User bisa punya banyak pesanan
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relasi ke OrderDetails melalui Order
     * User bisa punya banyak order details
     */
    public function orderDetails()
    {
        return $this->hasManyThrough(OrderDetail::class, Order::class);
    }

    // ============================================
    // HELPER FUNCTIONS
    // ============================================

    /**
     * Ambil atau buat cart aktif untuk user
     */
    public function getActiveCart()
    {
        $cart = $this->cart()->first();
        
        if (!$cart) {
            $cart = new Cart(['user_id' => $this->id]);
            $cart->save();
        }
        
        return $cart;
    }

    /**
     * Hitung total item di cart
     */
    public function getCartTotalItemsAttribute()
    {
        return $this->cartItems()->sum('quantity');
    }

    /**
     * Hitung total harga di cart
     */
    public function getCartTotalPriceAttribute()
    {
        return $this->cartItems()->sum('price');
    }

    // ============================================
    // CEK ROLE
    // ============================================

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isManager()
    {
        return $this->role === 'manager';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    // ============================================
    // ACCESSORS
    // ============================================

    public function getRoleLabelAttribute()
    {
        return match ($this->role) {
            'admin' => '👑 Admin',
            'manager' => '📋 Manager',
            default => '👤 User',
        };
    }

    public function getOrderCountAttribute()
    {
        return $this->orders()->count();
    }

    public function getTotalSpentAttribute()
    {
        return $this->orders()->sum('total_price');
    }
}