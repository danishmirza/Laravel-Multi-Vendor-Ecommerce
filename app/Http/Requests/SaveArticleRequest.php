<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveArticleRequest extends FormRequest
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
            'title' => 'array|required',
            'title.en' => 'required',
            'title.ar' => 'required',
            'author' => 'array|required',
            'author.en' => 'required',
            'author.ar' => 'required',
            'content' => 'required|array',
            'content.en' => 'required',
            'content.ar' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.en.required' => __('The Title in English field is required'),
            'title.ar.required' => __('The Title in Arabic field is required'),
            'author.en.required' => __('The Author name in English field is required'),
            'author.ar.required' => __('The Author name in Arabic field is required'),
            'content.en.required' => __('The Content in English field is required'),
            'content.ar.required' => __('The Content in Arabic field is required'),
        ];
    }
}
