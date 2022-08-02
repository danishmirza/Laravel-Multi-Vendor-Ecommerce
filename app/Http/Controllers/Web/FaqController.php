<?php


namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Services\FaqService;

class FaqController extends Controller
{
    public function index(FaqService $faqService)
    {
        return view('web.front.faqs.index', ['faqs' => $faqService->getFaqs()]);
    }

}
