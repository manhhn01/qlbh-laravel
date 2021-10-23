<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

  public function __construct()
  {
    $this->middleware('guest');
  }

  public function index()
  {
    return view('auth.register');
  }

  public function store(Request $req)
  {
    $this->validate($req, [
      'email' => 'required|email|max:50',
      'country_code' => 'required|regex:/[\+\-\d]{2,3}/',
      'phone_number' => 'required|regex:/[0-9]{9,12}/',
      'last_name' => 'required|max:50',
      'first_name' => 'required|max:50',
      'password' => 'required|min:8|max:25',
      'password_confirmation' => 'required|same:password'
    ], [
      'email.required' => 'Email không được bỏ trống',
      'email.email' => 'Địa chỉ email không hợp lệ',
      'email.max' => 'Địa chỉ email không được quá 50 kí tự',
      'last_name.required' => 'Họ không được bỏ trống',
      'last_name.max' => 'Họ không được quá 50 kí tự',
      'first_name.required' => 'Tên không được bỏ trống',
      'first_name.max' => 'Tên không được quá 50 kí tự',
      'country_code.required' => 'Mã vùng không được bỏ trống',
      'country_code.regex' => 'Mã vùng không hợp lệ',
      'phone_number.required' => 'Số điện thoại không được bỏ trống',
      'phone_number.regex' => 'Số điện thoại không hợp lệ',
      'password.required' => 'Mật khẩu không được bỏ trống',
      'password.min' => 'Mật khẩu quá ngắn',
      'password.max' => 'Mật khẩu quá ngắn dài, tối đa 25 kí tự',
      'password_confirmation.required' => 'Mật khẩu không được bỏ trống',
      'password_confirmation.same' => 'Mật khẩu không khớp'
    ]);

    try {
      if (User::where('email', '=', $req->email)->count() > 0) {
        return back()->withErrors(['email' => 'Email đã được sử dụng'])->withInput();
      } else {
        User::create([
          'email' => $req->email,
          'last_name' => $req->last_name,
          'first_name' => $req->first_name,
          'phone_number' => $req->country_code . $req->phone_number,
          'password' => Hash::make($req->password),
          'role' => 0
          // 'type'=>2
        ]);
      }
    } catch (\Illuminate\Database\QueryException $exception) {
    //   dd($exception); //todo
      return back()->withErrors(['message' => 'Có lỗi xảy ra'])->withInput();
    }
    return redirect()->route('login')->with(['info' => 'Đăng ký thành công']);
  }
}
