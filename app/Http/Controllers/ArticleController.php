<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $type_menu = 'article';
        $articles = Article::query();

        // Filter by date if news_date is provided
        if ($request->has('news_date') && $request->news_date) {
            $articles->whereDate('news_date', $request->news_date);
        }

        // Search by title or content
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $articles->where(function($query) use ($searchTerm) {
                $query->where('title', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('detail', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Paginate the results
        $articles = $articles->orderBy('news_date', 'desc')->paginate(10);

        return view('admin.article.index', compact('articles', 'type_menu'));
    }

    public function create()
    {
        $type_menu = 'article';

        return view('admin.article.create', compact('type_menu'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'detail' => 'required',
            'news_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $article = new Article();
        $article->title = $validated['title'];
        $article->detail = $validated['detail'];
        $article->news_date = $validated['news_date'];

        if ($request->hasFile('image')) {
            try {
                // Generate a unique filename
                $filename = Str::slug($request->input('title')) . '-' . time() . '.' . $request->file('image')->getClientOriginalExtension();

                // Store the file in the 'articles' directory under the 'public' disk
                $imagePath = $request->file('image')->storeAs('articles', $filename, 'public');

                // Assign the file path to the article
                $article->image = $imagePath;
            } catch (\Exception $e) {
                // Handle any exceptions during file upload
                return back()->withInput()->withErrors(['image' => 'Failed to upload the image. Please try again.']);
            }
        }

        $article->save();

        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully');
    }

    public function edit(Article $article)
    {
        $type_menu = 'article';

        return view('admin.article.edit', compact('article', 'type_menu'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'detail' => 'required',
            'news_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Assign required data
        $article->title = $validated['title'];
        $article->detail = $validated['detail'];
        $article->news_date = $validated['news_date'];

        // If there's a new image, save it
        if ($request->hasFile('image')) {
            try {
                // Delete old image if it exists
                if ($article->image) {
                    Storage::disk('public')->delete($article->image);
                }

                $filename = Str::slug($request->input('title')) . '-' . time() . '.' . $request->file('image')->getClientOriginalExtension();
                $imagePath = $request->file('image')->storeAs('articles', $filename, 'public');
                $article->image = $imagePath;
            } catch (\Exception $e) {
                return back()->withInput()->withErrors(['image' => 'Failed to upload the image. Please try again.']);
            }
        }

        $article->save();

        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully!');
    }

    public function destroy(Article $article)
    {
        // Delete image if it exists
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Article deleted successfully');
    }
}
