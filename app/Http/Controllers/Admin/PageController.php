<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DTO\SavePageDTO;
use App\Http\Requests\SavePageRequest;
use App\Models\Page;
use App\Services\DatatableService;
use App\Services\PageService;

class PageController extends Controller {

    public function index()
    {
        return view('admin.dashboard.pages.index');
    }

    public function all(DatatableService $datatableService){
        $pages = $datatableService->pagesDatatable();
        return response($pages);
    }

    public function edit(Page $page) {
        return view('admin.dashboard.pages.edit', [
            'method' => 'PUT',
            'pageId' => $page->id,
            'action' => route('admin.dashboard.pages.update', $page->id),
            'heading' => 'Edit Page',
            'page' => $page
        ]);
    }

    public function update(SavePageRequest $request, $id, PageService $pageService) {
        try {
            $pageService->save(SavePageDTO::fromRequest($request));
            return redirect(route('admin.dashboard.pages.index'))->with('status', ($id == 0) ? 'Page added successfully.': 'Page updated successfully.');
        }
        catch (\Exception $e){
            return response(['err'=>$e->getMessage()]);
        }
    }

    public function destroy(Page $page) {
        try {
            $page->delete();
            return response(['msg' => 'Page deleted']);
        }
        catch (\Exception $e){
            return response(['err'=>$e->getMessage()]);
        }
    }

}
