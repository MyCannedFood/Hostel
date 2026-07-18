<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'author',
        'title',
        'title_en',
        'title_id',
        'content',
        'content_en',
        'content_id',
        'thumbnail',
        'status',
        'category',
        'category_en',
        'source',
        'meta_description',
        'meta_description_en',
        'views_count',
        'publish_at',
    ];

    protected $casts = [
        'publish_at' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
