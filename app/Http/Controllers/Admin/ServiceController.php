<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use App\Models\ServiceDetail;
use App\Models\ServiceItem;
use App\Models\EngagementModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index(string $locale)
    {
        return view('admin.service.index', compact('locale'));
    }

    public function crud(string $locale)
    {
        $categories = ServiceCategory::with(['allDetails.allItems'])->orderBy('sort_order')->get();
        return view('admin.service.crud', compact('categories', 'locale'));
    }

    public function storeCategory(Request $request, string $locale)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:service_categories,slug',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable',
        ]);
        try {
            $category = ServiceCategory::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'title' => $request->title,
                'description' => $request->description,
                'icon' => $request->icon,
                'sort_order' => $request->sort_order ?? 0,
                'is_active' => $request->boolean('is_active', true),
            ]);
            return response()->json(['success' => true, 'message' => 'Category created', 'category' => $category->load('allDetails.allItems')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateCategory(Request $request, string $locale, $id)
    {
        $category = ServiceCategory::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:service_categories,slug,' . $id,
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable',
        ]);
        try {
            $category->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'title' => $request->title,
                'description' => $request->description,
                'icon' => $request->icon,
                'sort_order' => $request->sort_order ?? 0,
                'is_active' => $request->boolean('is_active', true),
            ]);
            return response()->json(['success' => true, 'message' => 'Category updated', 'category' => $category->load('allDetails.allItems')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroyCategory(string $locale, $id)
    {
        try {
            ServiceCategory::findOrFail($id)->delete();
            return response()->json(['success' => true, 'message' => 'Category deleted']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function storeDetail(Request $request, string $locale)
    {
        $request->validate([
            'service_category_id' => 'required|exists:service_categories,id',
            'category_name' => 'required|string|max:255',
            'content' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable',
        ]);
        try {
            $detail = ServiceDetail::create([
                'service_category_id' => $request->service_category_id,
                'category_name' => $request->category_name,
                'content' => $request->content,
                'sort_order' => $request->sort_order ?? 0,
                'is_active' => $request->boolean('is_active', true),
            ]);
            return response()->json(['success' => true, 'message' => 'Detail created', 'detail' => $detail->load('allItems')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateDetail(Request $request, string $locale, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'content' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable',
        ]);
        try {
            $detail = ServiceDetail::findOrFail($id);
            $detail->update([
                'category_name' => $request->category_name,
                'content' => $request->content,
                'sort_order' => $request->sort_order ?? 0,
                'is_active' => $request->boolean('is_active', true),
            ]);
            return response()->json(['success' => true, 'message' => 'Detail updated', 'detail' => $detail->load('allItems')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroyDetail(string $locale, $id)
    {
        try {
            ServiceDetail::findOrFail($id)->delete();
            return response()->json(['success' => true, 'message' => 'Detail deleted']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function storeItem(Request $request, string $locale)
    {
        $request->validate([
            'service_detail_id' => 'required|exists:service_details,id',
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable',
        ]);
        try {
            $data = [
                'service_detail_id' => $request->service_detail_id,
                'item_name' => $request->item_name,
                'description' => $request->description,
                'sort_order' => $request->sort_order ?? 0,
                'is_active' => $request->boolean('is_active', true),
            ];
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('img'), $imageName);
                $data['image'] = $imageName;
            }
            $item = ServiceItem::create($data);
            return response()->json(['success' => true, 'message' => 'Item created', 'item' => $item]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateItem(Request $request, string $locale, $id)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable',
        ]);
        try {
            $item = ServiceItem::findOrFail($id);
            $data = [
                'item_name' => $request->item_name,
                'description' => $request->description,
                'sort_order' => $request->sort_order ?? 0,
                'is_active' => $request->boolean('is_active', true),
            ];
            if ($request->hasFile('image')) {
                if ($item->image && file_exists(public_path('img/' . $item->image))) {
                    unlink(public_path('img/' . $item->image));
                }
                $image = $request->file('image');
                $imageName = time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('img'), $imageName);
                $data['image'] = $imageName;
            }
            $item->update($data);
            return response()->json(['success' => true, 'message' => 'Item updated', 'item' => $item]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroyItem(string $locale, $id)
    {
        try {
            $item = ServiceItem::findOrFail($id);
            if ($item->image && file_exists(public_path('img/' . $item->image))) {
                unlink(public_path('img/' . $item->image));
            }
            $item->delete();
            return response()->json(['success' => true, 'message' => 'Item deleted']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ==================== ENGAGEMENT MODELS ====================
    // ==================== REORDER & MOVE ====================
    public function reorderDetail(Request $request, string $locale, $id)
    {
        $request->validate([
            'direction' => 'required|in:up,down',
            'target_index' => 'nullable|integer',
        ]);
        try {
            $detail = ServiceDetail::findOrFail($id);
            $siblings = ServiceDetail::where('service_category_id', $detail->service_category_id)
                ->orderBy('sort_order')
                ->get();
            $currentIndex = $siblings->pluck('id')->search($id);

            // Jika target_index dikirim, pindah ke posisi absolut
            if ($request->has('target_index')) {
                $targetIndex = $request->integer('target_index');
                if ($targetIndex < 0 || $targetIndex >= $siblings->count()) {
                    return response()->json(['success' => false, 'message' => 'Invalid target position'], 400);
                }
                // Jika targetIndex sama dengan currentIndex, tidak perlu pindah
                if ($targetIndex === $currentIndex) {
                    return response()->json(['success' => true, 'message' => 'Already in position', 'category' => ServiceCategory::with('allDetails.allItems')->find($detail->service_category_id)]);
                }
                // Urutkan ulang sort_order: item di targetIndex pindah ke currentIndex
                $detail->update(['sort_order' => $siblings[$targetIndex]->sort_order]);
                // Geser sort_order items di antara currentIndex dan targetIndex
                $step = $targetIndex > $currentIndex ? -1 : 1;
                $range = range($currentIndex, $targetIndex, $step);
                foreach ($range as $i) {
                    $sibling = $siblings[abs($i)];
                    $sibling->update(['sort_order' => $siblings[$i + $step]->sort_order ?? $sibling->sort_order]);
                }
                // Set sort_order detail yang dipindah ke target position
                $detail->update(['sort_order' => $siblings[($targetIndex > $currentIndex ? $targetIndex - 1 : $targetIndex)]->sort_order]);

                $category = ServiceCategory::with('allDetails.allItems')->find($detail->service_category_id);
                return response()->json(['success' => true, 'message' => 'Detail reordered', 'category' => $category]);
            }

            // Logika lama: move 1 langkah ke up/down
            $newIndex = $request->direction === 'up' ? $currentIndex - 1 : $currentIndex + 1;

            if ($newIndex < 0 || $newIndex >= $siblings->count()) {
                return response()->json(['success' => false, 'message' => 'Cannot move further'], 400);
            }

            $swapDetail = $siblings[$newIndex];
            $tempOrder = $detail->sort_order;
            $detail->update(['sort_order' => $swapDetail->sort_order]);
            $swapDetail->update(['sort_order' => $tempOrder]);

            $category = ServiceCategory::with('allDetails.allItems')->find($detail->service_category_id);
            return response()->json(['success' => true, 'message' => 'Detail reordered', 'category' => $category]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function reorderItem(Request $request, string $locale, $id)
    {
        $request->validate([
            'direction' => 'required|in:up,down',
            'target_index' => 'nullable|integer',
        ]);
        try {
            $item = ServiceItem::findOrFail($id);
            $siblings = ServiceItem::where('service_detail_id', $item->service_detail_id)
                ->orderBy('sort_order')
                ->get();
            $currentIndex = $siblings->pluck('id')->search($id);

            // Jika target_index dikirim, pindah ke posisi absolut
            if ($request->has('target_index')) {
                $targetIndex = $request->integer('target_index');
                if ($targetIndex < 0 || $targetIndex >= $siblings->count()) {
                    return response()->json(['success' => false, 'message' => 'Invalid target position'], 400);
                }
                if ($targetIndex === $currentIndex) {
                    return response()->json(['success' => true, 'message' => 'Already in position', 'category' => ServiceCategory::with('allDetails.allItems')->find($item->detail->service_category_id)]);
                }
                // Urutkan ulang sort_order: item di targetIndex pindah ke currentIndex
                $item->update(['sort_order' => $siblings[$targetIndex]->sort_order]);
                // Geser sort_order items di antara currentIndex dan targetIndex
                $step = $targetIndex > $currentIndex ? -1 : 1;
                $range = range($currentIndex, $targetIndex, $step);
                foreach ($range as $i) {
                    $sibling = $siblings[abs($i)];
                    $sibling->update(['sort_order' => $siblings[$i + $step]->sort_order ?? $sibling->sort_order]);
                }
                // Set sort_order item yang dipindah ke target position
                $item->update(['sort_order' => $siblings[($targetIndex > $currentIndex ? $targetIndex - 1 : $targetIndex)]->sort_order]);

                $category = ServiceCategory::with('allDetails.allItems')->find($item->detail->service_category_id);
                return response()->json(['success' => true, 'message' => 'Item reordered', 'category' => $category]);
            }

            // Logika lama: move 1 langkah ke up/down
            $newIndex = $request->direction === 'up' ? $currentIndex - 1 : $currentIndex + 1;

            if ($newIndex < 0 || $newIndex >= $siblings->count()) {
                return response()->json(['success' => false, 'message' => 'Cannot move further'], 400);
            }

            $swapItem = $siblings[$newIndex];
            $tempOrder = $item->sort_order;
            $item->update(['sort_order' => $swapItem->sort_order]);
            $swapItem->update(['sort_order' => $tempOrder]);

            $category = ServiceCategory::with('allDetails.allItems')->find($item->detail->service_category_id);
            return response()->json(['success' => true, 'message' => 'Item reordered', 'category' => $category]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function moveItem(Request $request, string $locale, $id)
    {
        $request->validate([
            'service_detail_id' => 'required|exists:service_details,id',
        ]);
        try {
            $item = ServiceItem::findOrFail($id);
            $oldCategoryId = $item->detail->service_category_id;
            $item->update(['service_detail_id' => $request->service_detail_id]);
            $targetDetail = ServiceDetail::findOrFail($request->service_detail_id);
            $targetCategoryId = $targetDetail->service_category_id;

            $categories = ServiceCategory::with('allDetails.allItems')
                ->whereIn('id', array_unique([$oldCategoryId, $targetCategoryId]))
                ->get();
            return response()->json(['success' => true, 'message' => 'Item moved', 'categories' => $categories]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function engagementIndex(string $locale)
    {
        $engagements = EngagementModel::orderBy('sort_order')->get();
        return view('admin.home.engagement.index', compact('engagements', 'locale'));
    }

    public function engagementCreate(string $locale)
    {
        return view('admin.home.engagement.create', compact('locale'));
    }

    public function engagementStore(Request $request, string $locale)
    {
        $request->validate([
            'letter' => 'required|string|max:10',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'sort_order' => 'nullable|integer',
        ]);
        $data = $request->all();
        if (empty($data['sort_order'])) {
            $data['sort_order'] = EngagementModel::max('sort_order') + 1;
        }
        $data['is_active'] = $request->boolean('is_active');
        EngagementModel::create($data);
        return redirect()->route('admin.services.engagement.index', ['locale' => $locale])->with('success', 'Engagement model created');
    }

    public function engagementEdit(string $locale, $id)
    {
        $engagement = EngagementModel::findOrFail($id);
        return view('admin.home.engagement.edit', compact('engagement', 'locale'));
    }

    public function engagementUpdate(Request $request, string $locale, $id)
    {
        $request->validate([
            'letter' => 'required|string|max:10',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'sort_order' => 'nullable|integer',
        ]);
        $engagement = EngagementModel::findOrFail($id);
        $data = $request->all();
        $data['is_active'] = $request->boolean('is_active');
        $engagement->update($data);
        return redirect()->route('admin.services.engagement.index', ['locale' => $locale])->with('success', 'Engagement model updated');
    }

    public function engagementDestroy(string $locale, $id)
    {
        try {
            EngagementModel::findOrFail($id)->delete();
            return redirect()->route('admin.services.engagement.index', ['locale' => $locale])->with('success', 'Engagement model deleted');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function engagementToggleActive(string $locale, $id)
    {
        $engagement = EngagementModel::findOrFail($id);
        $engagement->update(['is_active' => !$engagement->is_active]);
        return response()->json(['success' => true, 'is_active' => $engagement->is_active]);
    }
}
