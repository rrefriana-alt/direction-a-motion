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

    public function list()
    {
        $news = News::latest()->paginate(10);
        return view('admin.news.list', compact('news'));
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

    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.show', compact('news'));
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        $categories = ['company', 'industry', 'events', 'updates', 'insights'];
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, $id)
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

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        if ($news->featured_image && file_exists(public_path('img/' . $news->featured_image))) {
            unlink(public_path('img/' . $news->featured_image));
        }
        $news->delete();
        return redirect()->route('admin.news.list')->with('success', 'News berhasil dihapus!');
    }
}
