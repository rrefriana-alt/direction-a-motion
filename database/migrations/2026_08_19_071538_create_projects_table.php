<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('client')->nullable();
            $table->string('category')->nullable();
            $table->string('year')->nullable();
            $table->string('hero_image')->nullable();
            $table->text('challenge')->nullable();
            $table->text('solution')->nullable();
            $table->text('result')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
