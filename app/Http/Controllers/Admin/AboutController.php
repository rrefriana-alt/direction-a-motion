<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CeoProfile;
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
}
