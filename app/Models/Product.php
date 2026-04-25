<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category',
        'stock',
        'is_best_seller',
        'material',
        'brand',
        'face_shapes',
        'is_new_arrival',
        'color_family',
        'replacement',
        'frame_materials',
        'frame_colors',
        'frame_sizes',
    ];

    protected function casts(): array
    {
        return [
            'frame_materials' => 'array',
            'frame_colors'    => 'array',
            'frame_sizes'     => 'array',
        ];
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getIsContactLensAttribute()
    {
        return stripos($this->category, 'contact') !== false ||
               stripos($this->name, 'contact') !== false ||
               stripos($this->category, 'color') !== false ||
               stripos($this->name, 'lens') !== false;
    }
}
