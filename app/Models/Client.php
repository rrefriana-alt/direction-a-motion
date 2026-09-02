<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo', 'category', 'is_active', 'order', 'show_in_carousel'];
    protected $casts = ['is_active' => 'boolean', 'show_in_carousel' => 'boolean'];

    public function scopeForCarousel($query)
    {
        return $query->where('show_in_carousel', true)
                    ->where('is_active', true)
                    ->orderBy('order');
    }
}
