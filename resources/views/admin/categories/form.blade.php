@extends('layouts.admin')
@section('title', $category->exists ? 'Edit Kategori' : 'Tambah Kategori')
@section('content')
<h1>{{ $category->exists ? 'Edit' : 'Tambah' }} Kategori</h1>
<form class="card form" method="POST" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
    @csrf
    @if ($category->exists) @method('PUT') @endif
    <label>Nama kategori</label>
    <input name="name" value="{{ old('name', $category->name) }}" required>
    <p><button class="btn">Simpan</button> <a class="btn sec" href="{{ route('admin.categories.index') }}">Batal</a></p>
</form>
@endsection
