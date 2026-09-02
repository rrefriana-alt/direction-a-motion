<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function home()
    {
        return view('admin.home-setup');
    }

    public function about()
    {
        return view('admin.about');
    }

    public function contact()
    {
        return view('admin.contact');
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        
        foreach ($data as $key => $value) {
            // Handle file uploads specially
            if ($request->hasFile($key)) {
                $path = $request->file($key)->store('settings', 'public');
                Setting::set($key, '/storage/' . $path);
            } else {
                // If it's an array (like timeline items), json encode it
                if (is_array($value)) {
                    Setting::set($key, json_encode($value));
                } else {
                    Setting::set($key, $value);
                }
            }
        }

        return back()->with('success', 'Settings updated successfully!');
    }
}
