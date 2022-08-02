<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class SaveCouponRequest extends FormRequest
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
            'name' => 'array',
            'name.en' => 'required',
            'name.ar' => 'required',
            'coupon_code' => 'required',
            'discount' => 'required|integer|min:1|max:99',
            'coupon_type' => 'required|in:infinite,number',
            'end_date' => 'required|after:today'
        ];
        if($this->request->get('coupon_type') == 'number'){
            $rules['coupon_number'] = 'required|integer|min:1';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.en.required' => __('The Title in English field is required'),
            'name.ar.required' => __('The Title in Arabic field is required'),
        ];
    }
}
