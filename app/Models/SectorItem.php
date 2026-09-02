<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SectorItem extends Model
{
    use HasFactory;

    protected $fillable = ['sector_id', 'name', 'sort_order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }
}
