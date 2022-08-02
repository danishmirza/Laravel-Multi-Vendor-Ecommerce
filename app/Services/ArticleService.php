<?php


namespace App\Services;


use App\DTO\SaveArticleDTO;
use App\Models\Article;

class ArticleService
{
    public function save(SaveArticleDTO $articleDTO, $id)
    {
        try {
            return Article::updateOrCreate(['id' => $id], $articleDTO->all());
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }

    public function getArticles(){
        return Article::orderBy('id', 'desc')->select('id', 'title', 'image', 'slug')->paginate(9);
    }
}
