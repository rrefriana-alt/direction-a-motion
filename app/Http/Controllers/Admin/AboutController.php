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
    public function index()
    {
        return view('admin.about.index');
    }

    public function aboutHeaderEdit()
    {
        $settings = [
            'headline' => Setting::get('about_page_headline', 'A creative group, not a vendor list'),
            'subtitle' => Setting::get('about_page_subtitle', 'We are a Bandung-born creative group with studios in Jakarta and Bali.'),
            'belief_title' => Setting::get('about_belief_title', 'Our belief'),
            'belief_text' => Setting::get('about_belief_text', 'We believe every brief can be solved with creativity, an innovative route, and execution that actually lands.'),
            'belief_elaboration' => Setting::get('about_belief_elaboration', 'That belief drives everything we do — from the smallest social post to the largest national campaign.'),
        ];
        return view('admin.about.settings.edit', compact('settings'));
    }

    public function aboutHeaderUpdate(Request $request)
    {
        $request->validate([
            'headline' => 'required|string|max:255',
            'subtitle' => 'required|string',
            'belief_title' => 'required|string|max:255',
            'belief_text' => 'required|string',
            'belief_elaboration' => 'required|string',
        ]);
        Setting::set('about_page_headline', $request->headline);
        Setting::set('about_page_subtitle', $request->subtitle);
        Setting::set('about_belief_title', $request->belief_title);
        Setting::set('about_belief_text', $request->belief_text);
        Setting::set('about_belief_elaboration', $request->belief_elaboration);
        return redirect()->route('admin.about.settings.edit')->with('success', 'About page settings berhasil diupdate!');
    }

    public function ceoProfile()
    {
        $ceo = CeoProfile::first();
        return view('admin.about.ceo-profile', compact('ceo'));
    }

    public function updateCeoProfile(Request $request)
    {
        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'quote' => 'required|string|max:500',
            'description1' => 'required|string',
            'description2' => 'required|string',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'greeting' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
        ]);

        $ceoProfile = CeoProfile::firstOrNew([]);

        try {
            if ($request->hasFile('photo')) {
                if ($ceoProfile->photo && file_exists(public_path('img/' . $ceoProfile->photo))) {
                    unlink(public_path('img/' . $ceoProfile->photo));
                }
                $photo = $request->file('photo');
                $photoName = 'ceo_' . time() . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('img'), $photoName);
                $validated['photo'] = $photoName;
            } else {
                unset($validated['photo']);
            }

            if ($request->hasFile('signature')) {
                if ($ceoProfile->signature && file_exists(public_path('img/' . $ceoProfile->signature))) {
                    unlink(public_path('img/' . $ceoProfile->signature));
                }
                $signature = $request->file('signature');
                $signatureName = 'signature_' . time() . '.' . $signature->getClientOriginalExtension();
                $signature->move(public_path('img'), $signatureName);
                $validated['signature'] = $signatureName;
            } else {
                unset($validated['signature']);
            }

            $ceoProfile->fill($validated);
            $ceoProfile->save();

            return redirect()->route('admin.about.ceo-profile')->with('success', 'CEO Profile berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function timelineIndex()
    {
        $timelines = Timeline::orderBy('sort_order')->get();
        return view('admin.about.timeline.index', compact('timelines'));
    }

    public function timelineCreate()
    {
        return view('admin.about.timeline.create');
    }

    public function timelineStore(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        try {
            if (empty($validated['sort_order'])) {
                $maxOrder = Timeline::max('sort_order');
                $validated['sort_order'] = $maxOrder ? $maxOrder + 1 : 1;
            }
            Timeline::create($validated);
            return redirect()->route('admin.about.timeline.index')->with('success', 'Timeline berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function timelineEdit(Timeline $timeline)
    {
        return view('admin.about.timeline.edit', compact('timeline'));
    }

    public function timelineUpdate(Request $request, Timeline $timeline)
    {
        $validated = $request->validate([
            'year' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        try {
            $timeline->update($validated);
            return redirect()->route('admin.about.timeline.index')->with('success', 'Timeline berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function timelineDestroy(Timeline $timeline)
    {
        try {
            $timeline->delete();
            return redirect()->route('admin.about.timeline.index')->with('success', 'Timeline berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // ==================== STATISTICS ====================
    public function statisticsIndex()
    {
        $stats = Stat::orderBy('sort_order')->get();
        return view('admin.about.statistics.index', compact('stats'));
    }

    public function statisticsCreate()
    {
        return view('admin.about.statistics.create');
    }

    public function statisticsStore(Request $request)
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
            return redirect()->route('admin.about.statistics.index')->with('success', 'Statistic berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function statisticsEdit(Stat $stat)
    {
        return view('admin.about.statistics.edit', compact('stat'));
    }

    public function statisticsUpdate(Request $request, Stat $stat)
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
            return redirect()->route('admin.about.statistics.index')->with('success', 'Statistic berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function statisticsDestroy(Stat $stat)
    {
        try {
            $stat->delete();
            return redirect()->route('admin.about.statistics.index')->with('success', 'Statistic berhasil dihapus!');
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
    public function sectorIndex()
    {
        $sectors = Sector::with('items')->orderBy('sort_order')->get();
        return view('admin.about.sectors.index', compact('sectors'));
    }

    public function sectorCreate()
    {
        return view('admin.about.sectors.create');
    }

    public function sectorStore(Request $request)
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

            return redirect()->route('admin.about.sectors.index')->with('success', 'Sector berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function sectorEdit(Sector $sector)
    {
        $sector->load('items');
        return view('admin.about.sectors.edit', compact('sector'));
    }

    public function sectorUpdate(Request $request, Sector $sector)
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

            return redirect()->route('admin.about.sectors.index')->with('success', 'Sector berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function sectorDestroy(Sector $sector)
    {
        try {
            $sector->items()->delete();
            $sector->delete();
            return redirect()->route('admin.about.sectors.index')->with('success', 'Sector berhasil dihapus!');
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
