@extends('layouts.app')
@section('title','Area Admin')
@section('content')
{{-- [P09] Route ini dilindungi middleware role:admin di server. --}}
<h1 class="page-heading">Area Administrasi</h1><div class="alert alert-info">Hanya pengguna dengan role <strong>admin</strong> yang dapat mengakses halaman ini.</div>
@endsection
