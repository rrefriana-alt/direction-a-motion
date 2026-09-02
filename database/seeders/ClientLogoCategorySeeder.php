<?php

namespace Database\Seeders;

use App\Models\ClientLogo;
use Illuminate\Database\Seeder;

class ClientLogoCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Finance & Banking' => [
                'BRI', 'BCA', 'Bank Mandiri', 'Mandiri Syariah',
                'BTPN', 'Permata Bank', 'bjb Syariah', 'QRIS',
            ],
            'Automotive & Transportation' => [
                'Daihatsu', 'Suzuki', 'Jeep', 'Citilink',
                'Auto2000', 'KAI Logistik',
            ],
            'Government & SOE' => [
                'BUMN', 'Pos Indonesia', 'Kemenhub', 'Kemendag',
                'PUPR', 'LPSK', 'Bapenda', 'Pemkab', 'STP Bandung',
            ],
            'Fashion & Lifestyle' => [
                'Demeter', 'Louella', 'Kaula', 'Lois',
                'Lois Goods', 'Sahaja', 'Oscar', 'Index', 'Multiguna',
            ],
            'Food & Beverage' => [
                'Trickburger', 'Sucre', 'Royal', 'Hip', 'Grand Asalam',
            ],
            'Telco & Enterprise' => [
                'Telkomsel', 'AGI', 'Panorama', 'Jackal Holidays',
            ],
            'Creative & Media' => [
                'Bandung Terkini', 'Ca Techno', 'Ossmap', 'Giri', 'Oval',
            ],
            'Others' => [
                'PP', 'TUT',
            ],
        ];

        $slugMap = [
            'Finance & Banking' => 'finance-banking',
            'Automotive & Transportation' => 'automotive-transportation',
            'Government & SOE' => 'government-soe',
            'Fashion & Lifestyle' => 'fashion-lifestyle',
            'Food & Beverage' => 'food-beverage',
            'Telco & Enterprise' => 'telco-enterprise',
            'Creative & Media' => 'creative-media',
            'Others' => 'others',
        ];

        foreach ($categories as $categoryName => $logos) {
            $slug = $slugMap[$categoryName];
            foreach ($logos as $logoName) {
                ClientLogo::where('name', $logoName)->update(['category' => $slug]);
            }
        }
    }
}
