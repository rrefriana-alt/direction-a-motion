<?php

namespace Database\Seeders;

use App\Models\Stat;
use Illuminate\Database\Seeder;

class StatsSeeder extends Seeder
{
    public function run(): void
    {
        if (Stat::count() > 0) {
            $this->command?->info('  Stats already seeded, skipping.');
            return;
        }

        $stats = [
            ['value' => '9', 'suffix' => '+', 'label' => 'Years of Execution', 'sort_order' => 1],
            ['value' => '200', 'suffix' => '+', 'label' => 'Projects Delivered', 'sort_order' => 2],
            ['value' => '50', 'suffix' => '+', 'label' => 'Enterprise Clients', 'sort_order' => 3],
            ['value' => '3', 'suffix' => '', 'label' => 'Cities — Bandung, Jakarta, Bali', 'sort_order' => 4],
            ['value' => '5', 'suffix' => '', 'label' => 'Specialist Divisions', 'sort_order' => 5],
        ];

        foreach ($stats as $data) {
            $data['is_active'] = true;
            Stat::create($data);
        }

        $this->command?->info('  Created ' . count($stats) . ' statistics');
    }
}
