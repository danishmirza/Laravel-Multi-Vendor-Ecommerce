<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Http\Resources\ArticlesCollection;
use App\Models\Article;
use App\Services\ArticleService;

class BlogController extends Controller
{
    public function list(ArticleService $articleService){
        try {
            $articles = new ArticlesCollection($articleService->getArticles());
            return responseBuilder()->success('Articles', $articles);
        }catch (\Exception $exception){
            return responseBuilder()->error($exception->getMessage());
        }
    }

    public function detail(Article $article)
    {
        return responseBuilder()->success('Article', $article);
    }

}
