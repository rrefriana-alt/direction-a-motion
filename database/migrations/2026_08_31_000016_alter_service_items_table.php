<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_items', function (Blueprint $table) {
            $table->dropForeign(['service_category_id']);
            $table->dropColumn('service_category_id');
            $table->renameColumn('title', 'item_name');
            $table->foreignId('service_detail_id')->after('id')->constrained()->onDelete('cascade');
            $table->string('image')->nullable()->after('item_name');
            $table->text('description')->nullable()->change();
            $table->integer('sort_order')->default(0)->after('description');
            $table->boolean('is_active')->default(true)->after('sort_order');
        });
    }

    public function down(): void
    {
        Schema::table('service_items', function (Blueprint $table) {
            $table->dropForeign(['service_detail_id']);
            $table->dropColumn('service_detail_id');
            $table->dropColumn(['image', 'sort_order', 'is_active']);
            $table->renameColumn('item_name', 'title');
            $table->foreignId('service_category_id')->constrained()->onDelete('cascade');
        });
    }
};
