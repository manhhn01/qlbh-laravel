<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  public function __construct()
  {
    $this->middleware('guest');
  }

  public function index()
  {
    return view('auth.login');
  }

  public function login(Request $req)
  {
    $this->validate(
      $req,
      [
        'email' => 'required|email',
        'password' => 'required'
      ],
      [
        'email.required' => 'Email không được bỏ trống',
        'email.email' => 'Địa chỉ email không hợp lệ',
        'password.required' => 'Mật khẩu không được bỏ trống'
      ]
    );

    $credentials = $req->only(['email', 'password']);

    $result = Auth::attempt($credentials, $req->remember);
    if ($result === false) {
      return back()->withErrors(['message' => 'Email hoặc mật khẩu không đúng']);
    }
    return redirect()->route('dashboard');
  }
}
