<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveStoreRequest extends FormRequest
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
        $rules =  [
            'store_name.en' => 'required',
            'store_name.ar' => 'required',
            'detail.en' => 'required',
            'detail.ar' => 'required',
            'phone' => 'required|regex:/^(?:\+)[0-9]/',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'city_id' => 'required|exists:cities,id'
        ];
        if($this->request->get('user_id') > 0){
            $rules['email'] = 'required|email|unique:users,email,'.$this->request->get('user_id').',id,deleted_at,NULL';
        }else{
            $rules['email'] = 'required|email|unique:users,email,NULL,deleted_at';
            $rules['password'] = 'required|confirmed';
            $rules['trade_license'] = 'required';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'store_name.en.required' => __('The Store Name in English field is required'),
            'store_name.ar.required' => __('The Store Name in Arabic field is required'),
            'detail.en.required' => __('The Detail in English field is required'),
            'detail.ar.required' => __('The Detail in Arabic field is required'),
        ];
    }
}
