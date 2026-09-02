<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PortfolioController extends Controller
{
    public function index()
    {
        $sampleProjects = Project::where('is_active', true)->orderBy('sort_order')->take(2)->get();
        return view('admin.portfolio.index', compact('sampleProjects'));
    }

    public function viewAll()
    {
        $projects = Project::orderBy('sort_order')->get();
        $selectedProjectIds = Project::where('is_active', true)->orderBy('sort_order')->pluck('id')->toArray();
        return view('admin.portfolio.view-all-project.index', compact('projects', 'selectedProjectIds'));
    }

    public function updateViewAll(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                Project::query()->update(['is_active' => false]);
                if ($request->has('project_ids')) {
                    Project::whereIn('id', $request->project_ids)->update(['is_active' => true]);
                    foreach ($request->project_ids as $index => $projectId) {
                        Project::where('id', $projectId)->update(['sort_order' => $index]);
                    }
                }
            });
            return redirect()->back()->with('success', 'Pengaturan project berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
