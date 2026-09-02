<?php

namespace Database\Seeders;

use App\Models\CeoProfile;
use Illuminate\Database\Seeder;

class CeoProfileSeeder extends Seeder
{
    public function run(): void
    {
        if (CeoProfile::count() === 0) {
            CeoProfile::create([
                'photo' => 'assets/img/Pa-Sona.jpg',
                'quote' => 'Creativity without execution is just a hallucination.',
                'description1' => 'Sona Lesmana founded Fugo Creative in 2016 with a simple belief: creativity without execution is just a hallucination.',
                'description2' => 'Under his leadership, Fugo has grown from a merchandise production channel in Bandung to a five-division creative group with studios in Jakarta and Bali.',
                'signature' => null,
                'greeting' => 'Halo, saya Sona',
                'name' => 'Sona Lesmana',
                'position' => 'Founder & CEO',
                'is_active' => true,
            ]);

            $this->command?->info('  Created CEO profile: Sona Lesmana');
        }
    }
}
