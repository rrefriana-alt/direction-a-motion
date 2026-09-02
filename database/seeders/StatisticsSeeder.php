<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stat;

class StatisticsSeeder extends Seeder
{
    public function run()
    {
        $stats = [
            ['value' => '25+', 'suffix' => '', 'label' => 'Years of experience', 'is_active' => true, 'sort_order' => 1],
            ['value' => '500+', 'suffix' => '', 'label' => 'Projects completed', 'is_active' => true, 'sort_order' => 2],
            ['value' => '50+', 'suffix' => '', 'label' => 'Client partners', 'is_active' => true, 'sort_order' => 3],
            ['value' => '10+', 'suffix' => '', 'label' => 'Countries we operate in', 'is_active' => true, 'sort_order' => 4],
        ];

        foreach ($stats as $stat) {
            Stat::create($stat);
        }
    }
}
