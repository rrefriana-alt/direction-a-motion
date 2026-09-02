<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->string('status')->default('New');
            $table->string('resume_path')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('job_applications'); }
};
