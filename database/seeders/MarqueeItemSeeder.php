<?php

namespace Database\Seeders;

use App\Models\MarqueeItem;
use Illuminate\Database\Seeder;

class MarqueeItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['text' => 'Create to Elevate'],
            ['text' => 'Design'],
            ['text' => 'Film'],
            ['text' => 'Events'],
            ['text' => 'Merch'],
            ['text' => 'AI'],
        ];

        foreach ($items as $index => $item) {
            MarqueeItem::updateOrCreate(
                ['text' => $item['text']],
                [
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
