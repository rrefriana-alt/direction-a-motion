<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'client' => 'nullable',
            'category' => 'nullable',
            'year' => 'nullable',
            'challenge' => 'nullable',
            'solution' => 'nullable',
            'result' => 'nullable',
            'hero_image' => 'nullable|image'
        ]);

        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = '/storage/' . $request->file('hero_image')->store('projects', 'public');
        }

        Project::create($data);
        return redirect()->route('admin.projects.index')->with('success', 'Project created.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->all();
        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = '/storage/' . $request->file('hero_image')->store('projects', 'public');
        }
        $project->update($data);
        return redirect()->route('admin.projects.index')->with('success', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return back()->with('success', 'Project deleted.');
    }
}
