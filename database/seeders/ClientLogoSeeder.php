<?php

namespace Database\Seeders;

use App\Models\ClientLogo;
use Illuminate\Database\Seeder;

class ClientLogoSeeder extends Seeder
{
    public function run(): void
    {
        $logos = [
            ['name' => 'BRI', 'image' => 'bri.webp'],
            ['name' => 'BCA', 'image' => 'bca.webp'],
            ['name' => 'Bank Mandiri', 'image' => 'mandiri.webp'],
            ['name' => 'Mandiri Syariah', 'image' => 'mandirisyariah.webp'],
            ['name' => 'BTPN', 'image' => 'btpn.webp'],
            ['name' => 'Permata Bank', 'image' => 'permatabank.webp'],
            ['name' => 'bjb Syariah', 'image' => 'bjb-syariah.webp'],
            ['name' => 'QRIS', 'image' => 'qris.webp'],
            ['name' => 'AGI', 'image' => 'agi.webp'],
            ['name' => 'Daihatsu', 'image' => 'daihatsu1.webp'],
            ['name' => 'Suzuki', 'image' => 'suzuki.webp'],
            ['name' => 'Jeep', 'image' => 'jeep2.webp'],
            ['name' => 'Citilink', 'image' => 'citylink.webp'],
            ['name' => 'Panorama', 'image' => 'panorama.webp'],
            ['name' => 'Auto2000', 'image' => 'auto.webp'],
            ['name' => 'Jackal Holidays', 'image' => 'JackalHolidays.webp'],
            ['name' => 'Telkomsel', 'image' => 'telkomsel.webp'],
            ['name' => 'BUMN', 'image' => 'bumn.webp'],
            ['name' => 'Pos Indonesia', 'image' => 'pos.webp'],
            ['name' => 'Kemenhub', 'image' => 'Kemenhub.webp'],
            ['name' => 'Kemendag', 'image' => 'kemendag.webp'],
            ['name' => 'PUPR', 'image' => 'PUPR.webp'],
            ['name' => 'LPSK', 'image' => 'LPSK.webp'],
            ['name' => 'Bapenda', 'image' => 'Bapenda.webp'],
            ['name' => 'Pemkab', 'image' => 'Pemkab.webp'],
            ['name' => 'STP Bandung', 'image' => 'STPbdg.webp'],
            ['name' => 'KAI Logistik', 'image' => 'Kailogistik.webp'],
            ['name' => 'PP', 'image' => 'pp.webp'],
            ['name' => 'TUT', 'image' => 'tut.webp'],
            ['name' => 'Bandung Terkini', 'image' => 'bandungterkini1.webp'],
            ['name' => 'Oscar', 'image' => 'Oscar.webp'],
            ['name' => 'Index', 'image' => 'Index.webp'],
            ['name' => 'Demeter', 'image' => 'demeter.webp'],
            ['name' => 'Louella', 'image' => 'Louella.webp'],
            ['name' => 'Kaula', 'image' => 'Kaula.webp'],
            ['name' => 'Lois', 'image' => 'Lois.webp'],
            ['name' => 'Lois Goods', 'image' => 'LoisGoods.webp'],
            ['name' => 'Sahaja', 'image' => 'Sahaja.webp'],
            ['name' => 'Trickburger', 'image' => 'Trickburger.webp'],
            ['name' => 'Sucre', 'image' => 'Sucre.webp'],
            ['name' => 'Royal', 'image' => 'Royal.webp'],
            ['name' => 'Hip', 'image' => 'Hip.webp'],
            ['name' => 'Oval', 'image' => 'Oval.webp'],
            ['name' => 'Giri', 'image' => 'Giri.webp'],
            ['name' => 'Grand Asalam', 'image' => 'grandasalam.webp'],
            ['name' => 'Multiguna', 'image' => 'Multiguna.webp'],
            ['name' => 'Ca Techno', 'image' => 'CaTechno.webp'],
            ['name' => 'Ossmap', 'image' => 'Ossmap.webp'],
        ];

        foreach ($logos as $index => $logo) {
            ClientLogo::updateOrCreate(
                ['name' => $logo['name']],
                [
                    'image' => $logo['image'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
