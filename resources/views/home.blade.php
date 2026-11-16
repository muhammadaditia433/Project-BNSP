@extends('layouts.app')
@section('title', 'Beranda')
@section('content')
<section class="hero">
    <h1>Temukan buku favoritmu</h1>
    <p>Novel, teknologi, pendidikan, hingga buku anak. Pesan dari rumah, bayar dengan QRIS atau COD.</p>
    <form method="GET" action="{{ route('home') }}" class="search">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul atau penulis...">
        <select name="category">
            <option value="">Semua kategori</option>
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" @selected(request('category') == $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
        <button class="btn">Cari</button>
    </form>
</section>

<h2 style="margin:0 0 14px">Katalog Buku</h2>
@if ($books->isEmpty())
    <div class="card">Buku tidak ditemukan.</div>
@else
<div class="grid">
    @foreach ($books as $b)
    <div class="book">
        <a href="{{ route('books.show', $b) }}" class="cov">
            @if ($b->cover_url)<img src="{{ $b->cover_url }}" alt="{{ $b->title }}">@else {{ strtoupper(substr($b->title, 0, 1)) }} @endif
        </a>
        <div class="body">
            <span class="badge">{{ $b->category->name }}</span>
            <a href="{{ route('books.show', $b) }}"><b>{{ $b->title }}</b></a>
            <span class="mut">{{ $b->author }}</span>
            <span class="price">Rp {{ number_format($b->price, 0, ',', '.') }}</span>
            @if ($b->stock > 0)
                <form method="POST" action="{{ route('cart.add', $b) }}">@csrf<button class="btn sm block">+ Keranjang</button></form>
            @else
                <span class="mut">Stok habis</span>
            @endif
        </div>
    </div>
    @endforeach
</div>
{{ $books->links() }}
@endif
@endsection
