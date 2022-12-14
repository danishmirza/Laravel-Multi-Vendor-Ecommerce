<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveUserRequest extends FormRequest
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
            'name' => 'required',
            'phone' => 'required|regex:/^(?:\+)[0-9]/',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ];
        if($this->request->get('user_id') > 0){
            $rules['email'] = 'required|email|unique:users,email,'.$this->request->get('user_id').',id,deleted_at,NULL';

        }else{
            $rules['email'] = 'required|email|unique:users,email,NULL,deleted_at';
            $rules['password'] = 'required|confirmed';
        }
        return $rules;
    }
}
