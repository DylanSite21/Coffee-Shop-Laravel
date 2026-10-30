<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\SupabaseStorageService;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected function appends(): array
    {
        return ['image_url'];
    }

    public function getImageUrlAttribute(): ?string
    {
        return app(SupabaseStorageService::class)
            ->publicUrl($this->image);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
