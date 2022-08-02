<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveCategoryRequest extends FormRequest
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
        return [
            'title' => 'array',
            'title.en' => 'required|max:220',
            'title.ar' => 'required|max:220',
        ];
    }

    public function messages()
    {
        return [
            'title.en.required' => __('The Title in English field is required'),
            'title.ar.required' => __('The Title in Arabic field is required'),
        ];
    }
}
