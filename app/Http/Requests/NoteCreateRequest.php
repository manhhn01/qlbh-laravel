<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class NoteCreateRequest extends FormRequest
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
            'receive_at' => ['required'],
            'deliver_name' => ['required'],
            'products' => ['required', 'min:1'],
            'products.*.quantity' => ['required', 'integer', 'max:30000'],
            'products.*.product_id' => ['required', 'distinct'],
            'status' => ['required'],
        ];
    }

    public function prepareForValidation()
    {
        $attributes = $this->all();
        if (!empty($attributes['products'])) {
            $updated_products = collect($attributes['products'])
                ->map(function ($item) {
                    $product = Product::find($item['product_id']);
                    if (isset($product)) {
                        $item['name'] = $product->name;
                        $item['sku'] = $product->sku;

                        return $item;
                    } else {
                        return [];
                    }
                })->reject(function ($item) {
                    return empty($item);
                })->toArray();
            $this->merge(['products' => $updated_products, 'manager_id' => auth()->user()->id]);
        }
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            back()->withInput($this->all())->withErrors($errors)
        );
    }
}
