<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            ServiceCategorySeeder::class,
            TimelineSeeder::class,
            CeoProfileSeeder::class,
            ProjectsFromCuratedSeeder::class,
            StatisticsSeeder::class,
            StatsSeeder::class,
            CapabilitiesSeeder::class,
            ClientLogoSeeder::class,
            ClientLogoCategorySeeder::class,
            SectorsSeeder::class,
            ProcessStepsSeeder::class,
            MarqueeItemSeeder::class,
        ]);
    }
}
