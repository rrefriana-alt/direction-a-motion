<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class JobApplication extends Model { protected $fillable = ['name', 'position', 'status', 'resume_path']; }
