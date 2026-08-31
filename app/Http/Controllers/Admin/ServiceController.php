<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::with('items')->get();
        return view('admin.services.index', compact('categories'));
    }

    public function create()
    {
        // Handled in index page usually, but returning view if needed
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $data = $request->only(['name', 'description']);
        
        if ($request->hasFile('image')) {
            $data['image'] = '/storage/' . $request->file('image')->store('services', 'public');
        }

        $cat = ServiceCategory::create($data);
        
        if ($request->has('items_title')) {
            foreach ($request->items_title as $key => $title) {
                if ($title) {
                    $cat->items()->create([
                        'title' => $title,
                        'description' => $request->items_desc[$key] ?? null
                    ]);
                }
            }
        }
        return back()->with('success', 'Category created.');
    }

    public function edit(ServiceCategory $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, ServiceCategory $service)
    {
        $data = $request->only(['name', 'description']);
        
        if ($request->hasFile('image')) {
            $data['image'] = '/storage/' . $request->file('image')->store('services', 'public');
        }

        $service->update($data);

        // Update items (for simplicity, delete and recreate)
        if ($request->has('items_title')) {
            $service->items()->delete();
            foreach ($request->items_title as $key => $title) {
                if ($title) {
                    $service->items()->create([
                        'title' => $title,
                        'description' => $request->items_desc[$key] ?? null
                    ]);
                }
            }
        }

        return redirect()->route('admin.services.index')->with('success', 'Category updated.');
    }

    public function destroy(ServiceCategory $service)
    {
        $service->delete();
        return back()->with('success', 'Category deleted.');
    }
}
