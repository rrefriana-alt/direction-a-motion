<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerBenefit extends Model
{
    use HasFactory;

    protected $table = 'career_benefits';
    protected $fillable = ['benefit_title', 'description', 'icon_class', 'sort_order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function getIconClasses(): array
    {
        return [
            'bi-gem', 'bi-shield-check', 'bi-laptop', 'bi-palette',
            'bi-people', 'bi-graph-up-arrow', 'bi-lightning-charge',
            'bi-cup-hot', 'bi-geo-alt', 'bi-clock-history',
            'bi-mortarboard', 'bi-heart-pulse', 'bi-trophy',
            'bi-cash-coin', 'bi-airplane', 'bi-calendar-event',
            'bi-headset', 'bi-book', 'bi-rocket-takeoff', 'bi-star',
        ];
    }
}
