<?php

namespace Database\Seeders;

use App\Models\ProcessStep;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class ProcessStepsSeeder extends Seeder
{
    public function run(): void
    {
        $steps = [
            [
                'step_number' => 1,
                'title_en' => 'Listen & frame',
                'title_id' => 'Dengar — rumuskan',
                'description_en' => "We start by rewriting the brief in one sentence. If we can't, we haven't understood the business problem yet.",
                'description_id' => 'Kami mulai dengan menulis ulang brief dalam satu kalimat. Kalau belum bisa, berarti kami belum paham masalah bisnisnya.',
                'sort_order' => 0,
            ],
            [
                'step_number' => 2,
                'title_en' => 'Route options',
                'title_id' => 'Opsi jalur',
                'description_en' => 'Two or three genuinely different creative routes — costed, scheduled, and honest about trade-offs.',
                'description_id' => 'Dua atau tiga jalur kreatif yang benar-benar berbeda — lengkap dengan biaya, jadwal, dan trade-off yang jujur.',
                'sort_order' => 1,
            ],
            [
                'step_number' => 3,
                'title_en' => 'Produce in-house',
                'title_id' => 'Produksi in-house',
                'description_en' => "Design, film, stage and merch under one roof, so revisions don't bounce between vendors.",
                'description_id' => 'Desain, film, panggung, dan merch dalam satu atap, sehingga revisi tidak memantul antar vendor.',
                'sort_order' => 2,
            ],
            [
                'step_number' => 4,
                'title_en' => 'Land it',
                'title_id' => 'Daratkan',
                'description_en' => 'Delivery, on-site supervision and a full asset handover — files you can still use in three years.',
                'description_id' => 'Pengiriman, supervisi di lokasi, dan serah terima aset lengkap — file yang masih bisa dipakai tiga tahun lagi.',
                'sort_order' => 3,
            ],
        ];

        foreach ($steps as $data) {
            ProcessStep::create(array_merge($data, ['is_active' => true]));
        }

        Setting::set('home_process_eyebrow_en', '05 — How we work');
        Setting::set('home_process_eyebrow_id', '05 — Cara kami bekerja');
        Setting::set('home_process_title_en', 'A short line<br>to remarkable');
        Setting::set('home_process_title_id', 'Garis pendek<br>menuju luar biasa');
    }
}
