@extends('layouts.app')
@section('title','Halaman Tidak Ditemukan')
@section('content')
{-- [P07] Error page ramah pengguna: jangan tampilkan stack trace atau file rahasia. --}
<div class="text-center py-5"><h1 class="display-4">404</h1><h2>Halaman Tidak Ditemukan</h2><p>Pastikan alamat halaman yang diminta benar.</p><a class="btn btn-primary" href="{{ route('dashboard') }}">Kembali ke Dashboard</a></div>
@endsection
