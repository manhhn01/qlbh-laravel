@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('auth-form')
<div class="card shadow mx-auto" style="max-width: 380px; margin-top:100px;">
  <div class="card-body">
    <h4 class="card-title mb-4">Log in</h4>
    <form action="{{ route('login') }}" method="post">
      @csrf

      @error('info')
      <div class="mb-3 alert alert-danger">{{ $message }}</div>
      @enderror

      <div class="mb-3">
        <input class="form-control" name="email" placeholder="email" type="text" value="{{ old('email') }}">
      </div>
      @error('email')
      <div class="mb-3 alert alert-danger" role="alert">
        {{ $message }}
      </div>
      @enderror
      <div class="mb-3">
        <input class="form-control" name="password" placeholder="password" type="password">
      </div>
      @error('password')
      <div class="mb-3 alert alert-danger" role="alert">
        {{ $message }}
      </div>
      @enderror

      <div class="mb-3">
        <a href="#" class="float-end">Forgot password?</a>
        <label class="form-check">
          <input type="checkbox" name="remember" class="form-check-input" checked="">
          <span class="form-check-label">Remember</span>
        </label>
      </div> <!-- form-group form-check .// -->
      <div class="mb-4">
        <button type="submit" class="btn btn-primary w-100"> Login </button>
      </div> <!-- form-group// -->
    </form>


    <p class="text-center mb-4">Don't have account? <a href="{{ route('register') }}">Sign up</a></p>

  </div> <!-- card-body // -->
</div>
@endsection()
