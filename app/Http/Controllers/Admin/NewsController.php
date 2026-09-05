<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        return view('admin.news.index');
    }

    public function list(Request $request)
    {
        $categories = ['company', 'industry', 'events', 'updates', 'insights'];
        $query = News::query();
        $search = trim((string) $request->query('q', ''));
        if ($search !== '') {
            $query->where(function ($w) use ($search) {
                $w->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }
        $activeCategory = $request->query('category', '');
        if (in_array($activeCategory, $categories, true)) {
            $query->where('category', $activeCategory);
        }
        $sort = $request->query('sort', 'latest');
        if ($sort === 'oldest') {
            $query->orderBy('created_at')->orderBy('id');
        } elseif ($sort === 'views') {
            $query->orderByDesc('view_count')->orderByDesc('id');
        } else {
            $sort = 'latest';
            $query->orderByDesc('created_at')->orderByDesc('id');
        }
        $news = $query->paginate(10)->withQueryString();
        $pinnedIds = array_values((array) (json_decode((string) \App\Models\Setting::get('home_journal_pinned_ids', '[]'), true) ?? []));
        return view('admin.news.list', compact('news', 'pinnedIds', 'categories', 'search', 'activeCategory', 'sort'));
    }

    public function create()
    {
        $categories = ['company', 'industry', 'events', 'updates', 'insights'];
        $news = new News();
        return view('admin.news.create', compact('categories', 'news'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'author' => 'required|string|max:255',
            'category' => 'required|in:company,industry,events,updates,insights',
            'read_time' => 'required|integer|min:1',
            'published_date' => 'required|date',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ]);

        $imageName = null;
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img'), $imageName);
        }

        News::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'featured_image' => $imageName,
            'author' => $request->author,
            'category' => $request->category,
            'read_time' => $request->read_time,
            'published_date' => $request->published_date,
            'is_featured' => $request->is_featured ?? false,
            'is_published' => $request->is_published ?? false,
        ]);

        return redirect()->route('admin.news.list')->with('success', 'News berhasil dibuat!');
    }

    public function show(string $locale, $id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.show', compact('news'));
    }

    public function edit(string $locale, $id)
    {
        $news = News::findOrFail($id);
        $categories = ['company', 'industry', 'events', 'updates', 'insights'];
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, string $locale, $id)
    {
        $news = News::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'author' => 'required|string|max:255',
            'category' => 'required|in:company,industry,events,updates,insights',
            'read_time' => 'required|integer|min:1',
            'published_date' => 'required|date',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ]);

        $data = [
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'author' => $request->author,
            'category' => $request->category,
            'read_time' => $request->read_time,
            'published_date' => $request->published_date,
            'is_featured' => $request->is_featured ?? false,
            'is_published' => $request->is_published ?? false,
        ];

        if ($request->hasFile('featured_image')) {
            if ($news->featured_image && file_exists(public_path('img/' . $news->featured_image))) {
                unlink(public_path('img/' . $news->featured_image));
            }
            $image = $request->file('featured_image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img'), $imageName);
            $data['featured_image'] = $imageName;
        }

        if ($news->title !== $request->title) {
            $data['slug'] = Str::slug($request->title) . '-' . time();
        }

        $news->update($data);
        return redirect()->route('admin.news.list')->with('success', 'News berhasil diupdate!');
    }

    public function destroy(string $locale, $id)
    {
        $news = News::findOrFail($id);
        if ($news->featured_image && file_exists(public_path('img/' . $news->featured_image))) {
            unlink(public_path('img/' . $news->featured_image));
        }
        $news->delete();
        return redirect()->route('admin.news.list')->with('success', 'News berhasil dihapus!');
    }
}
