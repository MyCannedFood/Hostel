<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'title',
        'title_en',
        'title_id',
        'content',
        'content_en',
        'content_id',
        'thumbnail',
        'status',
        'category',
        'source',
        'meta_description',
        'views_count',
        'publish_at',
    ];

    protected $casts = [
        'publish_at' => 'datetime',
    ];

    public function getTitleAttribute($value)
    {
        $locale = app()->getLocale();
        $localized = $this->{"title_{$locale}"};
        return $localized ?? $value;
    }

    public function getContentAttribute($value)
    {
        $locale = app()->getLocale();
        $localized = $this->{"content_{$locale}"};
        return $localized ?? $value;
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
