<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = ['full_name', 'email', 'phone', 'position', 'education', 'last_job_field', 'cover_letter', 'resume_path', 'portfolio_path', 'status'];

    public function getEducationDisplayAttribute(): string
    {
        return match ($this->education) {
            'sma' => 'SMA/SMK',
            'smk' => 'SMK',
            's1' => 'S1',
            's2' => 'S2',
            's3' => 'S3',
            'd3' => 'D3',
            'd4' => 'D4',
            default => 'Lainnya',
        };
    }

    public function getLastJobFieldDisplayAttribute(): string
    {
        return match ($this->last_job_field) {
            'grafis editor' => 'Grafis Editor',
            'video editor' => 'Video Editor',
            'script writer/copy' => 'Script Writer/Copy',
            'content creator' => 'Content Creator',
            'fotografer' => 'Fotografer',
            'videografer' => 'Videografer',
            default => ucfirst($this->last_job_field),
        };
    }
}
