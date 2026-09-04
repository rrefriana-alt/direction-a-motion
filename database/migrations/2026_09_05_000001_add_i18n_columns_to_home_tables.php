<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stats', function (Blueprint $table) {
            if (!Schema::hasColumn('stats', 'label_id')) {
                $table->string('label_id')->nullable()->after('label');
            }
        });
        Schema::table('capabilities', function (Blueprint $table) {
            if (!Schema::hasColumn('capabilities', 'title_id')) {
                $table->string('title_id')->nullable()->after('title');
            }
            if (!Schema::hasColumn('capabilities', 'description_id')) {
                $table->text('description_id')->nullable()->after('description');
            }
        });
        Schema::table('timelines', function (Blueprint $table) {
            if (!Schema::hasColumn('timelines', 'description_id')) {
                $table->text('description_id')->nullable()->after('description');
            }
        });
        Schema::table('engagement_models', function (Blueprint $table) {
            if (!Schema::hasColumn('engagement_models', 'title_id')) {
                $table->string('title_id')->nullable()->after('title');
            }
            if (!Schema::hasColumn('engagement_models', 'description_id')) {
                $table->text('description_id')->nullable()->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('stats', function (Blueprint $table) {
            if (Schema::hasColumn('stats', 'label_id')) $table->dropColumn('label_id');
        });
        Schema::table('capabilities', function (Blueprint $table) {
            if (Schema::hasColumn('capabilities', 'title_id')) $table->dropColumn('title_id');
            if (Schema::hasColumn('capabilities', 'description_id')) $table->dropColumn('description_id');
        });
        Schema::table('timelines', function (Blueprint $table) {
            if (Schema::hasColumn('timelines', 'description_id')) $table->dropColumn('description_id');
        });
        Schema::table('engagement_models', function (Blueprint $table) {
            if (Schema::hasColumn('engagement_models', 'title_id')) $table->dropColumn('title_id');
            if (Schema::hasColumn('engagement_models', 'description_id')) $table->dropColumn('description_id');
        });
    }
};
