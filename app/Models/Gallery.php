<?php
// FILE: app/Models/Gallery.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'galleries';

    protected $fillable = [
        'admin_id',
        'image_path',
        'title',
        'category',
        'column_placement',
        'order_number',
        'status',
        'alt_text',
    ];

    /* ── Accessor: URL lengkap gambar ── */
    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image_path);
    }

    /* ── Relasi ── */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /* ── Scopes ── */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeLeftColumn($query)
    {
        return $query->where('column_placement', 'left');
    }

    public function scopeRightColumn($query)
    {
        return $query->where('column_placement', 'right');
    }

    /* ── Konstanta kategori (single source of truth) ── */
    public const CATEGORIES = [
        'spaces'   => 'Spaces',
        'nature'   => 'Nature',
        'dining'   => 'Dining',
        'wellness' => 'Wellness',
        'people'   => 'People',
    ];
}