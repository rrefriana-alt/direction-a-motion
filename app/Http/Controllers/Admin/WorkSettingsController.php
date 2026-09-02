<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class WorkSettingsController extends Controller
{
    public function edit()
    {
        $settings = [
            'title' => Setting::get('work_page_title', 'Selected work'),
            'lede'  => Setting::get('work_page_lede', 'Ten projects that show the range: a national TVC, a dealer system used in 200+ locations, a three-day expo, and 12,000 kits shipped on time.'),
        ];

        return view('admin.work-settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'lede'  => 'required|string',
        ]);

        Setting::set('work_page_title', $request->title);
        Setting::set('work_page_lede', $request->lede);

        return redirect()->route('admin.work-settings.edit')->with('success', 'Work page settings berhasil diupdate!');
    }
}
