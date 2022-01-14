<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
             'emails'=>['array','required'],
            'last_names'=>['array','required'],
            'first_names'=>['array','required'],
            'new_passwords'=>['array'],
            'emails.*'=>['email', 'required'],
            'last_names.*'=>['required', 'max:30'],
            'first_names.*'=>['required', 'max:30'],
            'passwords.*'=>['max:30'],
            'new_passwords.*'=>['min:8', 'max:30']
        ];
    }

    public function messages(){
        return [
            'last_names.required'=>'Tên không được bỏ trống',
            'first_names.required'=>'Họ không được bỏ trống',
            'passwords.required'=>'Mật khẩu không được bỏ trống',
            'emails.required' => 'Email không được bỏ trống',
            'emails.*.required' => 'Email không được bỏ trống',
            'new_password.*.required' => 'Mật khẩu cho tài khoản mới không được bỏ trống',
            'first_names.*.required' => 'Họ không được bỏ trống',
            'new_first_names.*.required' => 'Họ không được bỏ trống',
            'new_last_names.*.required' => 'Tên nhân viên không được bỏ trống',
            'last_names.*.required' => 'Tên nhân viên không được bỏ trống'
        ];
    }
}
