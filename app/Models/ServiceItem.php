<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceItem extends Model
{
    use HasFactory;

    protected $fillable = ['service_detail_id', 'item_name', 'image', 'description', 'sort_order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function detail(): BelongsTo
    {
        return $this->belongsTo(ServiceDetail::class, 'service_detail_id');
    }
}
