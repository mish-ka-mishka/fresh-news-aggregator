<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SearchArticleRequest;
use App\Http\Resources\Api\ArticleResource;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchArticleRequest $request)
    {
        if ($request->has('query')) {
            $articles = Article::search($request->get('query'));
        } else {
            $articles = Article::query();
        }

        return ArticleResource::collection($articles->paginate(100));
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return new ArticleResource($article);
    }
}
