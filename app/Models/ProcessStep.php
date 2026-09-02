<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessStep extends Model
{
    use HasFactory;

    protected $fillable = ['step_number', 'title_en', 'title_id', 'description_en', 'description_id', 'sort_order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
