@extends('layouts.admin')
@section('title', 'Kategori')
@section('content')
<div class="row" style="justify-content:space-between"><h1>Kategori Buku</h1><a class="btn" href="{{ route('admin.categories.create') }}">+ Tambah Kategori</a></div>
<table>
    <tr><th>#</th><th>Nama</th><th>Jumlah Buku</th><th>Aksi</th></tr>
    @forelse ($categories as $c)
    <tr>
        <td>{{ $loop->iteration }}</td><td>{{ $c->name }}</td><td>{{ $c->books_count }}</td>
        <td class="row">
            <a class="btn sm sec" href="{{ route('admin.categories.edit', $c) }}">Edit</a>
            <form method="POST" action="{{ route('admin.categories.destroy', $c) }}" onsubmit="return confirm('Hapus kategori ini?')">@csrf @method('DELETE')<button class="btn sm red">Hapus</button></form>
        </td>
    </tr>
    @empty
    <tr><td colspan="4">Belum ada kategori.</td></tr>
    @endforelse
</table>
@endsection
