<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerHero extends Model
{
    use HasFactory;

    protected $table = 'career_hero';
    protected $fillable = ['description', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
