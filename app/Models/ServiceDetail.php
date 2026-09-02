<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceDetail extends Model
{
    use HasFactory;

    protected $fillable = ['service_category_id', 'category_name', 'content', 'sort_order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ServiceItem::class)->where('is_active', true)->orderBy('sort_order');
    }

    public function allItems(): HasMany
    {
        return $this->hasMany(ServiceItem::class)->orderBy('sort_order');
    }
}
