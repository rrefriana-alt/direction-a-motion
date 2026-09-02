<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JsonCmsService;
use Illuminate\Support\Facades\Storage;

class AdminPreviewController extends Controller
{
    protected $cms;

    public function __construct(JsonCmsService $cms)
    {
        $this->cms = $cms;
    }

    public function dashboard()
    {
        // Re-using the static mock for dashboard metrics
        $stats = [
            ['title' => 'Total Projects', 'value' => 24, 'icon' => 'briefcase', 'trend' => '+3', 'color' => 'blue'],
            ['title' => 'Services', 'value' => 8, 'icon' => 'cube', 'trend' => '+1', 'color' => 'emerald'],
            ['title' => 'Clients', 'value' => 42, 'icon' => 'buildings', 'trend' => '+5', 'color' => 'violet'],
            ['title' => 'News Articles', 'value' => 16, 'icon' => 'newspaper', 'trend' => '+2', 'color' => 'amber'],
            ['title' => 'Job Positions', 'value' => 4, 'icon' => 'user-plus', 'trend' => '0', 'color' => 'rose'],
            ['title' => 'Messages', 'value' => 7, 'icon' => 'envelope', 'trend' => '+7', 'color' => 'cyan'],
        ];
        $recentActivities = [
            ['action' => 'Project "BRI Annual Report 2025" published', 'time' => '2 hours ago', 'icon' => 'check-circle', 'color' => 'emerald'],
            ['action' => 'New client "Bank Jatim" added', 'time' => '5 hours ago', 'icon' => 'plus-circle', 'color' => 'blue'],
            ['action' => 'Career position "Motion Designer" updated', 'time' => '1 day ago', 'icon' => 'pencil', 'color' => 'amber'],
        ];
        return view('admin.dashboard', compact('stats', 'recentActivities'));
    }

    public function about()
    {
        $content = $this->cms->getAll();
        $ceo = $content['about']['founder'] ? [
            'name' => 'Sona Lesmana',
            'title' => 'Founder & CEO',
            'quote' => 'We believe in creating experiences that elevate brands beyond boundaries.',
            'image' => ''
        ];
        $timeline = [
            ['id' => 1, 'year' => '2016', 'title' => 'Founded in Bandung', 'description' => 'Started as a small creative studio with a big vision.'],
            ['id' => 2, 'year' => '2019', 'title' => 'Opened Jakarta Office', 'description' => 'Expanded to the capital to serve national clients.'],
        ];
        return view('admin.about', compact('ceo', 'timeline'));
    }

    public function updateAbout(Request $request)
    {
        $about = $this->cms->get('about', []);
        
        $about['founder']['name'] = $request->input('name');
        $about['founder']['title'] = $request->input('title');
        $about['founder']['quote'] = $request->input('quote');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
            $about['founder']['image'] = 'storage/' . $path;
        }

        $this->cms->update('about', $about);
        return redirect()->back()->with('success', 'About section updated successfully!');
    }

    public function homeSetup()
    {
        $content = $this->cms->getAll();
        $sections = $content['home'] ? [];
        
        $carousel = [
            ['id' => 1, 'title' => 'Create to Elevate', 'subtitle' => 'Design · Production House · Events · Merch'],
        ];
        // Reuse mocks for other parts for now
        $clients = [];
        $statistics = [];
        $introduction = ['heading' => '', 'body' => ''];
        $homeServices = [];
        
        return view('admin.home-setup', compact('sections', 'carousel', 'clients', 'statistics', 'introduction', 'homeServices'));
    }

    public function updateHome(Request $request)
    {
        $home = $this->cms->get('home', []);
        
        foreach (range(1, 6) as $i) {
            $key = 'section_0' . $i;
            if ($request->has($key . '_title')) {
                $home[$key]['title'] = $request->input($key . '_title');
            }
            if ($request->has($key . '_subtitle')) {
                $home[$key]['subtitle'] = $request->input($key . '_subtitle');
            }
            if ($request->has($key . '_text')) {
                $home[$key]['text'] = $request->input($key . '_text');
            }
        }

        $this->cms->update('home', $home);
        return redirect()->back()->with('success', 'Home sections updated successfully!');
    }

    // Keep other mock methods
    public function portfolio() { return view('admin.portfolio', ['projects' => [], 'categories' => []]); }
    public function services() { return view('admin.services', ['categories' => []]); }
    public function career() { return view('admin.career', ['positions' => [], 'applications' => [], 'benefits' => []]); }
    public function news() { return view('admin.news', ['articles' => [], 'newsCategories' => []]); }
    public function contact() { return view('admin.contact', ['messages' => [], 'contactInfo' => []]); }
    public function account() { return view('admin.account', ['admins' => []]); }
}
