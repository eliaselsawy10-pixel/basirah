<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prescription extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'od_sph',
        'od_cyl',
        'od_axis',
        'os_sph',
        'os_cyl',
        'os_axis',
        'od_bc',
        'od_dia',
        'os_bc',
        'os_dia',
        'pd_value',
        'type',
        'status',
    ];

    /* ── Relationships ─────────────────────────────── */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /* ── Scopes ─────────────────────────────────────── */

    public function scopeEyeglasses($query)
    {
        return $query->where('type', 'eyeglasses');
    }

    public function scopeContacts($query)
    {
        return $query->where('type', 'contact');
    }

    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }

    public function scopeOrdered($query)
    {
        return $query->where('status', 'ordered');
    }

    /* ── Helpers ─────────────────────────────────────── */

    /**
     * Transition the prescription status to 'ordered'.
     * Called after a successful order placement.
     */
    public function markAsOrdered(): bool
    {
        return $this->update(['status' => 'ordered']);
    }
}
