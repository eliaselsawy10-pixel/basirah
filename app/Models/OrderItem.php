<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_price',
        'lens_type',
        'lens_material',
        'lens_price',
        'enhancements',
        'purchase_type',
        'frame_material',
        'frame_color',
        'frame_size',
        'prescription_id',
        'quantity',
        'line_total',
    ];

    protected function casts(): array
    {
        return [
            'product_price' => 'decimal:2',
            'lens_price'    => 'decimal:2',
            'enhancements'  => 'array',
            'line_total'    => 'decimal:2',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function prescription(): BelongsTo
    {
        return $this->belongsTo(Prescription::class);
    }
}
