<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportationInfo extends Model
{
    protected $fillable = [
        'icon',
        'title',
        'title_id',
        'description',
        'description_id',
        'routes',
        'routes_id',
        'sort_order',
    ];

    protected $casts = [
        'routes'    => 'array',
        'routes_id' => 'array',
    ];

    /**
     * Get title in the given locale, falling back to English.
     */
    public function getLocalizedTitle(string $locale = 'en'): string
    {
        if ($locale === 'id' && !empty($this->title_id)) {
            return $this->title_id;
        }
        return $this->title;
    }

    /**
     * Get description in the given locale, falling back to English.
     */
    public function getLocalizedDescription(string $locale = 'en'): ?string
    {
        if ($locale === 'id' && !empty($this->description_id)) {
            return $this->description_id;
        }
        return $this->description;
    }

    /**
     * Get routes in the given locale, falling back to English.
     */
    public function getLocalizedRoutes(string $locale = 'en'): array
    {
        if ($locale === 'id' && !empty($this->routes_id)) {
            return $this->routes_id;
        }
        return $this->routes ?? [];
    }
}