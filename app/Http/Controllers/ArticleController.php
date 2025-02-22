<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Articles=Article::all();
        return view('dashboard',compact('Articles'));
    }
    public function Articeles()
    {
        
        $Articles=Article::paginate(5);
        foreach($Articles as $article)
        {
            $article->category_id=$article->category->name;
        }

        return response()->json($Articles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=Category::all();
        return view('articles.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $article = new Article();
        $article->title = $request->title;
        $article->content = $request->content;
        $article->category_id = $request->category;
        $article->user_id = auth()->id();
        if ($request->hasFile('image')) {
            $article->image = $request->file('image')->store('articles');
        }
        $article->save();
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {

        $categories=Category::all();
        return view('articles.create',compact('categories','article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        // dd($article);
        $article->title = $request->title;
        $article->content = $request->content;
        $article->category_id = $request->category;
        $article->user_id = auth()->id();
        if ($request->hasFile('image')) {
            $article->image = $request->file('image')->store('articles');
        }
        $article->save();
        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('dashboard');
    }

    public function updateStatus(Request $request,Article $article)
    {
        // dd($request);
        // echo json_encode($request->status);
        $article->status=$request->status;
        $article->save();
        
    }

}
