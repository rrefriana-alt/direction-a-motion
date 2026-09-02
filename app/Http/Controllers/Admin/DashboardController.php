<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\News;
use App\Models\JobApplication;
use App\Models\JobPosition;
use App\Models\ServiceCategory;
use App\Models\Message;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProjects = Project::count();
        $totalNews = News::count();
        $totalApplications = JobApplication::count();
        $totalServices = ServiceCategory::count();
        $unreadMessages = Message::where('is_read', false)->count();
        $pendingApplications = JobApplication::where('status', 'pending')->count();

        $recentProjects = Project::latest()->take(5)->get();
        $recentApplications = JobApplication::latest()->take(5)->get();
        $recentNews = News::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProjects', 'totalNews', 'totalApplications', 'totalServices',
            'unreadMessages', 'pendingApplications',
            'recentProjects', 'recentApplications', 'recentNews'
        ));
    }
}
