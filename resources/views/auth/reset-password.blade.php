{-- [P09] Antarmuka autentikasi dan reset password. --}
@extends('layouts.app')
@section('title','Reset Password')
@section('content')<div class="row justify-content-center"><div class="col-md-6"><div class="card"><div class="card-body"><h1 class="h3">Reset Password</h1>
<form method="post" action="{{ route('password.update') }}">@csrf<input type="hidden" name="token" value="{{ $token }}">
<label class="form-label" for="email">Email</label><input type="email" name="email" id="email" value="{{ old('email',$email) }}" class="form-control mb-2">
<label class="form-label" for="password">Password Baru</label><input type="password" id="password" name="password" class="form-control mb-2">
<label class="form-label" for="password_confirmation">Konfirmasi Password</label><input type="password" name="password_confirmation" id="password_confirmation" class="form-control mb-3">
@foreach($errors->all() as $err)<p class="text-danger">{{ $err }}</p>@endforeach<button class="btn btn-primary">Simpan Password Baru</button></form>
</div></div></div></div>@endsection
