<?php

namespace App\Http\Controllers\Admin;

use App\DTO\SaveArticleDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveArticleRequest;
use App\Models\Article;
use App\Services\ArticleService;
use App\Services\DatatableService;


class ArticleController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.articles.index');
    }

    public function all(DatatableService $datatableService)
    {
        $articles = $datatableService->articlesDatatable();
        return response($articles);
    }

    public function create(Article $article)
    {
        return view('admin.dashboard.articles.edit', [
            'heading' => 'Add Article',
            'action' => route('admin.dashboard.articles.update', 0),
            'article' => $article->getInitialObject(),
            'articleId' => 0,
        ]);
    }

    public function edit(Article $article)
    {
        return view('admin.dashboard.articles.edit', [
            'heading' => 'Edit Article',
            'action' => route('admin.dashboard.articles.update', $article->id),
            'article' => $article,
            'articleId' => $article->id,
        ]);
    }

    public function update(SaveArticleRequest $request, $id, ArticleService $articleService)
    {
        try {
            $articleService->save(SaveArticleDTO::fromRequest($request), $id);
            return redirect(route('admin.dashboard.articles.index'))->with('status', ($id == 0) ? 'Article added successfully.': 'Article updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err', $e->getMessage());
        }
    }

    public function destroy(Article $article)
    {
        $data = $article->delete();
        if (!$data) {
            return response(['err' => 'Unable to delete'], 400);
        }
        return response(['msg' => 'Successfully deleted']);
    }
}
