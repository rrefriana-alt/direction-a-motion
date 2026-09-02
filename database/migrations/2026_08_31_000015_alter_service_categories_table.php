<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_categories', function (Blueprint $table) {
            $table->string('slug')->after('name')->default('');
            $table->string('title')->after('slug')->default('');
            $table->string('icon')->after('title')->nullable();
            $table->integer('sort_order')->after('icon')->default(0);
            $table->boolean('is_active')->after('sort_order')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('service_categories', function (Blueprint $table) {
            $table->dropColumn(['slug', 'title', 'icon', 'sort_order', 'is_active']);
        });
    }
};
