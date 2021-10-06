@extends('layouts.app')

@section('title', 'Đăng ký')

@section('auth-form')
  <div class="card shadow mx-auto" style="max-width: 380px; margin-top:100px;">
    <div class="card-body">
      <h4 class="card-title mb-4">Đăng ký</h4>
      <form action="{{ route('register') }}" method="post">
        @csrf

        @error('info')
        <div class="mb-3 alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" type="text">
        </div>
        @error('email')
        <div class="mb-3 alert alert-danger" role="alert">
          {{ $message }}
        </div>
        @enderror

        <div class="mb-3">
          <label class="form-label">Tên</label>
          <div class="row gx-2">
            <div class="col-6">
              <input class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Họ" type="tel">
            </div>
            <div class="col-6">
              <input class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="Tên" type="text">
            </div>
          </div>
        </div> <!-- form-group// -->
        @error('last_name')
        <div class="mb-3 alert alert-danger" role="alert">
          {{ $message }}
        </div>
        @enderror()

        @error('first_name')
        <div class="mb-3 alert alert-danger" role="alert">
          {{ $message }}
        </div>
        @enderror()

        <div class="mb-3">
          <label class="form-label">Số điện thoại</label>
          <div class="row gx-2">
            <div class="col-4">
              <input class="form-control" name="country_code" value="{{ old('country_code') }}" placeholder="+84"
                     type="text">
            </div>
            <div class="col-8">
              <input class="form-control" name="phone_number" value="{{ old('phone_number') }}" placeholder="Số điện thoại"
                     type="tel">
            </div>
          </div>
        </div> <!-- form-group// -->
        @error('country_code')
        <div class="mb-3 alert alert-danger" role="alert">
          {{ $message }}
        </div>
        @enderror()
        @error('phone_number')
        <div class="mb-3 alert alert-danger" role="alert">
          {{ $message }}
        </div>
        @enderror
        <div class="mb-3">
          <label class="form-label">Mật khẩu </label>
          <input class="form-control" name='password' placeholder="Mật khẩu" type="password">
        </div>
        @error('password')
        <div class="mb-3 alert alert-danger" role="alert">
          {{ $message }}
        </div>
        @enderror
        <div class="mb-3">
          <label class="form-label">Xác nhận mật khẩu</label>
          <input class="form-control" name="password_confirmation" placeholder="Nhập lại mật khẩu" type="password">
        </div>
        @error('password_confirmation')
        <div class="mb-3 alert alert-danger" role="alert">
          {{ $message }}
        </div>
        @enderror()
        <div class="mb-4">
          <button type="submit" class="btn btn-primary w-100"> Đăng ký</button>
        </div>
      </form>

      <p class="text-center mb-2">Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a></p>

    </div>
  </div>
@endsection()
