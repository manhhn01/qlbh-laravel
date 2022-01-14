<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierCreateRequest extends FormRequest
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
            'name' => ['required', 'max:40'],
            'description' => ['required', 'max:240'],
        ];
    }

    /**
     * response messages.
     * @return string[]
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên nhà cung cấp không được để trống',
            'description.required' => 'Mô tả không được để trống',
        ];
    }
}
