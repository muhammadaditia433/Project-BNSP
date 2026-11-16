@extends('layouts.admin')
@section('title', 'Buku')
@section('content')
<div class="row" style="justify-content:space-between"><h1>Data Buku</h1><a class="btn" href="{{ route('admin.books.create') }}">+ Tambah Buku</a></div>
<table>
    <tr><th>Cover</th><th>Judul</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr>
    @forelse ($books as $b)
    <tr>
        <td>@if ($b->cover_url)<img class="thumb" src="{{ $b->cover_url }}" alt="">@else<div class="thumb"></div>@endif</td>
        <td><b>{{ $b->title }}</b><br><span class="mut">{{ $b->author }}</span></td>
        <td>{{ $b->category->name }}</td>
        <td>Rp {{ number_format($b->price, 0, ',', '.') }}</td>
        <td>{{ $b->stock }}</td>
        <td class="row">
            <a class="btn sm sec" href="{{ route('admin.books.edit', $b) }}">Edit</a>
            <form method="POST" action="{{ route('admin.books.destroy', $b) }}" onsubmit="return confirm('Hapus buku ini?')">@csrf @method('DELETE')<button class="btn sm red">Hapus</button></form>
        </td>
    </tr>
    @empty
    <tr><td colspan="6">Belum ada buku.</td></tr>
    @endforelse
</table>
{{ $books->links() }}
@endsection
