<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::with('items')->get();
        return view('admin.services.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $cat = ServiceCategory::create($request->only(['name', 'description']));
        
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

    public function destroy(ServiceCategory $service)
    {
        $service->delete();
        return back()->with('success', 'Category deleted.');
    }
}
