<?php

namespace App\Http\Requests;

use App\Rules\CheckStoreAreaDuplicateRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveStoreAreaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
//        dd($this->request->all());
        return [
            'area_id' => [
                'required',
                'exists:cities,id',
                new CheckStoreAreaDuplicateRule($this->request->get('store_area_id'), $this->request->get('store_id')),
            ],
            'price' => 'required|integer|min:1'
        ];
    }
}
