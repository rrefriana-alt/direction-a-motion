<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('process_steps', function (Blueprint $table) {
            $table->string('title_en')->after('step_number');
            $table->string('title_id')->nullable()->after('title_en');
            $table->text('description_en')->after('title_id');
            $table->text('description_id')->nullable()->after('description_en');
        });

        DB::table('process_steps')->orderBy('id')->each(function ($row) {
            DB::table('process_steps')->where('id', $row->id)->update([
                'title_en' => $row->title,
                'description_en' => $row->description,
            ]);
        });

        Schema::table('process_steps', function (Blueprint $table) {
            $table->dropColumn(['title', 'description']);
        });
    }

    public function down(): void
    {
        Schema::table('process_steps', function (Blueprint $table) {
            $table->string('title')->after('step_number');
            $table->text('description')->after('title');
        });

        DB::table('process_steps')->orderBy('id')->each(function ($row) {
            DB::table('process_steps')->where('id', $row->id)->update([
                'title' => $row->title_en,
                'description' => $row->description_en,
            ]);
        });

        Schema::table('process_steps', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'title_id', 'description_en', 'description_id']);
        });
    }
};
