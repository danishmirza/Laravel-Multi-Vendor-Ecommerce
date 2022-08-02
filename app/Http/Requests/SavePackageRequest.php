<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePackageRequest extends FormRequest
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
        $rules = [
            'title.en' => 'required',
            'title.ar' => 'required',
            'duration' => 'required',
            'duration_type' => 'required',
            'description.en' => 'required',
            'description.ar' => 'required',
            'is_free' => 'required',
        ];

        if ($this->request->get('is_free') == 0) {
            $rules['price'] = 'required';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'title.en.required' => __('The Title In English field is required'),
            'title.ar.required' => __('The Title In Arabic field is required'),
            'description.en.required' => __('The Description In English field is required'),
            'description.ar.required' => __('The Description In Arabic field is required'),
        ];
    }
}
