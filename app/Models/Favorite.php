<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
    ];

    /**
     * The user who favorited the product.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The favorited product.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
