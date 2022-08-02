<?php

namespace App\Http\Controllers\Admin;

use App\DTO\SaveFaqDTO;
use App\Http\Requests\SaveFaqRequest;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Services\DatatableService;
use App\Services\FaqService;

class FaqsController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.faqs.index');
    }

    public function all(DatatableService $datatableService)
    {
        $pages = $datatableService->faqsDatatable();
        return response($pages);
    }

    public function create(Faq $faq)
    {
        return view('admin.dashboard.faqs.edit', [
            'faqId' => 0,
            'action' => route('admin.dashboard.faqs.update', 0),
            'heading' => 'Add FAQ',
            'faq' => $faq->getInitialObject()
        ]);
    }

    public function edit(Faq $faq)
    {
        return view('admin.dashboard.faqs.edit', [
            'faqId' => $faq->id,
            'action' => route('admin.dashboard.faqs.update', $faq->id),
            'heading' => 'Edit FAQ',
            'faq' => $faq
        ]);
    }

    public function update(SaveFaqRequest $request, $id, FaqService $faqService)
    {
        try {
            $faqService->save(SaveFaqDTO::fromRequest($request), $id);
            return redirect(route('admin.dashboard.faqs.index'))->with('status', ($id == 0) ? 'Faq added successfully.': 'Faq updated successfully.');
        } catch (\Exception $e) {
            return response(['err'=>$e->getMessage()]);
        }
    }

    public function destroy(Faq $faq)
    {
        try {
            $faq->delete();
            return response(['msg' => 'FAQ deleted']);
        } catch (\Exception $e) {
            return response(['err' => $e->getMessage()]);
        }
    }

}
