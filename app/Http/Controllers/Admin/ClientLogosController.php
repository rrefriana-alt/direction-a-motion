<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientLogo;
use Illuminate\Http\Request;

class ClientLogosController extends Controller
{
    public function index(Request $request, string $locale)
    {
        $search = $request->get('search');
        $category = $request->get('category');

        $clientLogos = ClientLogo::query()
            ->when($search, fn ($q) => $q->where('name', 'like', '%' . $search . '%'))
            ->byCategory($category)
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $categories = ClientLogo::categories();
        return view('admin.home.client-logos.index', compact('clientLogos', 'categories', 'search', 'category'));
    }

    public function create(string $locale)
    {
        $categories = ClientLogo::categories();
        return view('admin.home.client-logos.create', compact('categories'));
    }

    public function store(Request $request, string $locale)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'sort_order' => 'nullable|integer',
        ]);

        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/img/clients'), $imageName);
                $validated['image'] = $imageName;
            }

            if (empty($validated['sort_order'])) {
                $maxOrder = ClientLogo::max('sort_order');
                $validated['sort_order'] = $maxOrder ? $maxOrder + 1 : 1;
            }

            ClientLogo::create($validated);
            return redirect()->route('admin.home.clients.index', ['locale' => $locale])->with('success', 'Client logo berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(string $locale, ClientLogo $clientLogo)
    {
        $categories = ClientLogo::categories();
        return view('admin.home.client-logos.edit', compact('clientLogo', 'categories'));
    }

    public function update(Request $request, string $locale, ClientLogo $clientLogo)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'sort_order' => 'nullable|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        try {
            if ($request->hasFile('image')) {
                if ($clientLogo->image && file_exists(public_path('assets/img/clients/' . $clientLogo->image))) {
                    unlink(public_path('assets/img/clients/' . $clientLogo->image));
                }
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/img/clients'), $imageName);
                $validated['image'] = $imageName;
            } else {
                unset($validated['image']);
            }

            $validated['is_active'] = $request->has('is_active');
            $clientLogo->update($validated);
            return redirect()->route('admin.home.clients.index', ['locale' => $locale])->with('success', 'Client logo berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(string $locale, ClientLogo $clientLogo)
    {
        try {
            if ($clientLogo->image && file_exists(public_path('assets/img/clients/' . $clientLogo->image))) {
                unlink(public_path('assets/img/clients/' . $clientLogo->image));
            }
            $clientLogo->delete();
            return redirect()->route('admin.home.clients.index', ['locale' => $locale])->with('success', 'Client logo berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // ==================== CAROUSEL MANAGEMENT ====================
    public function carousel(Request $request, string $locale)
    {
        $search = $request->get('search');
        $category = $request->get('category');

        $clientLogos = ClientLogo::query()
            ->when($search, fn ($q) => $q->where('name', 'like', '%' . $search . '%'))
            ->byCategory($category)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $categories = ClientLogo::categories();
        return view('admin.home.client-logos.carousel', compact('clientLogos', 'categories', 'search', 'category'));
    }

    public function carouselUpdate(Request $request, string $locale)
    {
        $request->validate([
            'logo_ids' => 'nullable|array',
        ]);

        try {
            $selectedIds = $request->input('logo_ids', []);

            ClientLogo::query()->update(['is_active' => false]);

            if (!empty($selectedIds)) {
                ClientLogo::whereIn('id', $selectedIds)->update(['is_active' => true]);
            }

            return redirect()->route('admin.home.clients.carousel', ['locale' => $locale])->with('success', 'Carousel berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
