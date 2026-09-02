<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectsFromCuratedSeeder extends Seeder
{
    public function run(): void
    {
        $curated = require __DIR__.'/../../app/Support/works-data.php';

        foreach ($curated as $i => $item) {
            $existing = Project::where('slug', $item['slug'])->first();
            if ($existing) {
                $this->command?->warn("  Skipping '{$item['slug']}' — already exists (id={$existing->id})");
                continue;
            }

            Project::create([
                'slug'            => $item['slug'],
                'title'           => $item['title'],
                'client_name'     => $item['client'],
                'category'        => match(strtolower($item['category'] ?? '')) {
                    'events'    => 'event',
                    'production'=> 'production',
                    'design'    => 'design',
                    'merch'     => 'merch',
                    default     => 'design',
                },
                'year'            => $item['year'],
                'scope'           => $item['scope'] ?? null,
                'division'        => $item['division'] ?? null,
                'bg_color'        => $item['bg'] ?? '#101722',
                'accent_color'    => $item['accent'] ?? '#3ddc97',
                'logo'            => $item['logo'] ?? null,
                'tags'            => $item['tags'] ?? null,
                'description'     => $item['lede'] ?? null,
                'lede'            => $item['lede'] ?? null,
                'about'           => $item['about'] ?? null,
                'steps'           => $item['steps'] ?? null,
                'stats'           => $item['stats'] ?? null,
                'gallery'         => $item['gallery'] ?? null,
                'docs'            => $item['docs'] ?? null,
                'usecases'        => $item['usecases'] ?? null,
                'credits'         => $item['credits'] ?? null,
                'case_study'      => $item['case_study'] ?? null,
                'result'          => null,
                'sort_order'      => $i + 1,
                'homepage_order'  => $i + 1,
                'is_active'       => true,
                'is_featured'     => true,
            ]);

            $this->command?->info("  Created: {$item['title']} ({$item['slug']})");
        }
    }
}
