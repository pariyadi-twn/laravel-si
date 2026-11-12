{-- [P09] Antarmuka autentikasi dan reset password. --}
@extends('layouts.app')
@section('title','Login')
@section('content')<div class="row justify-content-center"><div class="col-md-6 col-lg-5"><div class="card"><div class="card-body p-4">
<h1 class="h3 mb-4">Masuk ke Laravel SI</h1>
<form action="{{ route('login.attempt') }}" method="post">@csrf
<div class="mb-3"><label class="form-label" for="email">Email</label><input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" autocomplete="username" required>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label" for="password">Password</label><input type="password" name="password" id="password" class="form-control" autocomplete="current-password" required></div>
<label class="form-check mb-3"><input type="checkbox" class="form-check-input" name="remember" value="1"><span class="form-check-label">Ingat saya</span></label>
<button class="btn btn-primary w-100">Login</button></form>
<p class="mt-3"><a href="{{ route('password.request') }}">Lupa password?</a> · <a href="{{ route('register') }}">Buat akun staff</a></p>
</div></div></div></div>@endsection
