<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use HasFactory;

    protected $fillable = ['value', 'suffix', 'label', 'label_id', 'sort_order', 'is_active'];
    protected $casts = ['is_active' => 'boolean', 'sort_order' => 'integer'];

    public function labelLocalized(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        if ($locale === 'id' && !empty($this->label_id)) return $this->label_id;
        return $this->label;
    }
}
