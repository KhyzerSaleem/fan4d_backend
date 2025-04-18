<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class AddressRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'area_id' => 'required|exists:areas,id,city_id,'.$this->city_id,
            'street' => 'required|string|max:255',
            'house_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'lat' => 'required|string|max:255',
            'lng' => 'required|string|max:255',
            'id' => ['nullable', 'exists:addresses,id', Rule::requiredIf($this->routeIs('addresses.update'))],

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $error = implode('- ', $validator->errors()->all());
        throw new HttpResponseException(
            msg(false, $error, failed())
        );
    }
}
