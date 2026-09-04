<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    private array $groups = [
        'home' => [
            'label' => 'Home',
            'icon' => 'house-door',
            'sections' => [
                'hero' => ['label' => 'Hero', 'keys' => ['home_hero_tagline_en','home_hero_tagline_id','home_hero_description_en','home_hero_description_id']],
                'manifesto' => ['label' => 'Manifesto', 'keys' => ['home_manifesto_subtitle_en','home_manifesto_subtitle_id','home_manifesto_title_en','home_manifesto_title_id']],
                'capabilities' => ['label' => 'Capabilities Header', 'keys' => ['home_capabilities_title_en','home_capabilities_title_id','home_capabilities_description_en','home_capabilities_description_id']],
                'cta' => ['label' => 'CTA (Home & Global)', 'keys' => ['home_cta_eyebrow_en','home_cta_eyebrow_id','home_cta_title_en','home_cta_title_id']],
                'process' => ['label' => 'How We Work', 'keys' => ['home_process_eyebrow_en','home_process_eyebrow_id','home_process_title_en','home_process_title_id']],
                'founder' => ['label' => 'Founder Quote', 'keys' => ['home_founder_quote_en','home_founder_quote_id','home_founder_title_en','home_founder_title_id']],
            ],
        ],
        'about' => [
            'label' => 'About',
            'icon' => 'building',
            'sections' => [
                'header' => ['label' => 'Page Header', 'keys' => ['about_page_headline_en','about_page_headline_id','about_page_subtitle_en','about_page_subtitle_id']],
                'belief' => ['label' => 'Our Belief', 'keys' => ['about_belief_title_en','about_belief_title_id','about_belief_text_en','about_belief_text_id','about_belief_elaboration_en','about_belief_elaboration_id']],
            ],
        ],
        'services' => [
            'label' => 'Services',
            'icon' => 'gear',
            'sections' => [
                'header' => ['label' => 'Page Header', 'keys' => ['services_page_headline_en','services_page_headline_id','services_page_subtitle_en','services_page_subtitle_id']],
            ],
        ],
        'work' => [
            'label' => 'Work',
            'icon' => 'briefcase',
            'sections' => [
                'header' => ['label' => 'Page Header', 'keys' => ['work_page_title_en','work_page_title_id','work_page_lede_en','work_page_lede_id']],
            ],
        ],
        'contact' => [
            'label' => 'Contact',
            'icon' => 'envelope',
            'sections' => [
                'header' => ['label' => 'Page Header', 'keys' => ['contact_page_headline_en','contact_page_headline_id','contact_page_subtitle_en','contact_page_subtitle_id']],
                'info' => ['label' => 'Contact Info', 'keys' => ['contact_phone','contact_email']],
            ],
        ],
        'footer' => [
            'label' => 'Footer',
            'icon' => 'layout-text-window',
            'sections' => [
                'general' => ['label' => 'Footer Description', 'keys' => ['footer_description_en','footer_description_id']],
            ],
        ],
    ];

    private array $defaults = [
        'home_hero_tagline_en' => '65+ brands trusted us',
        'home_hero_tagline_id' => '65+ brand mempercayai kami',
        'home_hero_description_en' => 'Design · Production House · Events · Merch. An Indonesian creative group since 2016.',
        'home_hero_description_id' => 'Creative group lokal sejak 2016. Lebih dari 65 brand sudah mempercayakan project mereka pada kami.',
        'home_manifesto_subtitle_en' => 'MANIFESTO',
        'home_manifesto_subtitle_id' => 'MANIFESTO',
        'home_manifesto_title_en' => 'Every brief can be solved with *creativity, an *innovative route, and execution that actually lands.',
        'home_manifesto_title_id' => 'Tiap tantangan bisnis pasti ada solusinya. Kami padukan kreativitas, approach inovatif, dan eksekusi yang on-point.',
        'home_capabilities_title_en' => "Five studios,<br>one standard",
        'home_capabilities_title_id' => "Lima studio,<br>satu standar",
        'home_capabilities_description_en' => 'Brief one team and get the whole chain — strategy, design, film, stage and physical product — without the agency handoff tax.',
        'home_capabilities_description_id' => 'Kasih brief ke satu tim, biar kami yang urus sisanya—dari strategi, desain, produksi video, tata panggung, sampai produk fisik. Bebas pusing koordinasi lintas vendor.',
        'home_cta_eyebrow_en' => 'Available for Q4 2026 projects',
        'home_cta_eyebrow_id' => 'Tersedia untuk proyek Q4 2026',
        'home_cta_title_en' => "Let's build<br>something",
        'home_cta_title_id' => "Mari Ciptakan Sesuatu yang Luar Biasa.",
        'home_process_eyebrow_en' => '05 — How we work',
        'home_process_eyebrow_id' => '05 — Cara kami bekerja',
        'home_process_title_en' => 'A short line<br>to remarkable',
        'home_process_title_id' => 'Garis pendek<br>menuju luar biasa',
        'home_founder_quote_en' => 'Creativity without execution is just a hallucination.',
        'home_founder_quote_id' => 'Fokus kami bawa impact nyata di industri kreatif. Kasih solusi yang berfungsi dulu, baru bicara soal estetika.',
        'home_founder_title_en' => 'Founder & CEO',
        'home_founder_title_id' => 'Pendiri & CEO',
        'about_page_headline_en' => 'A creative group,<br>not a vendor list',
        'about_page_headline_id' => 'Rancang Karya Terbaik Sejak 2016',
        'about_page_subtitle_en' => 'We started in 2016 printing merchandise. Nine years later we run five divisions across three cities — and we still answer the phone ourselves.',
        'about_page_subtitle_id' => 'Buat tim Fugo Creative, tidak ada project yang mustahil. Kami percaya tiap kerjaan selalu ada jalan keluar lewat kreativitas, inovasi, dan eksekusi matang.',
        'about_belief_title_en' => 'Our belief',
        'about_belief_title_id' => 'Keyakinan kami',
        'about_belief_text_en' => 'Every brief can be solved with creativity, an innovative route, and execution that actually lands.',
        'about_belief_text_id' => 'Setiap brief bisa diselesaikan dengan kreativitas, jalur yang inovatif, dan eksekusi yang benar-benar mengena.',
        'about_belief_elaboration_en' => 'We reject the word impossible. Not as a slogan — as a working method: when a route is blocked we go and find the next one, and we tell you what it costs before you commit.',
        'about_belief_elaboration_id' => 'Kami menolak kata tidak mungkin. Bukan slogan — tapi cara kerja: jika satu jalur buntu, kami cari jalur berikutnya, dan kami beri tahu biayanya sebelum Anda komit.',
        'services_page_headline_en' => 'Five studios,<br>one invoice',
        'services_page_headline_id' => 'Lima studio,<br>satu tagihan',
        'services_page_subtitle_en' => 'From brand identity to mass production — all delivered under one roof.',
        'services_page_subtitle_id' => 'Cari tahu solusi kreatif menyeluruh yang dirancang khusus buat maksimalin potensi brand Anda.',
        'work_page_title_en' => 'Selected work',
        'work_page_title_id' => 'Karya pilihan',
        'work_page_lede_en' => 'Ten projects that show the range: a national TVC, a dealer system used in 200+ locations, a three-day expo, and 12,000 kits shipped on time.',
        'work_page_lede_id' => 'Sepuluh proyek yang menunjukkan rentang kami: TVC nasional, sistem dealer di 200+ lokasi, expo tiga hari, dan 12.000 kit terkirim tepat waktu.',
        'contact_page_headline_en' => 'Tell us what you need to land',
        'contact_page_headline_id' => 'Mari Ciptakan Sesuatu yang Luar Biasa.',
        'contact_page_subtitle_en' => 'A short brief is enough to start. We reply within one working day with questions, a route and a rough number — before any meeting.',
        'contact_page_subtitle_id' => 'Punya ide, project baru, atau sekadar mau diskusi soal kebutuhan brand Anda? Tim kami siap dengar.',
        'contact_phone' => '+62 821 2100 0680',
        'contact_email' => 'hello@fugocreativegroup.com',
        'footer_description_en' => 'PT Fugo Creative Group — a creative company delivering innovative, high-impact solutions since 2016.',
        'footer_description_id' => 'PT Fugo Creative Group — perusahaan kreatif yang menghadirkan solusi inovatif dan berdampak sejak 2016.',
    ];

    public function index(Request $request)
    {
        $active = $request->query('tab', 'home');
        if (!isset($this->groups[$active])) $active = 'home';
        $values = [];
        foreach ($this->defaults as $k => $def) {
            $values[$k] = Setting::get($k, $def);
        }
        // also load any extra keys that exist but not in defaults (like contact_phone)
        foreach ($this->groups as $g) {
            foreach ($g['sections'] as $sec) {
                foreach ($sec['keys'] as $k) {
                    if (!isset($values[$k])) $values[$k] = Setting::get($k, '');
                }
            }
        }
        // progress
        $stats = $this->progress($values);
        return view('admin.translations.index', [
            'groups' => $this->groups,
            'active' => $active,
            'values' => $values,
            'stats' => $stats,
        ]);
    }

    public function update(Request $request)
    {
        $rules = [];
        foreach ($this->defaults as $k => $v) {
            // contact phone/email not required to be translated
            if (in_array($k, ['contact_phone','contact_email'])) {
                $rules[$k] = 'nullable|string|max:255';
            } else {
                $rules[$k] = 'nullable|string|max:2000';
            }
        }
        // also allow any keys from groups
        foreach ($this->groups as $g) {
            foreach ($g['sections'] as $sec) {
                foreach ($sec['keys'] as $k) {
                    if (!isset($rules[$k])) $rules[$k] = 'nullable|string|max:2000';
                }
            }
        }
        $validated = $request->validate($rules);
        foreach ($validated as $k => $v) {
            if ($v !== null) Setting::set($k, $v);
        }
        $tab = $request->input('active_tab', 'home');
        return redirect()->route('admin.translations.index', ['tab' => $tab])->with('success', 'Translations berhasil disimpan! EN/ID switching konten aktif di /en dan /id.');
    }

    private function progress(array $values): array
    {
        $out = [];
        foreach ($this->groups as $key => $g) {
            $total = 0; $filled = 0;
            foreach ($g['sections'] as $sec) {
                foreach ($sec['keys'] as $k) {
                    if (str_ends_with($k, '_id')) {
                        $total++;
                        if (!empty(trim($values[$k] ?? ''))) $filled++;
                    }
                }
            }
            $out[$key] = ['total' => $total, 'filled' => $filled, 'pct' => $total ? round($filled/$total*100) : 100];
        }
        return $out;
    }
}
