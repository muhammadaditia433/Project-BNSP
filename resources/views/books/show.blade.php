@extends('layouts.app')
@section('title', $book->title)
@section('content')
<div class="card detail">
    <div class="cover">
        @if ($book->cover_url)<img src="{{ $book->cover_url }}" alt="{{ $book->title }}">@else {{ strtoupper(substr($book->title, 0, 1)) }} @endif
    </div>
    <div>
        <span class="badge">{{ $book->category->name }}</span>
        <h1 style="margin:8px 0">{{ $book->title }}</h1>
        <p class="mut">Penulis: {{ $book->author }}</p>
        <p class="price" style="font-size:1.5rem">Rp {{ number_format($book->price, 0, ',', '.') }}</p>
        <p>Stok: {{ $book->stock }}</p>
        <p>{{ $book->description }}</p>
        @if ($book->stock > 0)
            <form method="POST" action="{{ route('cart.add', $book) }}" class="row">
                @csrf
                <input type="number" name="qty" value="1" min="1" max="{{ $book->stock }}" style="width:80px">
                <button class="btn">Tambah ke Keranjang</button>
            </form>
        @else
            <p class="mut">Stok habis.</p>
        @endif
        <p><a href="{{ route('home') }}">&larr; Kembali ke katalog</a></p>
    </div>
</div>
@endsection
