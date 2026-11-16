@extends('layouts.admin')
@section('title', $book->exists ? 'Edit Buku' : 'Tambah Buku')
@section('content')
<h1>{{ $book->exists ? 'Edit' : 'Tambah' }} Buku</h1>
<form class="card form" method="POST" enctype="multipart/form-data" action="{{ $book->exists ? route('admin.books.update', $book) : route('admin.books.store') }}">
    @csrf
    @if ($book->exists) @method('PUT') @endif
    <label>Kategori</label>
    <select name="category_id" required>
        <option value="">-- pilih --</option>
        @foreach ($categories as $c)
            <option value="{{ $c->id }}" @selected(old('category_id', $book->category_id) == $c->id)>{{ $c->name }}</option>
        @endforeach
    </select>
    <label>Judul</label><input name="title" value="{{ old('title', $book->title) }}" required>
    <label>Penulis</label><input name="author" value="{{ old('author', $book->author) }}" required>
    <label>Harga (Rp)</label><input type="number" name="price" min="0" value="{{ old('price', $book->price) }}" required>
    <label>Stok</label><input type="number" name="stock" min="0" value="{{ old('stock', $book->stock ?? 0) }}" required>
    <label>Deskripsi</label><textarea name="description" rows="4">{{ old('description', $book->description) }}</textarea>
    <label>Cover (jpg/png, maks 2 MB)</label>
    @if ($book->cover_url)<img class="thumb" src="{{ $book->cover_url }}" alt="" style="width:80px;height:100px;margin-bottom:6px">@endif
    <input type="file" name="cover" accept="image/*">
    <p><button class="btn">Simpan</button> <a class="btn sec" href="{{ route('admin.books.index') }}">Batal</a></p>
</form>
@endsection
