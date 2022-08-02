<?php


namespace App\Services;


use App\DTO\SaveFaqDTO;
use App\Models\Faq;

class FaqService
{
    public function save(SaveFaqDTO $faqDTO, $id)
    {
        try {
            return Faq::updateOrCreate(['id' => $id], $faqDTO->all());
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }

    public function getFaqs($paginate = 10){
        return Faq::paginate($paginate);
    }
}
