<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CeoProfile;
use App\Models\Stat;
use App\Models\Sector;
use App\Models\SectorItem;
use App\Models\Setting;
use App\Models\Timeline;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index(string $locale)
    {
        return view('admin.about.index');
    }

    public function aboutHeaderEdit(Request $request)
    {
        $locale = $request->route('locale') ?? 'en';
        $settings = [
            'headline_en' => Setting::get('about_page_headline_en', Setting::get('about_page_headline', 'A creative group, not a vendor list')),
            'headline_id' => Setting::get('about_page_headline_id', 'Grup kreatif, bukan daftar vendor'),
            'subtitle_en' => Setting::get('about_page_subtitle_en', Setting::get('about_page_subtitle', 'We are a Bandung-born creative group with studios in Jakarta and Bali.')),
            'subtitle_id' => Setting::get('about_page_subtitle_id', 'Kami grup kreatif lahir di Bandung dengan studio di Jakarta dan Bali.'),
            'belief_title_en' => Setting::get('about_belief_title_en', Setting::get('about_belief_title', 'Our belief')),
            'belief_title_id' => Setting::get('about_belief_title_id', 'Kepercayaan kami'),
            'belief_text_en' => Setting::get('about_belief_text_en', Setting::get('about_belief_text', 'We believe every brief can be solved with creativity, an innovative route, and execution that actually lands.')),
            'belief_text_id' => Setting::get('about_belief_text_id', 'Kami percaya setiap brief bisa diselesaikan dengan kreativitas, rute inovatif, dan eksekusi yang mengena.'),
            'belief_elaboration_en' => Setting::get('about_belief_elaboration_en', Setting::get('about_belief_elaboration', 'That belief drives everything we do — from the smallest social post to the largest national campaign.')),
            'belief_elaboration_id' => Setting::get('about_belief_elaboration_id', 'Kepercayaan itu mendorong semua yang kami lakukan — dari post terkecil hingga kampanye nasional terbesar.'),
            'headline' => Setting::get('about_page_headline', 'A creative group, not a vendor list'),
            'subtitle' => Setting::get('about_page_subtitle', 'We are a Bandung-born creative group with studios in Jakarta and Bali.'),
            'belief_title' => Setting::get('about_belief_title', 'Our belief'),
            'belief_text' => Setting::get('about_belief_text', 'We believe every brief can be solved with creativity, an innovative route, and execution that actually lands.'),
            'belief_elaboration' => Setting::get('about_belief_elaboration', 'That belief drives everything we do — from the smallest social post to the largest national campaign.'),
        ];
        return view('admin.about.settings.edit', compact('settings', 'locale'));
    }

    public function aboutHeaderUpdate(Request $request, string $locale)
    {
        $locale = $request->route('locale') ?? 'en';
        $isEn = $locale === 'en';
        $request->validate([
            'headline_en' => ($isEn ? 'required' : 'nullable').'|string|max:255',
            'headline_id' => ($isEn ? 'nullable' : 'required').'|string|max:255',
            'subtitle_en' => ($isEn ? 'required' : 'nullable').'|string',
            'subtitle_id' => ($isEn ? 'nullable' : 'required').'|string',
            'belief_title_en' => ($isEn ? 'required' : 'nullable').'|string|max:255',
            'belief_title_id' => ($isEn ? 'nullable' : 'required').'|string|max:255',
            'belief_text_en' => ($isEn ? 'required' : 'nullable').'|string',
            'belief_text_id' => ($isEn ? 'nullable' : 'required').'|string',
            'belief_elaboration_en' => ($isEn ? 'required' : 'nullable').'|string',
            'belief_elaboration_id' => ($isEn ? 'nullable' : 'required').'|string',
        ]);
        if ($request->has('headline_en')) Setting::set('about_page_headline_en', $request->headline_en ?? '');
        if ($request->has('headline_id')) Setting::set('about_page_headline_id', $request->headline_id ?? '');
        if ($request->has('subtitle_en')) Setting::set('about_page_subtitle_en', $request->subtitle_en ?? '');
        if ($request->has('subtitle_id')) Setting::set('about_page_subtitle_id', $request->subtitle_id ?? '');
        if ($request->has('belief_title_en')) Setting::set('about_belief_title_en', $request->belief_title_en ?? '');
        if ($request->has('belief_title_id')) Setting::set('about_belief_title_id', $request->belief_title_id ?? '');
        if ($request->has('belief_text_en')) Setting::set('about_belief_text_en', $request->belief_text_en ?? '');
        if ($request->has('belief_text_id')) Setting::set('about_belief_text_id', $request->belief_text_id ?? '');
        if ($request->has('belief_elaboration_en')) Setting::set('about_belief_elaboration_en', $request->belief_elaboration_en ?? '');
        if ($request->has('belief_elaboration_id')) Setting::set('about_belief_elaboration_id', $request->belief_elaboration_id ?? '');
        if ($request->filled('headline_en')) Setting::set('about_page_headline', $request->headline_en);
        if ($request->filled('subtitle_en')) Setting::set('about_page_subtitle', $request->subtitle_en);
        return redirect()->route('admin.about.settings.edit', ['locale'=>$locale])->with('success', 'About page '.strtoupper($locale).' berhasil diupdate!');
    }

    public function ceoProfile(string $locale)
    {
        $ceo = CeoProfile::first();
        return view('admin.about.ceo-profile', compact('ceo'));
    }

    public function updateCeoProfile(Request $request, string $locale)
    {
        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:25600',
            'quote' => 'required|string|max:500',
            'description1' => 'required|string',
            'description2' => 'required|string',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:25600',
            'greeting' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
        ]);

        $ceoProfile = CeoProfile::firstOrNew([]);

        try {
            $imgDir = public_path('img');
            if (!is_dir($imgDir)) { @mkdir($imgDir, 0775, true); @chmod($imgDir, 0775); }

            $saveImg = function(string $field, string $prefix) use ($request, $ceoProfile, $imgDir) {
                if (!$request->hasFile($field)) return null;
                $file = $request->file($field);
                if (!$file->isValid()) return null;
                $old = $ceoProfile->$field ?? null;
                if ($old && file_exists($imgDir . '/' . $old)) @unlink($imgDir . '/' . $old);
                $ext = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'webp');
                $name = $prefix . '_' . time() . '.' . $ext;
                try { $file->move($imgDir, $name); } catch (\Throwable $e) {
                    $file->storeAs('', $name, 'public_img_fallback');
                    @copy(storage_path('app/public/'.$name), $imgDir.'/'.$name);
                    // fallback disk public not configured for img, try direct public disk
                    if (!file_exists($imgDir.'/'.$name)) {
                        $file->storeAs('ceo', $name, 'public');
                        @copy(storage_path('app/public/ceo/'.$name), $imgDir.'/'.$name);
                    }
                }
                @chmod($imgDir.'/'.$name, 0664);
                return $name;
            };

            if ($request->hasFile('photo')) {
                $n = $saveImg('photo', 'ceo');
                if ($n) $validated['photo'] = $n; else unset($validated['photo']);
            } else {
                unset($validated['photo']);
            }

            if ($request->hasFile('signature')) {
                $n = $saveImg('signature', 'signature');
                if ($n) $validated['signature'] = $n; else unset($validated['signature']);
            } else {
                unset($validated['signature']);
            }

            $ceoProfile->fill($validated);
            $ceoProfile->save();

            return redirect()->route('admin.about.ceo-profile', ['locale'=>$locale])->with('success', 'CEO Profile berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function timelineIndex(string $locale)
    {
        $timelines = Timeline::orderBy('sort_order')->get();
        return view('admin.about.timeline.index', compact('timelines'));
    }

    public function timelineCreate(string $locale)
    {
        return view('admin.about.timeline.create');
    }

    public function timelineStore(Request $request, string $locale)
    {
        $locale = $request->route('locale') ?? 'en';
        $isEn = $locale === 'en';
        $validated = $request->validate([
            'year' => 'required|string|max:255',
            'description_en' => ($isEn ? 'required' : 'nullable').'|string',
            'description_id' => ($isEn ? 'nullable' : 'required').'|string',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);
        try {
            if (empty($validated['sort_order'])) {
                $maxOrder = Timeline::max('sort_order');
                $validated['sort_order'] = $maxOrder ? $maxOrder + 1 : 1;
            }
            $data = [
                'year' => $validated['year'],
                'description' => $validated['description_en'] ?? $validated['description_id'] ?? '',
                'description_id' => $validated['description_id'] ?? null,
                'icon' => $validated['icon'] ?? null,
                'sort_order' => $validated['sort_order'],
            ];
            // store EN in description, ID in description_id ; keep backward compat
            if ($isEn) {
                $data['description'] = $validated['description_en'] ?? '';
                $data['description_id'] = null;
            } else {
                $existingEn = Timeline::where('year', $validated['year'])->value('description') ?? '';
                $data['description'] = $existingEn;
                $data['description_id'] = $validated['description_id'] ?? '';
                // for new entry in ID locale, user supplies ID only, keep EN empty or fallback
                if (empty($data['description'])) $data['description'] = $validated['description_id'] ?? '';
            }
            // when storing via locale, keep EN/ID correctly
            if (isset($validated['description_en'])) $data['description'] = $validated['description_en'];
            if (isset($validated['description_id'])) $data['description_id'] = $validated['description_id'];
            Timeline::create($data);
            return redirect()->route('admin.about.timeline.index', ['locale'=>$locale])->with('success', 'Timeline berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function timelineEdit(string $locale, Timeline $timeline)
    {
        return view('admin.about.timeline.edit', compact('timeline'));
    }

    public function timelineUpdate(Request $request, string $locale, Timeline $timeline)
    {
        $locale = $request->route('locale') ?? 'en';
        $isEn = $locale === 'en';
        $validated = $request->validate([
            'year' => 'required|string|max:255',
            'description_en' => ($isEn ? 'required' : 'nullable').'|string',
            'description_id' => ($isEn ? 'nullable' : 'required').'|string',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);
        try {
            $data = [
                'year' => $validated['year'],
                'icon' => $validated['icon'] ?? $timeline->icon,
                'sort_order' => $validated['sort_order'] ?? $timeline->sort_order,
            ];
            if ($isEn) {
                $data['description'] = $validated['description_en'] ?? $timeline->description;
                $data['description_id'] = $timeline->description_id;
            } else {
                $data['description'] = $timeline->description;
                $data['description_id'] = $validated['description_id'] ?? $timeline->description_id;
            }
            $timeline->update($data);
            return redirect()->route('admin.about.timeline.index', ['locale'=>$locale])->with('success', 'Timeline berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function timelineDestroy(string $locale, Timeline $timeline)
    {
        try {
            $timeline->delete();
            return redirect()->route('admin.about.timeline.index', ['locale'=>$locale])->with('success', 'Timeline berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // ==================== STATISTICS ====================
    public function statisticsIndex(string $locale)
    {
        $stats = Stat::orderBy('sort_order')->get();
        return view('admin.about.statistics.index', compact('stats'));
    }

    public function statisticsCreate(string $locale)
    {
        return view('admin.about.statistics.create');
    }

    public function statisticsStore(Request $request, string $locale)
    {
        $validated = $request->validate([
            'value' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:50',
            'label' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable',
        ]);

        try {
            if (empty($validated['sort_order'])) {
                $maxOrder = Stat::max('sort_order');
                $validated['sort_order'] = $maxOrder ? $maxOrder + 1 : 1;
            }
            $validated['is_active'] = $request->boolean('is_active', true);
            Stat::create($validated);
            return redirect()->route('admin.about.statistics.index', ['locale'=>$locale])->with('success', 'Statistic berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function statisticsEdit(string $locale, Stat $stat)
    {
        return view('admin.about.statistics.edit', compact('stat'));
    }

    public function statisticsUpdate(Request $request, string $locale, Stat $stat)
    {
        $validated = $request->validate([
            'value' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:50',
            'label' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable',
        ]);

        try {
            $validated['is_active'] = $request->boolean('is_active', true);
            $stat->update($validated);
            return redirect()->route('admin.about.statistics.index', ['locale'=>$locale])->with('success', 'Statistic berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function statisticsDestroy(string $locale, Stat $stat)
    {
        try {
            $stat->delete();
            return redirect()->route('admin.about.statistics.index', ['locale'=>$locale])->with('success', 'Statistic berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function statisticsReorder(Request $request)
    {
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:stats,id',
        ]);

        try {
            foreach ($validated['order'] as $index => $statId) {
                Stat::where('id', $statId)->update(['sort_order' => $index + 1]);
            }
            return response()->json(['success' => true, 'message' => 'Urutan berhasil diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function statisticsToggle(Stat $stat)
    {
        $stat->update(['is_active' => !$stat->is_active]);
        return response()->json(['success' => true, 'is_active' => $stat->is_active]);
    }

    // ==================== SECTORS ====================
    public function sectorIndex(string $locale)
    {
        $sectors = Sector::with('items')->orderBy('sort_order')->get();
        return view('admin.about.sectors.index', compact('sectors'));
    }

    public function sectorCreate(string $locale)
    {
        return view('admin.about.sectors.create');
    }

    public function sectorStore(Request $request, string $locale)
    {
        $validated = $request->validate([
            'heading_en' => 'required|string|max:255',
            'heading_id' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable',
            'items' => 'nullable|array',
            'items.*.name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string',
            'items.*.icon' => 'nullable|string|max:255',
            'items.*.sort_order' => 'nullable|integer',
            'items.*.is_active' => 'nullable',
        ]);

        try {
            $validated['is_active'] = $request->boolean('is_active', true);
            if (empty($validated['sort_order'])) {
                $maxOrder = Sector::max('sort_order');
                $validated['sort_order'] = $maxOrder ? $maxOrder + 1 : 1;
            }
            $sector = Sector::create($validated);

            if (isset($validated['items'])) {
                foreach ($validated['items'] as $item) {
                    if (!empty($item['name'])) {
                        $sector->items()->create([
                            'name' => $item['name'],
                            'description' => $item['description'] ?? '',
                            'icon' => $item['icon'] ?? 'bi-circle',
                            'sort_order' => $item['sort_order'] ?? 0,
                            'is_active' => $request->boolean('items.' . array_search($item, $validated['items']) . '.is_active', true),
                        ]);
                    }
                }
            }

            return redirect()->route('admin.about.sectors.index', ['locale'=>$locale])->with('success', 'Sector berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function sectorEdit(string $locale, Sector $sector)
    {
        $sector->load('items');
        return view('admin.about.sectors.edit', compact('sector'));
    }

    public function sectorUpdate(Request $request, string $locale, Sector $sector)
    {
        $validated = $request->validate([
            'heading_en' => 'required|string|max:255',
            'heading_id' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable',
            'items' => 'nullable|array',
            'items.*.name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string',
            'items.*.icon' => 'nullable|string|max:255',
            'items.*.sort_order' => 'nullable|integer',
            'items.*.is_active' => 'nullable',
        ]);

        try {
            $validated['is_active'] = $request->boolean('is_active', true);
            $sector->update($validated);

            // Sync items
            $existingItemIds = $sector->items->pluck('id')->toArray();
            $newItemIds = collect($validated['items'] ?? [])->pluck('id')->filter()->toArray();

            // Delete removed items
            $removedIds = array_diff($existingItemIds, $newItemIds);
            if (!empty($removedIds)) {
                SectorItem::whereIn('id', $removedIds)->delete();
            }

            // Update or create items
            if (isset($validated['items'])) {
                foreach ($validated['items'] as $key => $item) {
                    if (!empty($item['name'])) {
                        $itemData = [
                            'sector_id' => $sector->id,
                            'name' => $item['name'],
                            'description' => $item['description'] ?? '',
                            'icon' => $item['icon'] ?? 'bi-circle',
                            'sort_order' => $item['sort_order'] ?? 0,
                            'is_active' => $request->boolean('items.' . $key . '.is_active', true),
                        ];

                        if (isset($item['id']) && $item['id']) {
                            // Update existing item
                            $existingItem = SectorItem::find($item['id']);
                            if ($existingItem && $existingItem->sector_id === $sector->id) {
                                $existingItem->update($itemData);
                            }
                        } else {
                            // Create new item
                            $sector->items()->create($itemData);
                        }
                    }
                }
            }

            return redirect()->route('admin.about.sectors.index', ['locale'=>$locale])->with('success', 'Sector berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function sectorDestroy(string $locale, Sector $sector)
    {
        try {
            $sector->items()->delete();
            $sector->delete();
            return redirect()->route('admin.about.sectors.index', ['locale'=>$locale])->with('success', 'Sector berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function sectorReorder(Request $request)
    {
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:sectors,id',
        ]);

        try {
            foreach ($validated['order'] as $index => $sectorId) {
                Sector::where('id', $sectorId)->update(['sort_order' => $index + 1]);
            }
            return response()->json(['success' => true, 'message' => 'Urutan sector berhasil diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function sectorToggle(Sector $sector)
    {
        $sector->update(['is_active' => !$sector->is_active]);
        return response()->json(['success' => true, 'is_active' => $sector->is_active]);
    }
}
