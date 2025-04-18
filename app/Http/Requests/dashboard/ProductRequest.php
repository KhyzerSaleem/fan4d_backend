<?php

namespace App\Http\Requests\dashboard;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
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
            'title_ar' => 'required|min:3',
            'title_en' => 'required|min:3',
            'desc_ar' => 'required|min:10',
            'desc_en' => 'required|min:10',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'custom_quantity_from' => 'required|numeric|min:0',
            'custom_quantity_to' => 'required|numeric|min:0|gte:custom_quantity_from',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'quantities' => 'required|array',
            'quantities.*' => 'required|numeric|min:0',
        ];
    }

//    protected function failedValidation(Validator $validator)
//    {
//        $error = implode('- ', $validator->errors()->all());
//        throw new HttpResponseException(
//            msg(false, $error, failed())
//        );
//    }
}
