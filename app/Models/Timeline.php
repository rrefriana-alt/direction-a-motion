<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;

    protected $fillable = ['year', 'description', 'description_id', 'icon', 'sort_order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function descLocalized(?string $locale = null): string { $l = $locale ?? app()->getLocale(); return $l === 'id' && !empty($this->description_id) ? $this->description_id : $this->description; }
}
