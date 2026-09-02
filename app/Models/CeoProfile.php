<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CeoProfile extends Model
{
    use HasFactory;

    protected $table = 'ceo_profiles';
    protected $fillable = ['photo', 'quote', 'description1', 'description2', 'signature', 'greeting', 'name', 'position', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
