<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class WorkSettingsController extends Controller
{
    public function edit(Request $request)
    {
        $locale = $request->route('locale') ?? 'en';
        $settings = [
            'title' => Setting::localized('work_page_title', $locale, 'Selected work'),
            'title_en' => Setting::get('work_page_title_en', Setting::get('work_page_title', 'Selected work')),
            'title_id' => Setting::get('work_page_title_id', 'Ganti judul — Selected work'),
            'lede'  => Setting::localized('work_page_lede', $locale, 'Ten projects that show the range: a national TVC, a dealer system used in 200+ locations, a three-day expo, and 12,000 kits shipped on time.'),
            'lede_en' => Setting::get('work_page_lede_en', Setting::get('work_page_lede', 'Ten projects')),
            'lede_id' => Setting::get('work_page_lede_id', 'Sepuluh proyek lintas spektrum'),
        ];
        return view('admin.work-settings.edit', compact('settings', 'locale'));
    }

    public function update(Request $request)
    {
        $locale = $request->route('locale') ?? 'en';
        $isEn = $locale === 'en';
        $request->validate([
            'title_en' => ($isEn ? 'required' : 'nullable').'|string|max:255',
            'title_id' => ($isEn ? 'nullable' : 'required').'|string|max:255',
            'lede_en'  => ($isEn ? 'required' : 'nullable').'|string',
            'lede_id'  => ($isEn ? 'nullable' : 'required').'|string',
        ]);
        if ($request->has('title_en')) Setting::set('work_page_title_en', $request->title_en ?? '');
        if ($request->has('title_id')) Setting::set('work_page_title_id', $request->title_id ?? '');
        if ($request->has('lede_en')) Setting::set('work_page_lede_en', $request->lede_en ?? '');
        if ($request->has('lede_id')) Setting::set('work_page_lede_id', $request->lede_id ?? '');
        if ($request->filled('title_en')) Setting::set('work_page_title', $request->title_en);
        if ($request->filled('lede_en')) Setting::set('work_page_lede', $request->lede_en);
        return redirect()->route('admin.work-settings.edit', ['locale'=>$locale])->with('success', 'Work page '.strtoupper($locale).' berhasil diupdate!');
    }
}
