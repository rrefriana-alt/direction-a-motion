<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $data = News::latest()->get();
        return view('admin.news.index', compact('data'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required']);
        News::create($request->only(['title', 'category', 'author', 'status', 'body']));
        return redirect()->route('admin.news.index')->with('success', 'Article created.');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $news->update($request->only(['title', 'category', 'author', 'status', 'body']));
        return redirect()->route('admin.news.index')->with('success', 'Article updated.');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return back()->with('success', 'Article deleted.');
    }
}
