<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarqueeItem;
use Illuminate\Http\Request;

class MarqueeController extends Controller
{
    public function index(string $locale)
    {
        $marqueeItems = MarqueeItem::query()->orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.home.marquee.index', compact('marqueeItems'));
    }

    public function create(string $locale)
    {
        return view('admin.home.marquee.create');
    }

    public function store(Request $request, string $locale)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        try {
            if (empty($validated['sort_order'])) {
                $maxOrder = MarqueeItem::max('sort_order');
                $validated['sort_order'] = $maxOrder ? $maxOrder + 1 : 1;
            }

            MarqueeItem::create($validated);
            return redirect()->route('admin.home.marquee.index', ['locale' => $locale])->with('success', 'Marquee item berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(string $locale, MarqueeItem $marqueeItem)
    {
        return view('admin.home.marquee.edit', compact('marqueeItem'));
    }

    public function update(Request $request, string $locale, MarqueeItem $marqueeItem)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        try {
            $validated['is_active'] = $request->has('is_active');
            $marqueeItem->update($validated);
            return redirect()->route('admin.home.marquee.index', ['locale' => $locale])->with('success', 'Marquee item berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(string $locale, MarqueeItem $marqueeItem)
    {
        try {
            $marqueeItem->delete();
            return redirect()->route('admin.home.marquee.index', ['locale' => $locale])->with('success', 'Marquee item berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
