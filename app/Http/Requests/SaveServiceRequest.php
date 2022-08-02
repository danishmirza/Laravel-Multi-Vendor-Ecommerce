<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveServiceRequest extends FormRequest
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
        $rules = [
            'subcategory_id' => 'required|exists:categories,id',
            'title.en' => 'required',
            'title.ar' => 'required',
            'price' => 'required|min:1',
            'is_active' => 'required',
            'has_offer' => 'required',
            'content.en' => 'required',
            'content.ar' => 'required',
        ];
        if($this->request->get('has_offer') > 0){
            $rules['discount_percentage'] = 'required|min:1|max:99';
            $rules['discount_expiry_date'] = 'required|after:today';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'title.en.required' => __('The Title In English field is required'),
            'title.ar.required' => __('The Title In Arabic field is required'),
            'content.en.required' => __('The Content In English field is required'),
            'content.ar.required' => __('The Content In Arabic field is required'),
        ];
    }
}
