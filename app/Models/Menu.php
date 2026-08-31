<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /** @use HasFactory<\Database\Factories\MenuFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',
        'name',
        'description',
        'price',
        'stock',
        'image',
        'status',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
            'is_available' => 'boolean',
        ];
    }

    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image && str_starts_with($this->image, 'storage/')) {
            return asset($this->image);
        }

        return $this->image ? asset('storage/' . $this->image) : asset('images/default-menu.jpg');
    }
}
