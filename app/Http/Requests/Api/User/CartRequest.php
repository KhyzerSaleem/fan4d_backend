<?php

namespace App\Http\Requests\Api\User;

use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CartRequest extends FormRequest
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
            'type' => ['required', Rule::in(['product', 'service'])],
            'quantity' => ['required', "min:1"],
            'id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $type = $this->input('type');
                    if ($type === 'product') {
                        if (!\DB::table('products')->where('id', $value)->exists()) {
                            $fail('The selected id is invalid for the given type.');
                        }
                    } elseif ($type === 'service') {
                        if (!\DB::table('services')->where('id', $value)->exists()) {
                            $fail('The selected id is invalid for the given type.');
                        }
                    }
                }
            ],
            "options" => "nullable|array",
            "options.*.product_id" => "required|exists:products,id",
            "options.*.option_id" => "required|exists:product_attribute_options,id"
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validateOptionsCount($validator);
        });

        $validator->after(function ($validator) {
            $this->validateServiceProductOptions($validator);
        });

    }

    protected function validateServiceProductOptions($validator)
    {
        $type = $this->input('type');
        $options = $this->input('options', []);
        $serviceId = $this->input('id');

        if ($type === 'service') {
            // Get all product IDs associated with the service
            $serviceProductIds = DB::table('service_products')
                ->where('service_id', $serviceId)
                ->pluck('product_id')
                ->toArray();

            // Get all product IDs from the options
            $optionProductIds = collect($options)->pluck('product_id')->toArray();


            // Check if all service product IDs are present in the option product IDs
            foreach ($serviceProductIds as $serviceProductId) {
                $product = Product::whereId($serviceProductId)->first();
                if ($product->attributes->count() > 0) {
                    if (!in_array($serviceProductId, $optionProductIds)) {
                        $validator->errors()->add('options', "All products for the service must have corresponding options.");
                        break;
                    }
                }
            }
        }
    }


    protected function validateOptionsCount($validator)
    {
        $options = $this->input('options', []);
        $productOptionCounts = [];

        // Count options for each product_id
        foreach ($options as $option) {
            $productId = $option['product_id'];
            if (!isset($productOptionCounts[$productId])) {
                $productOptionCounts[$productId] = 0;
            }
            $productOptionCounts[$productId]++;
        }

        // Validate counts against product attribute counts
        foreach ($productOptionCounts as $productId => $count) {
            $requiredCount = ProductAttribute::where('product_id', $productId)->count();
            if ($count !== $requiredCount) {
                $validator->errors()->add('options', "The number of options for product ID $productId must be $requiredCount.");
            }
        }
    }

    protected function failedValidation(Validator $validator)
    {
        $error = implode('- ', $validator->errors()->all());
        throw new HttpResponseException(
            msg(false, $error, failed())
        );
    }
}
