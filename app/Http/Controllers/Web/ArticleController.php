<?php


namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Services\ArticleService;

class ArticleController extends Controller
{
    public function index(ArticleService $articleService)
    {
        return view('web.front.articles.index', ['articles' => $articleService->getArticles()]);
    }

    public function detail(Article $article)
    {
        return view('web.front.articles.detail', ['article' => $article]);
    }

}
