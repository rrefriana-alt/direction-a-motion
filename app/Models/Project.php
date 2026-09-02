<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'client_name',
        'description',
        'details',
        'modal_content',
        'image',
        'category',
        'year',
        'scope',
        'division',
        'bg_color',
        'accent_color',
        'hero_image',
        'logo',
        'tags',
        'about',
        'lede',
        'steps',
        'stats',
        'gallery',
        'docs',
        'usecases',
        'credits',
        'case_study',
        'result',
        'sort_order',
        'is_active',
        'is_featured',
        'homepage_order',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'is_featured'  => 'boolean',
        'tags'         => 'array',
        'about'        => 'array',
        'steps'        => 'array',
        'stats'        => 'array',
        'gallery'      => 'array',
        'docs'         => 'array',
        'usecases'     => 'array',
        'credits'      => 'array',
    ];

    public function getRouteKeyName(): string
    {
        return 'id';
    }
}
