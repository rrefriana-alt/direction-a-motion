<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo');
            $table->enum('category', [
                'Finance and Banking',
                'Automotive and Transportation',
                'Brand and Small Enterprise',
                'Government and State-Owned Corp',
                'Fashion and Lifestyle',
                'Food and Beverage',
                'Enterprise, Company and Developer',
            ]);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->boolean('show_in_carousel')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
