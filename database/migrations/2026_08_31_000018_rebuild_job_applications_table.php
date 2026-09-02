<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('job_applications');

        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('position');
            $table->enum('education', ['other', 'sma', 'smk', 's1', 's2', 's3', 'd3', 'd4'])->default('other');
            $table->enum('last_job_field', ['other', 'sales', 'marketing', 'finance', 'grafis editor', 'video editor', 'script writer/copy', 'content creator', 'fotografer', 'videografer'])->default('other');
            $table->text('cover_letter');
            $table->string('resume_path');
            $table->string('portfolio_path')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');

        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('position')->nullable();
            $table->string('status')->default('pending');
            $table->string('resume_path')->nullable();
            $table->timestamps();
        });
    }
};
