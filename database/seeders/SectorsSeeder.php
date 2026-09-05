<?php

namespace Database\Seeders;

use App\Models\Sector;
use App\Models\SectorItem;
use Illuminate\Database\Seeder;

class SectorsSeeder extends Seeder
{
    public function run(): void
    {
        $sectors = [
            [
                'heading_en' => 'Finance & Banking',
                'heading_id' => 'Keuangan — Perbankan',
                'sort_order' => 0,
                'items' => ['BRI', 'BCA', 'Bank Mandiri', 'BTPN', 'Permata', 'bjb Syariah'],
            ],
            [
                'heading_en' => 'Automotive & Transport',
                'heading_id' => 'Otomotif — Transportasi',
                'sort_order' => 1,
                'items' => ['Daihatsu', 'Suzuki', 'Citilink', 'Jeep'],
            ],
            [
                'heading_en' => 'Government & SOE',
                'heading_id' => 'Pemerintah — BUMN',
                'sort_order' => 2,
                'items' => ['Kemenhub', 'Pos Indonesia', 'BUMN'],
            ],
            [
                'heading_en' => 'Fashion & Lifestyle',
                'heading_id' => 'Fesyen — Gaya Hidup',
                'sort_order' => 3,
                'items' => ['Abigail', 'Demeter', 'Louella', '+10 more'],
            ],
            [
                'heading_en' => 'Food & Beverage',
                'heading_id' => 'Makanan — Minuman',
                'sort_order' => 4,
                'items' => ['Nutrigoat', 'Trickburger', 'Royal'],
            ],
            [
                'heading_en' => 'Telco & Enterprise',
                'heading_id' => 'Telko — Korporasi',
                'sort_order' => 5,
                'items' => ['Telkomsel', 'Developers', 'Corporates'],
            ],
        ];

        foreach ($sectors as $index => $data) {
            $sector = Sector::updateOrCreate(
                ['heading_en' => $data['heading_en']],
                ['heading_id' => $data['heading_id'], 'sort_order' => $data['sort_order'], 'is_active' => true]
            );
            // idempotent items
            $sector->items()->delete();
            foreach ($data['items'] as $itemIndex => $itemName) {
                $sector->items()->create([
                    'name' => $itemName,
                    'sort_order' => $itemIndex,
                    'is_active' => true,
                ]);
            }
        }
    }
}
