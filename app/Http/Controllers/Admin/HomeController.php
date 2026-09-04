<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Stat;
use App\Models\Sector;
use App\Models\SectorItem;
use App\Models\ProcessStep;
use App\Models\ServiceCategory;
use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.home.index');
    }

    // ==================== HERO SETTINGS ====================
    public function heroEdit()
    {
        $settings = [
            'tagline_en' => Setting::get('home_hero_tagline_en', Setting::get('home_hero_tagline', '65+ brands trusted us')),
            'tagline_id' => Setting::get('home_hero_tagline_id', Setting::get('home_hero_tagline_en', '65+ brands trusted us')),
            'description_en' => Setting::get('home_hero_description_en', Setting::get('home_hero_description', 'Design · Production House · Events · Merch. An Indonesian creative group since 2016.')),
            'description_id' => Setting::get('home_hero_description_id', 'Desain · Production House · Event · Merch. Grup kreatif Indonesia sejak 2016.'),
            // legacy
            'tagline' => Setting::get('home_hero_tagline', '65+ brands trusted us'),
            'description' => Setting::get('home_hero_description', 'Design · Production House · Events · Merch. An Indonesian creative group since 2016.'),
        ];
        return view('admin.home.hero.edit', compact('settings'));
    }

    public function heroUpdate(Request $request)
    {
        $request->validate([
            'tagline_en' => 'required|string|max:255',
            'tagline_id' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_id' => 'required|string',
        ]);
        Setting::set('home_hero_tagline_en', $request->tagline_en);
        Setting::set('home_hero_tagline_id', $request->tagline_id);
        Setting::set('home_hero_description_en', $request->description_en);
        Setting::set('home_hero_description_id', $request->description_id);
        // keep legacy for fallback
        Setting::set('home_hero_tagline', $request->tagline_en);
        Setting::set('home_hero_description', $request->description_en);
        return redirect()->route('admin.home.hero.edit')->with('success', 'Hero EN/ID berhasil diupdate!');
    }

    // ==================== CAPABILITIES HEADER ====================
    public function capabilitiesHeaderEdit()
    {
        $settings = [
            'title_en' => Setting::get('home_capabilities_title_en', Setting::get('home_capabilities_title', "Five studios,<br>one standard")),
            'title_id' => Setting::get('home_capabilities_title_id', "Lima studio,<br>satu standar"),
            'description_en' => Setting::get('home_capabilities_description_en', Setting::get('home_capabilities_description', 'Brief one team and get the whole chain — strategy, design, film, stage and physical product — without the agency handoff tax.')),
            'description_id' => Setting::get('home_capabilities_description_id', 'Brief satu tim dan dapatkan seluruh rantai — strategi, desain, film, panggung, hingga produk fisik — tanpa biaya estafet antar agensi.'),
            'title' => Setting::get('home_capabilities_title', "Five studios,<br>one standard"),
            'description' => Setting::get('home_capabilities_description', 'Brief one team and get the whole chain — strategy, design, film, stage and physical product — without the agency handoff tax.'),
        ];
        return view('admin.home.capabilities.header-edit', compact('settings'));
    }

    public function capabilitiesHeaderUpdate(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_id' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_id' => 'required|string',
        ]);
        Setting::set('home_capabilities_title_en', $request->title_en);
        Setting::set('home_capabilities_title_id', $request->title_id);
        Setting::set('home_capabilities_description_en', $request->description_en);
        Setting::set('home_capabilities_description_id', $request->description_id);
        Setting::set('home_capabilities_title', $request->title_en);
        Setting::set('home_capabilities_description', $request->description_en);
        return redirect()->route('admin.home.capabilities-header.edit')->with('success', 'Capabilities header EN/ID berhasil diupdate!');
    }

    // ==================== MANIFESTO ====================
    public function manifestoEdit()
    {
        $settings = [
            'subtitle_en' => Setting::get('home_manifesto_subtitle_en', Setting::get('home_manifesto_subtitle', 'MANIFESTO')),
            'subtitle_id' => Setting::get('home_manifesto_subtitle_id', 'MANIFESTO'),
            'title_en' => Setting::get('home_manifesto_title_en', Setting::get('home_manifesto_title', 'Every brief can be solved with *creativity, an *innovative route, and execution that actually lands.')),
            'title_id' => Setting::get('home_manifesto_title_id', 'Setiap brief bisa diselesaikan dengan *kreativitas, *jalur yang inovatif, dan eksekusi yang benar-benar mengena.'),
            'subtitle' => Setting::get('home_manifesto_subtitle', 'MANIFESTO'),
            'title' => Setting::get('home_manifesto_title', 'Every brief can be solved with *creativity, an *innovative route, and execution that actually lands.'),
        ];
        return view('admin.home.manifesto.edit', compact('settings'));
    }

    public function manifestoUpdate(Request $request)
    {
        $request->validate([
            'subtitle_en' => 'required|string|max:255',
            'subtitle_id' => 'required|string|max:255',
            'title_en' => 'required|string',
            'title_id' => 'required|string',
        ]);
        Setting::set('home_manifesto_subtitle_en', $request->subtitle_en);
        Setting::set('home_manifesto_subtitle_id', $request->subtitle_id);
        Setting::set('home_manifesto_title_en', $request->title_en);
        Setting::set('home_manifesto_title_id', $request->title_id);
        Setting::set('home_manifesto_subtitle', $request->subtitle_en);
        Setting::set('home_manifesto_title', $request->title_en);
        return redirect()->route('admin.home.manifesto.edit')->with('success', 'Manifesto EN/ID berhasil diupdate!');
    }

    // ==================== STATS ====================
    public function statsIndex()
    {
        $stats = Stat::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.home.stats.index', compact('stats'));
    }

    public function statsCreate()
    {
        return view('admin.home.stats.create');
    }

    public function statsStore(Request $request)
    {
        $request->validate([
            'value' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'label' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $data = $request->all();
        if (empty($data['sort_order'])) {
            $data['sort_order'] = Stat::max('sort_order') + 1;
        }
        $data['is_active'] = $request->boolean('is_active');
        Stat::create($data);
        return redirect()->route('admin.home.stats.index')->with('success', 'Stat berhasil ditambahkan!');
    }

    public function statsEdit($id)
    {
        $stat = Stat::findOrFail($id);
        return view('admin.home.stats.edit', compact('stat'));
    }

    public function statsUpdate(Request $request, $id)
    {
        $request->validate([
            'value' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'label' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $stat = Stat::findOrFail($id);
        $data = $request->all();
        $data['is_active'] = $request->boolean('is_active');
        $stat->update($data);
        return redirect()->route('admin.home.stats.index')->with('success', 'Stat berhasil diupdate!');
    }

    public function statsDestroy($id)
    {
        Stat::findOrFail($id)->delete();
        return redirect()->route('admin.home.stats.index')->with('success', 'Stat berhasil dihapus!');
    }

    // ==================== SECTORS ====================
    public function sectorsIndex()
    {
        $sectors = Sector::withCount('items')->orderBy('sort_order')->get();
        return view('admin.home.sectors.index', compact('sectors'));
    }

    public function sectorsCreate()
    {
        return view('admin.home.sectors.create');
    }

    public function sectorsStore(Request $request)
    {
        $request->validate([
            'heading_en' => 'required|string|max:255',
            'heading_id' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        try {
            $data = [
                'heading_en' => $request->heading_en,
                'heading_id' => $request->heading_id,
                'sort_order' => $request->sort_order ?? Sector::max('sort_order') + 1,
                'is_active' => $request->boolean('is_active'),
            ];
            $sector = Sector::create($data);

            foreach ($request->items as $index => $itemName) {
                if (trim($itemName) !== '') {
                    $sector->items()->create([
                        'name' => trim($itemName),
                        'sort_order' => $index,
                        'is_active' => true,
                    ]);
                }
            }

            return redirect()->route('admin.home.sectors.index')->with('success', 'Sector berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function sectorsEdit($id)
    {
        $sector = Sector::with('items')->findOrFail($id);
        return view('admin.home.sectors.edit', compact('sector'));
    }

    public function sectorsUpdate(Request $request, $id)
    {
        $request->validate([
            'heading_en' => 'required|string|max:255',
            'heading_id' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        try {
            $sector = Sector::findOrFail($id);
            $sector->update([
                'heading_en' => $request->heading_en,
                'heading_id' => $request->heading_id,
                'sort_order' => $request->sort_order,
                'is_active' => $request->boolean('is_active'),
            ]);

            $sector->items()->delete();
            foreach ($request->items as $index => $itemName) {
                if (trim($itemName) !== '') {
                    $sector->items()->create([
                        'name' => trim($itemName),
                        'sort_order' => $index,
                        'is_active' => true,
                    ]);
                }
            }

            return redirect()->route('admin.home.sectors.index')->with('success', 'Sector berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function sectorsDestroy($id)
    {
        Sector::findOrFail($id)->delete();
        return redirect()->route('admin.home.sectors.index')->with('success', 'Sector berhasil dihapus!');
    }

    // ==================== PROCESS HEADER ====================
    public function processHeaderEdit()
    {
        $settings = [
            'eyebrow_en' => Setting::get('home_process_eyebrow_en', '05 — How we work'),
            'eyebrow_id' => Setting::get('home_process_eyebrow_id', '05 — Cara kami bekerja'),
            'title_en' => Setting::get('home_process_title_en', 'A short line<br>to remarkable'),
            'title_id' => Setting::get('home_process_title_id', 'Garis pendek<br>menuju luar biasa'),
        ];
        return view('admin.home.process.header-edit', compact('settings'));
    }

    public function processHeaderUpdate(Request $request)
    {
        $request->validate([
            'eyebrow_en' => 'required|string|max:255',
            'eyebrow_id' => 'nullable|string|max:255',
            'title_en' => 'required|string',
            'title_id' => 'nullable|string',
        ]);
        Setting::set('home_process_eyebrow_en', $request->eyebrow_en);
        Setting::set('home_process_eyebrow_id', $request->eyebrow_id);
        Setting::set('home_process_title_en', $request->title_en);
        Setting::set('home_process_title_id', $request->title_id);
        return redirect()->route('admin.home.process-header.edit')->with('success', 'Process header berhasil diupdate!');
    }

    // ==================== PROCESS STEPS ====================
    public function processIndex()
    {
        $steps = ProcessStep::orderBy('sort_order')->get();
        return view('admin.home.process.index', compact('steps'));
    }

    public function processCreate()
    {
        return view('admin.home.process.create');
    }

    public function processStore(Request $request)
    {
        $request->validate([
            'step_number' => 'required|integer|min:1|max:10',
            'title_en' => 'required|string|max:255',
            'title_id' => 'nullable|string|max:255',
            'description_en' => 'required|string',
            'description_id' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        try {
            $data = [
                'step_number' => $request->step_number,
                'title_en' => $request->title_en,
                'title_id' => $request->title_id,
                'description_en' => $request->description_en,
                'description_id' => $request->description_id,
                'sort_order' => $request->sort_order ?? ProcessStep::max('sort_order') + 1,
                'is_active' => $request->boolean('is_active'),
            ];
            ProcessStep::create($data);
            return redirect()->route('admin.home.process.index')->with('success', 'Step berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function processEdit($id)
    {
        $step = ProcessStep::findOrFail($id);
        return view('admin.home.process.edit', compact('step'));
    }

    public function processUpdate(Request $request, $id)
    {
        $request->validate([
            'step_number' => 'required|integer|min:1|max:10',
            'title_en' => 'required|string|max:255',
            'title_id' => 'nullable|string|max:255',
            'description_en' => 'required|string',
            'description_id' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        try {
            $step = ProcessStep::findOrFail($id);
            $step->update([
                'step_number' => $request->step_number,
                'title_en' => $request->title_en,
                'title_id' => $request->title_id,
                'description_en' => $request->description_en,
                'description_id' => $request->description_id,
                'sort_order' => $request->sort_order,
                'is_active' => $request->boolean('is_active'),
            ]);
            return redirect()->route('admin.home.process.index')->with('success', 'Step berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function processDestroy($id)
    {
        ProcessStep::findOrFail($id)->delete();
        return redirect()->route('admin.home.process.index')->with('success', 'Step berhasil dihapus!');
    }

    // ==================== FOUNDER QUOTE ====================
    public function founderEdit()
    {
        $settings = [
            'quote' => Setting::get('home_founder_quote', 'Creativity without execution is just a hallucination.'),
            'name' => Setting::get('home_founder_name', 'Sona Lesmana'),
            'title' => Setting::get('home_founder_title', 'Founder & CEO'),
            'image' => Setting::get('home_founder_image', ''),
        ];
        return view('admin.home.founder.edit', compact('settings'));
    }

    public function founderUpdate(Request $request)
    {
        $request->validate([
            'quote' => 'required|string',
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        Setting::set('home_founder_quote', $request->quote);
        Setting::set('home_founder_name', $request->name);
        Setting::set('home_founder_title', $request->title);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'founder_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img'), $imageName);
            Setting::set('home_founder_image', $imageName);
        }

        return redirect()->route('admin.home.founder.edit')->with('success', 'Founder quote berhasil diupdate!');
    }

    // ==================== CTA ====================
    public function ctaEdit()
    {
        $settings = [
            'eyebrow_en' => Setting::get('home_cta_eyebrow_en', Setting::get('home_cta_eyebrow', 'Available for Q4 2026 projects')),
            'eyebrow_id' => Setting::get('home_cta_eyebrow_id', 'Tersedia untuk proyek Q4 2026'),
            'title_en' => Setting::get('home_cta_title_en', Setting::get('home_cta_title', "Let's build<br>something")),
            'title_id' => Setting::get('home_cta_title_id', 'Ayo bangun<br>sesuatu'),
            'eyebrow' => Setting::get('home_cta_eyebrow', 'Available for Q4 2026 projects'),
            'title' => Setting::get('home_cta_title', "Let's build<br>something"),
        ];
        return view('admin.home.cta.edit', compact('settings'));
    }

    public function ctaUpdate(Request $request)
    {
        $request->validate([
            'eyebrow_en' => 'required|string|max:255',
            'eyebrow_id' => 'required|string|max:255',
            'title_en' => 'required|string',
            'title_id' => 'required|string',
        ]);
        Setting::set('home_cta_eyebrow_en', $request->eyebrow_en);
        Setting::set('home_cta_eyebrow_id', $request->eyebrow_id);
        Setting::set('home_cta_title_en', $request->title_en);
        Setting::set('home_cta_title_id', $request->title_id);
        Setting::set('home_cta_eyebrow', $request->eyebrow_en);
        Setting::set('home_cta_title', $request->title_en);
        return redirect()->route('admin.home.cta.edit')->with('success', 'CTA EN/ID berhasil diupdate!');
    }

    // ==================== SERVICES PAGE ====================
    public function servicesPageEdit()
    {
        $settings = [
            'headline_en' => Setting::get('services_page_headline_en', Setting::get('services_page_headline', 'Five studios, one invoice')),
            'headline_id' => Setting::get('services_page_headline_id', 'Lima studio, satu tagihan'),
            'subtitle_en' => Setting::get('services_page_subtitle_en', Setting::get('services_page_subtitle', 'From brand identity to mass production — all delivered under one roof.')),
            'subtitle_id' => Setting::get('services_page_subtitle_id', 'Dari identitas brand hingga produksi massal — semua dalam satu atap.'),
            'headline' => Setting::get('services_page_headline', 'Five studios, one invoice'),
            'subtitle' => Setting::get('services_page_subtitle', 'From brand identity to mass production — all delivered under one roof.'),
        ];
        return view('admin.home.services-page.edit', compact('settings'));
    }

    public function servicesPageUpdate(Request $request)
    {
        $request->validate([
            'headline_en' => 'required|string|max:255',
            'headline_id' => 'required|string|max:255',
            'subtitle_en' => 'required|string',
            'subtitle_id' => 'required|string',
        ]);
        Setting::set('services_page_headline_en', $request->headline_en);
        Setting::set('services_page_headline_id', $request->headline_id);
        Setting::set('services_page_subtitle_en', $request->subtitle_en);
        Setting::set('services_page_subtitle_id', $request->subtitle_id);
        Setting::set('services_page_headline', $request->headline_en);
        Setting::set('services_page_subtitle', $request->subtitle_en);
        return redirect()->route('admin.home.services-page.edit')->with('success', 'Services page EN/ID berhasil diupdate!');
    }

    // ==================== CONTACT PAGE ====================
    public function contactPageEdit()
    {
        $settings = [
            'headline' => Setting::get('contact_page_headline', 'Tell us what you need to land'),
            'subtitle' => Setting::get('contact_page_subtitle', 'Fill out the form and we will get back to you within 1 working day.'),
            'phone' => Setting::get('contact_phone', '+62 821 2100 0680'),
            'email' => Setting::get('contact_email', 'hello@fugocreativegroup.com'),
            'address_bdg' => Setting::get('contact_address_bdg', 'Jl. Permata Taman Sari Raya No.21, Arcamanik, Bandung'),
            'address_jkt' => Setting::get('contact_address_jkt', 'Jl. Srengseng Sawah No.16, Jagakarsa, Jakarta Selatan'),
            'address_bali' => Setting::get('contact_address_bali', 'Jl. Tukad Melangit, Samplangan, Gianyar, Bali'),
        ];
        return view('admin.contact.settings.edit', compact('settings'));
    }

    public function contactPageUpdate(Request $request)
    {
        $request->validate([
            'headline' => 'required|string|max:255',
            'subtitle' => 'required|string',
            'phone' => 'required|string|max:255',
            'email' => 'required|email',
            'address_bdg' => 'required|string',
            'address_jkt' => 'required|string',
            'address_bali' => 'required|string',
        ]);
        Setting::set('contact_page_headline', $request->headline);
        Setting::set('contact_page_subtitle', $request->subtitle);
        Setting::set('contact_phone', $request->phone);
        Setting::set('contact_email', $request->email);
        Setting::set('contact_address_bdg', $request->address_bdg);
        Setting::set('contact_address_jkt', $request->address_jkt);
        Setting::set('contact_address_bali', $request->address_bali);
        return redirect()->route('admin.contact.settings.edit')->with('success', 'Contact page settings berhasil diupdate!');
    }

    // ==================== FOOTER ====================
    public function footerEdit()
    {
        $settings = [
            'description' => Setting::get('footer_description', 'PT Fugo Creative Group — a creative company delivering innovative, high-impact solutions since 2016.'),
            'phone' => Setting::get('footer_phone', '+62 821 2100 0680'),
            'email' => Setting::get('footer_email', 'hello@fugocreativegroup.com'),
            'address_bandung' => Setting::get('footer_address_bandung', 'Jl. Permata Taman Sari Raya No.21, Arcamanik'),
            'address_jakarta' => Setting::get('footer_address_jakarta', 'Jl. Srengseng Sawah No.16, Jagakarsa'),
            'address_bali' => Setting::get('footer_address_bali', 'Jl. Tukad Melangit, Samplangan, Gianyar'),
            'instagram' => Setting::get('footer_instagram', 'https://instagram.com/fugocreative'),
            'linkedin' => Setting::get('footer_linkedin', 'https://id.linkedin.com/company/fugo-creativegroup'),
            'tiktok' => Setting::get('footer_tiktok', 'https://tiktok.com/@fugo.creative'),
            'youtube' => Setting::get('footer_youtube', 'https://youtube.com/@fugocreative'),
        ];
        return view('admin.home.footer.edit', compact('settings'));
    }

    public function footerUpdate(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address_bandung' => 'nullable|string',
            'address_jakarta' => 'nullable|string',
            'address_bali' => 'nullable|string',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'tiktok' => 'nullable|url',
            'youtube' => 'nullable|url',
        ]);
        Setting::set('footer_description', $request->description);
        Setting::set('footer_phone', $request->phone);
        Setting::set('footer_email', $request->email);
        Setting::set('footer_address_bandung', $request->address_bandung);
        Setting::set('footer_address_jakarta', $request->address_jakarta);
        Setting::set('footer_address_bali', $request->address_bali);
        Setting::set('footer_instagram', $request->instagram);
        Setting::set('footer_linkedin', $request->linkedin);
        Setting::set('footer_tiktok', $request->tiktok);
        Setting::set('footer_youtube', $request->youtube);
        return redirect()->route('admin.home.footer.edit')->with('success', 'Footer berhasil diupdate!');
    }
}
