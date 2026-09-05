<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Setting;
use Illuminate\Http\Request;

class JournalHomeController extends Controller
{
    public const DEFAULTS = [
        'eyebrow_en' => '07 — Journal',
        'eyebrow_id' => '07 — Jurnal',
        'title_en' => 'Notes from<br>the studio',
        'title_id' => 'Catatan dari<br>studio',
        'lede_en' => 'Process notes, project stories and takes on the industry — written by the people who make the work.',
        'lede_id' => 'Catatan proses, cerita proyek, dan pandangan soal industri — ditulis oleh orang-orang yang membuat karyanya.',
        'cta_en' => 'All articles →',
        'cta_id' => 'Semua artikel →',
    ];

    public static function header(string $locale): array
    {
        return [
            'eyebrow' => Setting::localized('home_journal_eyebrow', $locale, self::DEFAULTS['eyebrow_' . $locale] ?? self::DEFAULTS['eyebrow_en']),
            'title' => Setting::localized('home_journal_title', $locale, self::DEFAULTS['title_' . $locale] ?? self::DEFAULTS['title_en']),
            'lede' => Setting::localized('home_journal_lede', $locale, self::DEFAULTS['lede_' . $locale] ?? self::DEFAULTS['lede_en']),
            'cta' => Setting::localized('home_journal_cta', $locale, self::DEFAULTS['cta_' . $locale] ?? self::DEFAULTS['cta_en']),
        ];
    }

    /** ponytail: manual curation is 3 explicit slots (no drag-sort lib).
     *  Upgrade path: add `home_journal_sort_order` table when >100 articles/month. */
    public static function curatedPosts(int $limit = 3)
    {
        $limit = max(1, min(6, $limit));
        if (Setting::get('home_journal_mode', 'auto') === 'manual') {
            $ids = array_values(array_unique(array_filter(array_map(
                'intval',
                (array) (json_decode((string) Setting::get('home_journal_pinned_ids', '[]'), true) ?? [])
            ))));
            if (count($ids) > 0) {
                $byId = News::published()->whereIn('id', $ids)->get()->keyBy('id');
                $ordered = collect($ids)->map(fn ($id) => $byId->get($id))->filter()->values();
                if ($ordered->count() > 0) {
                    return $ordered->take($limit);
                }
            }
        }
        return News::published()->orderByDesc('published_date')->take($limit)->get();
    }

    // ==================== DASHBOARD ====================
    public function index(string $locale)
    {
        $header = self::header($locale);
        $mode = Setting::get('home_journal_mode', 'auto');
        $previewPosts = self::curatedPosts(3);
        $publishedCount = News::published()->count();
        return view('admin.home.journal.index', compact('header', 'mode', 'previewPosts', 'publishedCount', 'locale'));
    }

    // ==================== HEADER ====================
    public function headerEdit(string $locale)
    {
        $settings = [];
        foreach (array_keys(self::DEFAULTS) as $key) {
            $settings[$key] = old($key, Setting::get('home_journal_' . $key, self::DEFAULTS[$key]));
        }
        return view('admin.home.journal.header-edit', compact('settings', 'locale'));
    }

    public function headerUpdate(Request $request, string $locale)
    {
        $request->validate([
            'eyebrow_en' => 'required|string|max:255',
            'eyebrow_id' => 'required|string|max:255',
            'title_en' => 'required|string|max:500',
            'title_id' => 'required|string|max:500',
            'lede_en' => 'required|string|max:1000',
            'lede_id' => 'required|string|max:1000',
            'cta_en' => 'required|string|max:255',
            'cta_id' => 'required|string|max:255',
        ]);
        foreach (['eyebrow', 'title', 'lede', 'cta'] as $field) {
            foreach (['en', 'id'] as $lang) {
                $key = $field . '_' . $lang;
                $value = trim((string) $request->input($key));
                if ($field === 'title') {
                    // ponytail: allow <br> only, strip everything else
                    $value = strip_tags($value, '<br>');
                } else {
                    $value = strip_tags($value);
                }
                Setting::set('home_journal_' . $key, $value);
            }
        }
        return redirect()->route('admin.home.journal.index', ['locale' => $locale])
            ->with('success', 'Journal header berhasil diupdate!');
    }

    // ==================== CURATION ====================
    public function curationEdit(string $locale)
    {
        $mode = Setting::get('home_journal_mode', 'auto');
        $pinnedIds = array_values((array) (json_decode((string) Setting::get('home_journal_pinned_ids', '[]'), true) ?? []));
        $options = News::published()->orderByDesc('published_date')->take(50)->get();
        return view('admin.home.journal.curation', compact('mode', 'pinnedIds', 'options', 'locale'));
    }

    public function curationUpdate(Request $request, string $locale)
    {
        $request->validate([
            'mode' => 'required|in:auto,manual',
            'slot_1' => 'nullable|integer|exists:news,id',
            'slot_2' => 'nullable|integer|exists:news,id',
            'slot_3' => 'nullable|integer|exists:news,id',
        ]);
        $mode = $request->input('mode');
        Setting::set('home_journal_mode', $mode);
        if ($mode === 'manual') {
            $ids = [];
            foreach (['slot_1', 'slot_2', 'slot_3'] as $slot) {
                $id = (int) $request->input($slot);
                if ($id > 0 && !in_array($id, $ids, true)) {
                    // only published articles may be pinned
                    if (News::published()->where('id', $id)->exists()) {
                        $ids[] = $id;
                    }
                }
            }
            Setting::set('home_journal_pinned_ids', json_encode(array_values($ids)));
        }
        return redirect()->route('admin.home.journal.index', ['locale' => $locale])
            ->with('success', 'Kurasi Journal berhasil disimpan!');
    }
}
