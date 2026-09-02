<?php

namespace Database\Seeders;

use App\Models\Timeline;
use Illuminate\Database\Seeder;

class TimelineSeeder extends Seeder
{
    public function run(): void
    {
        $milestones = [
            ['year' => '2016', 'description' => 'Founded as a merchandise production channel in Bandung.', 'icon' => 'bi-box-seam', 'sort_order' => 1],
            ['year' => '2018', 'description' => 'Production house division opens; first TVC work.', 'icon' => 'bi-camera-reels', 'sort_order' => 2],
            ['year' => '2020', 'description' => 'Incorporated as PT Fugo Creative Group.', 'icon' => 'bi-building', 'sort_order' => 3],
            ['year' => '2022', 'description' => 'Event organizer division formalised.', 'icon' => 'bi-calendar-event', 'sort_order' => 4],
            ['year' => '2024', 'description' => 'Jakarta branch opens; Bali studio follows.', 'icon' => 'bi-geo-alt', 'sort_order' => 5],
            ['year' => '2025', 'description' => '65+ clients across finance, government, automotive and lifestyle.', 'icon' => 'bi-people', 'sort_order' => 6],
            ['year' => '2026', 'description' => 'Artificial Intelligence division launched — agents and automation as the fifth studio.', 'icon' => 'bi-robot', 'sort_order' => 7],
        ];

        foreach ($milestones as $data) {
            $data['is_active'] = true;
            Timeline::create($data);
        }

        $this->command?->info('  Created 7 timeline milestones');
    }
}
