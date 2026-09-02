<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Capability;
use Illuminate\Http\Request;

class CapabilitiesController extends Controller
{
    public function index()
    {
        $capabilities = Capability::query()->orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.home.capabilities.index', compact('capabilities'));
    }

    public function create()
    {
        return view('admin.home.capabilities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tags' => 'nullable|string',
            'number' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'sort_order' => 'nullable|integer',
        ]);

        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('img'), $imageName);
                $validated['image'] = $imageName;
            }

            if (!empty($validated['tags'])) {
                $tags = array_map('trim', explode(',', $validated['tags']));
                $validated['tags'] = json_encode($tags);
            }

            if (empty($validated['sort_order'])) {
                $maxOrder = Capability::max('sort_order');
                $validated['sort_order'] = $maxOrder ? $maxOrder + 1 : 1;
            }

            $validated['number'] = $validated['number'] ?? 0;

            Capability::create($validated);
            return redirect()->route('admin.home.capabilities.index')->with('success', 'Capability created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Capability $capability)
    {
        return view('admin.home.capabilities.edit', compact('capability'));
    }

    public function update(Request $request, Capability $capability)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tags' => 'nullable|string',
            'number' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'sort_order' => 'nullable|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        try {
            if ($request->hasFile('image')) {
                if ($capability->image && file_exists(public_path('img/' . $capability->image))) {
                    unlink(public_path('img/' . $capability->image));
                }
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('img'), $imageName);
                $validated['image'] = $imageName;
            } else {
                unset($validated['image']);
            }

            if (array_key_exists('tags', $validated)) {
                if (!empty($validated['tags'])) {
                    $tags = array_map('trim', explode(',', $validated['tags']));
                    $validated['tags'] = json_encode($tags);
                } else {
                    $validated['tags'] = null;
                }
            }

            $validated['is_active'] = $request->has('is_active');
            $capability->update($validated);
            return redirect()->route('admin.home.capabilities.index')->with('success', 'Capability updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Capability $capability)
    {
        try {
            if ($capability->image && file_exists(public_path('img/' . $capability->image))) {
                unlink(public_path('img/' . $capability->image));
            }
            $capability->delete();
            return redirect()->route('admin.home.capabilities.index')->with('success', 'Capability deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
