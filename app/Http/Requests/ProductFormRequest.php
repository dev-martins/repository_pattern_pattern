<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
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
        return [
            'name'  => "required|min:3|max:100|unique:products,name,{$this->id},id",
            // 'url'   => "required|min:3|max:100|unique:products,url,{$this->id},id",
            'price' => "required",
            'image' => "required|unique:products,image,{$this->id},id",
            'description'   => 'max:9000',
            'category_id'   => "required|exists:categories,id"

        ];
    }
}
