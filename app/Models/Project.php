<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['title', 'client', 'category', 'year', 'hero_image', 'challenge', 'solution', 'result'];
}
