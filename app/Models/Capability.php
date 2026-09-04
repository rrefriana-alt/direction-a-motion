<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capability extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'number', 'title', 'title_id', 'description', 'description_id', 'tags', 'sort_order', 'is_active'];
    protected $casts = ['sort_order' => 'integer', 'is_active' => 'boolean'];

    public function titleLocalized(?string $locale = null): string { $l = $locale ?? app()->getLocale(); return $l === 'id' && !empty($this->title_id) ? $this->title_id : $this->title; }
    public function descLocalized(?string $locale = null): string { $l = $locale ?? app()->getLocale(); return $l === 'id' && !empty($this->description_id) ? $this->description_id : $this->description; }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }
}
