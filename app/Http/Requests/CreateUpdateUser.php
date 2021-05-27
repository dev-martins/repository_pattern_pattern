<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateUser extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $rules =  [
            'name'          =>  "required|string|min:3|",
            'email'         =>  "required|string|email|min:3|unique:users,email,{$this->id},id",
            'password'      =>  "string|min:8|"
        ];

        if($this->isMethod('POST')){
            $rules['password'] = "required|string|min:8|";
        }

        return $rules;
    }
}
