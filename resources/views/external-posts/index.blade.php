@extends('layouts.app')
@section('title','Referensi API Eksternal')
@section('content')
<h1 class="page-heading">Referensi Artikel Eksternal</h1><p class="text-secondary">[P12] Data contoh diambil dari JSONPlaceholder menggunakan Laravel HTTP Client. Data tidak disimpan di MySQL/SQLite.</p>
<form method="get" action="{{ route('external-posts.index') }}" class="row g-2 align-items-end mb-4"><div class="col-md-4"><label for="user_id" class="form-label">Filter userId (1–10)</label><input id="user_id" name="user_id" type="number" min="1" max="10" class="form-control @error('user_id') is-invalid @enderror" value="{{ old('user_id',$userId) }}">@error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div><div class="col-md-4"><button class="btn btn-primary">Filter</button><a class="btn btn-outline-secondary" href="{{ route('external-posts.index') }}">Reset</a></div></form>
@if($error)<div class="alert alert-warning" role="alert">{{ $error }}</div>@endif
<div class="row g-3">@forelse($posts as $post)<div class="col-md-6"><div class="card h-100"><div class="card-body"><span class="badge text-bg-secondary mb-2">Post #{{ $post['id'] }}</span><h5>{{ $post['title'] }}</h5><p>{{ \Illuminate\Support\Str::limit($post['body'],120) }}</p><a href="{{ route('external-posts.show',$post['id']) }}">Baca detail</a></div></div></div>
@empty@if(!$error)<p class="text-secondary">Tidak ada artikel referensi.</p>@endif@endforelse</div>
@endsection
