<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    protected $fillable = ['title', 'slug', 'excerpt', 'content', 'featured_image', 'author', 'category', 'read_time', 'published_date', 'is_featured', 'is_published', 'view_count'];
    protected $casts = ['published_date' => 'datetime', 'is_featured' => 'boolean', 'is_published' => 'boolean'];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('title') && !$model->isDirty('slug')) {
                $base = Str::slug($model->title);
                $slug = $base;
                $counter = 1;
                while (static::where('slug', $slug)->where('id', '!=', $model->id)->exists()) {
                    $slug = $base . '-' . $counter++;
                }
                $model->slug = $slug;
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->where('published_date', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->published()->where('is_featured', true);
    }

    public function scopeLatestNews($query, $limit = 5)
    {
        return $query->published()->orderByDesc('published_date')->limit($limit);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->published()->where('category', $category);
    }

    public function getCategoryDisplayAttribute(): string
    {
        return match ($this->category) {
            'company' => 'Company News',
            'industry' => 'Industry',
            'events' => 'Events',
            'updates' => 'Updates',
            'insights' => 'Insights',
            default => ucfirst($this->category),
        };
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
