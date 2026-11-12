{-- [P12] HTTP Client, fallback layanan eksternal dan view referensi. --}
@extends('layouts.app')
@section('title','Detail Artikel Eksternal')
@section('content')<h1>Detail Artikel Referensi</h1>@if($error)<div class="alert alert-warning">{{ $error }}</div>@elseif($post)
<div class="card"><div class="card-body"><span class="badge text-bg-secondary">ID {{ $post['id'] }}</span><h2 class="h4 mt-3">{{ $post['title'] }}</h2><p style="white-space:pre-line">{{ $post['body'] }}</p><p class="text-secondary">Contoh JSONPlaceholder: userId {{ $post['userId']??'—' }}</p></div></div>@endif
<a class="btn btn-outline-primary mt-3" href="{{ route('external-posts.index') }}">Kembali</a>@endsection
