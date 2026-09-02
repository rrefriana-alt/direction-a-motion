<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientLogo extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'category', 'sort_order', 'is_active'];
    protected $casts = ['sort_order' => 'integer', 'is_active' => 'boolean'];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }

    public function scopeByCategory(Builder $query, ?string $category): Builder
    {
        if ($category) {
            return $query->where('category', $category);
        }
        return $query;
    }

    public static function categories(): array
    {
        return [
            'finance-banking' => 'Finance & Banking',
            'automotive-transportation' => 'Automotive & Transportation',
            'government-soe' => 'Government & SOE',
            'fashion-lifestyle' => 'Fashion & Lifestyle',
            'food-beverage' => 'Food & Beverage',
            'telco-enterprise' => 'Telco & Enterprise',
            'creative-media' => 'Creative & Media',
            'others' => 'Others',
        ];
    }
}
