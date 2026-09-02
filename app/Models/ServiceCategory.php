<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'title', 'description', 'icon', 'sort_order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function details(): HasMany
    {
        return $this->hasMany(ServiceDetail::class)->where('is_active', true)->orderBy('sort_order');
    }

    public function allDetails(): HasMany
    {
        return $this->hasMany(ServiceDetail::class)->orderBy('sort_order');
    }
}
