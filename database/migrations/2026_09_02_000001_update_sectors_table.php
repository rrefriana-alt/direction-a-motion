<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sectors', function (Blueprint $table) {
            $table->string('heading_en')->after('id');
            $table->string('heading_id')->nullable()->after('heading_en');
        });

        DB::table('sectors')->orderBy('id')->each(function ($row) {
            DB::table('sectors')->where('id', $row->id)->update([
                'heading_en' => $row->heading,
                'heading_id' => $row->heading,
            ]);
        });

        Schema::table('sectors', function (Blueprint $table) {
            $table->dropColumn(['heading', 'clients_text']);
        });
    }

    public function down(): void
    {
        Schema::table('sectors', function (Blueprint $table) {
            $table->string('heading')->after('id');
            $table->text('clients_text');
        });

        DB::table('sectors')->orderBy('id')->each(function ($row) {
            DB::table('sectors')->where('id', $row->id)->update([
                'heading' => $row->heading_en,
            ]);
        });

        Schema::table('sectors', function (Blueprint $table) {
            $table->dropColumn(['heading_en', 'heading_id']);
        });
    }
};
