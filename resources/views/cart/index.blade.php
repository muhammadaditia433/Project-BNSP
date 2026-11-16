@extends('layouts.app')
@section('title', 'Keranjang')
@section('content')
<h1>Keranjang Belanja</h1>
@if ($items->isEmpty())
    <div class="card">Keranjang kosong. <a href="{{ route('home') }}">Cari buku</a></div>
@else
<table>
    <tr><th>Buku</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th><th></th></tr>
    @foreach ($items as $i)
    <tr>
        <td><a href="{{ route('books.show', $i->book) }}">{{ $i->book->title }}</a></td>
        <td>Rp {{ number_format($i->book->price, 0, ',', '.') }}</td>
        <td>
            <form method="POST" action="{{ route('cart.update', $i) }}" class="row">
                @csrf @method('PATCH')
                <input type="number" name="qty" value="{{ $i->qty }}" min="1" max="{{ $i->book->stock }}" style="width:70px">
                <button class="btn sm sec">Ubah</button>
            </form>
        </td>
        <td>Rp {{ number_format($i->qty * $i->book->price, 0, ',', '.') }}</td>
        <td><form method="POST" action="{{ route('cart.destroy', $i) }}">@csrf @method('DELETE')<button class="btn sm red">Hapus</button></form></td>
    </tr>
    @endforeach
    <tr><td colspan="3" class="right"><b>Total</b></td><td colspan="2"><b class="price">Rp {{ number_format($total, 0, ',', '.') }}</b></td></tr>
</table>
<p class="right"><a class="btn green" href="{{ route('checkout.form') }}">Lanjut ke Checkout</a></p>
@endif
@endsection
