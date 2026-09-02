<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $category = $request->get('category', 'all');

        $projects = Project::query()
            ->when($search, fn ($q) => $q->where('title', 'like', '%'.$search.'%'))
            ->when($category !== 'all', fn ($q) => $q->where('category', $category))
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = ['all' => 'All Categories', 'design' => 'Design', 'production' => 'Production', 'event' => 'Events', 'merch' => 'Merch'];

        return view('admin.portfolio.projects.index', compact('projects', 'categories', 'search', 'category'));
    }

    public function create()
    {
        $categories = ['design' => 'Design', 'production' => 'Production', 'event' => 'Events', 'merch' => 'Merch'];

        return view('admin.portfolio.projects.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'client_name'     => 'nullable|string|max:255',
            'category'        => 'required|in:design,production,event,merch',
            'description'     => 'nullable|string',
            'lede'            => 'nullable|string',
            'year'            => 'nullable|string|max:10',
            'scope'           => 'nullable|string',
            'division'        => 'nullable|string',
            'bg_color'        => 'nullable|string|max:7',
            'accent_color'    => 'nullable|string|max:7',
            'tags'            => 'nullable|array',
            'about'           => 'nullable|array',
            'steps'           => 'nullable|array',
            'steps.*.h'       => 'nullable|string',
            'steps.*.p'       => 'nullable|string',
            'stats'           => 'nullable|array',
            'stats.*.n'       => 'nullable|string',
            'stats.*.suffix'  => 'nullable|string',
            'stats.*.l'       => 'nullable|string',
            'gallery'         => 'nullable|array',
            'docs'            => 'nullable|array',
            'docs.*.label'    => 'nullable|string',
            'docs.*.meta'     => 'nullable|string',
            'docs.*.href'     => 'nullable|string',
            'usecases'        => 'nullable|array',
            'usecases.*.h'    => 'nullable|string',
            'usecases.*.p'    => 'nullable|string',
            'credits'         => 'nullable|array',
            'credits.*.role'  => 'nullable|string',
            'credits.*.name'  => 'nullable|string',
            'case_study'      => 'nullable|string',
            'result'          => 'nullable|string',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'hero_image'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'logo'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'sort_order'      => 'nullable|integer',
            'homepage_order'  => 'nullable|integer',
            'is_featured'     => 'sometimes|boolean',
            'is_active'       => 'sometimes|boolean',
        ]);

        $project = Project::create(array_merge($validated, [
            'slug'            => $validated['title'] ? Str::slug($validated['title']) : Str::random(8),
            'sort_order'      => $validated['sort_order'] ?? (Project::max('sort_order') + 1),
            'homepage_order'  => $validated['homepage_order'] ?? 0,
            'is_featured'     => $request->has('is_featured'),
            'is_active'       => $request->has('is_active'),
        ]));

        $this->handleUploads($request, $project);

        return redirect()->route('admin.portfolio.projects.index')->with('success', 'Project berhasil dibuat!');
    }

    public function edit(Project $project)
    {
        $categories = ['design' => 'Design', 'production' => 'Production', 'event' => 'Events', 'merch' => 'Merch'];

        return view('admin.portfolio.projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'client_name'     => 'nullable|string|max:255',
            'category'        => 'required|in:design,production,event,merch',
            'description'     => 'nullable|string',
            'lede'            => 'nullable|string',
            'year'            => 'nullable|string|max:10',
            'scope'           => 'nullable|string',
            'division'        => 'nullable|string',
            'bg_color'        => 'nullable|string|max:7',
            'accent_color'    => 'nullable|string|max:7',
            'tags'            => 'nullable|array',
            'about'           => 'nullable|array',
            'steps'           => 'nullable|array',
            'steps.*.h'       => 'nullable|string',
            'steps.*.p'       => 'nullable|string',
            'stats'           => 'nullable|array',
            'stats.*.n'       => 'nullable|string',
            'stats.*.suffix'  => 'nullable|string',
            'stats.*.l'       => 'nullable|string',
            'gallery'         => 'nullable|array',
            'docs'            => 'nullable|array',
            'docs.*.label'    => 'nullable|string',
            'docs.*.meta'     => 'nullable|string',
            'docs.*.href'     => 'nullable|string',
            'usecases'        => 'nullable|array',
            'usecases.*.h'    => 'nullable|string',
            'usecases.*.p'    => 'nullable|string',
            'credits'         => 'nullable|array',
            'credits.*.role'  => 'nullable|string',
            'credits.*.name'  => 'nullable|string',
            'case_study'      => 'nullable|string',
            'result'          => 'nullable|string',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'hero_image'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'logo'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'sort_order'      => 'nullable|integer',
            'homepage_order'  => 'nullable|integer',
            'is_featured'     => 'sometimes|boolean',
            'is_active'       => 'sometimes|boolean',
        ]);

        $project->update(array_merge($validated, [
            'is_featured'  => $request->has('is_featured'),
            'is_active'    => $request->has('is_active'),
        ]));

        $this->handleUploads($request, $project);

        return redirect()->route('admin.portfolio.projects.index')->with('success', 'Project berhasil diupdate!');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.portfolio.projects.index')->with('success', 'Project berhasil dihapus!');
    }

    public function updateSortOrder(Request $request)
    {
        $request->validate(['order' => 'required|array', 'order.*' => 'integer|exists:projects,id']);

        foreach ($request->order as $index => $projectId) {
            Project::where('id', $projectId)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    protected function handleUploads(Request $request, Project $project): void
    {
        $imgDir = public_path('img/projects/'.$project->id);
        if (! is_dir($imgDir)) {
            mkdir($imgDir, 0755, true);
        }

        if ($request->hasFile('image')) {
            $ext = $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($imgDir, 'card.'.$ext);
            $project->update(['image' => 'projects/'.$project->id.'/card.'.$ext]);
        }

        if ($request->hasFile('hero_image')) {
            $ext = $request->file('hero_image')->getClientOriginalExtension();
            $request->file('hero_image')->move($imgDir, 'hero.'.$ext);
            $project->update(['hero_image' => 'projects/'.$project->id.'/hero.'.$ext]);
        }

        if ($request->hasFile('logo')) {
            $ext = $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->move($imgDir, 'logo.'.$ext);
            $project->update(['logo' => 'projects/'.$project->id.'/logo.'.$ext]);
        }

        if ($request->hasFile('gallery_files')) {
            $galDir = $imgDir.'/gallery';
            if (! is_dir($galDir)) {
                mkdir($galDir, 0755, true);
            }
            $gallery = $project->gallery ?? [];
            foreach ($request->file('gallery_files') as $index => $file) {
                $ext = $file->getClientOriginalExtension();
                $filename = 'gal-'.$index.'.'.$ext;
                $file->move($galDir, $filename);
                if (isset($gallery[$index])) {
                    $gallery[$index]['src'] = 'projects/'.$project->id.'/gallery/'.$filename;
                }
            }
            $project->update(['gallery' => $gallery]);
        }
    }
}
