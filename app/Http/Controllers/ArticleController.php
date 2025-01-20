<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Parent: Display searchable articles
    public function index(Request $request)
    {
        $query = $request->input('query');

        $articles = Article::when($query, function ($q) use ($query) {
            return $q->where('title', 'like', "%{$query}%")
                     ->orWhere('content', 'like', "%{$query}%");
        })->paginate(10);

        return view('articles.index', compact('articles'));
    }

    // Admin: Show form to create article
    public function create()
    {
        return view('articles.create');
    }

    // Admin: Store a new article
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        Article::create($request->all());

        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    }

    // Admin: Show form to edit article
    public function edit($id)
    {
        $article = Article::findOrFail($id);

        return view('articles.edit', compact('article'));
    }

    // Admin: Update an article
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $article = Article::findOrFail($id);
        $article->update($request->all());

        return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
    }

    // Admin: Delete an article
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');
    }
}
