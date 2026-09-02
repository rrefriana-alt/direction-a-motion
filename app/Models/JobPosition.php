<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JobPosition extends Model
{
    use HasFactory;

    protected $fillable = ['job_title', 'job_department', 'job_description', 'location', 'employment_type', 'experience_level', 'slug', 'sort_order', 'is_active', 'is_open'];
    protected $casts = ['is_active' => 'boolean', 'is_open' => 'boolean'];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->job_title);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('job_title') && !$model->isDirty('slug')) {
                $model->slug = Str::slug($model->job_title);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOpen($query)
    {
        return $query->where('is_open', true);
    }

    public static function getEmploymentTypes(): array
    {
        return ['Full-time', 'Part-time', 'Contract', 'Freelance', 'Internship'];
    }

    public static function getExperienceLevels(): array
    {
        return ['Fresh Graduate', '1+ tahun', '2+ tahun', '3+ tahun', '5+ tahun', '10+ tahun'];
    }
}
