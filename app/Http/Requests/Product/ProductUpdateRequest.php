<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user()->role === 0) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'description' => ['required'],
            'supplier' => ['required'],
            'new_supplier' => ['required_without:supplier'],
            'images' => ['image'],
            'price' => ['required', 'integer', 'max:100000000'],
            'status' => ['required'],
            'category' => ['required'],
            'new_category' => ['required_without:category'],
            'quantity' => ['required', 'integer', 'max:30000'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên sản phẩm không được để trống',
            'description.required' => 'Mô tả không được để trống',
            'supplier.required' => 'Tên nhà cung cấp không được để trống',
            'images.required' => 'Hình ảnh không được để trống',
            'category.required' => 'Danh mục không được để trống',
            'price.required' => 'Giá sản phẩm không được để trống',
            'quantity.require' => 'Số lượng không được để trống',
            'quantity.max' => 'Sô lượng sản phẩm tối đa 30000',
        ];
    }
}

