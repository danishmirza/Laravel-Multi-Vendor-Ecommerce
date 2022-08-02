<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveFaqRequest extends FormRequest
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
            'question' => 'array',
            'question.en' => 'required|max:190',
            'question.ar' => 'required|max:190',
            'answer' => 'array',
            'answer.en' => 'required',
            'answer.ar' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'question.en.required' => __('The Question In English field is required'),
            'question.ar.required' => __('The Question In Arabic field is required'),
            'answer.en.required' => __('The Answer In English field is required'),
            'answer.ar.required' => __('The Answer In Arabic field is required'),
        ];
    }
}
