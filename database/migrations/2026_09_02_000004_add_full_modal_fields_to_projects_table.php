<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('slug')->unique()->after('id');
            $table->string('year')->nullable()->after('category');
            $table->string('scope')->nullable()->after('year');
            $table->string('division')->nullable()->after('scope');
            $table->string('bg_color')->default('#101722')->after('division');
            $table->string('accent_color')->default('#3ddc97')->after('bg_color');
            $table->string('hero_image')->nullable()->after('accent_color');
            $table->string('logo')->nullable()->after('hero_image');
            $table->json('tags')->nullable()->after('logo');
            $table->text('lede')->nullable()->after('tags');
            $table->json('about')->nullable()->after('lede');
            $table->json('steps')->nullable()->after('about');
            $table->json('stats')->nullable()->after('steps');
            $table->json('gallery')->nullable()->after('stats');
            $table->json('docs')->nullable()->after('gallery');
            $table->json('usecases')->nullable()->after('docs');
            $table->json('credits')->nullable()->after('usecases');
            $table->string('case_study')->nullable()->after('credits');
            $table->text('result')->nullable()->after('case_study');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'slug', 'year', 'scope', 'division', 'bg_color', 'accent_color',
                'hero_image', 'logo', 'tags', 'lede', 'about', 'steps', 'stats',
                'gallery', 'docs', 'usecases', 'credits', 'case_study', 'result',
            ]);
        });
    }
};
