@extends('layouts.app')
@section('title', 'Checkout')
@section('content')
<h1>Checkout</h1>
<div class="card">
    @foreach ($items as $i)
        <div class="row" style="justify-content:space-between"><span>{{ $i->book->title }} x {{ $i->qty }}</span><span>Rp {{ number_format($i->qty * $i->book->price, 0, ',', '.') }}</span></div>
    @endforeach
    <hr><b>Total: <span class="price">Rp {{ number_format($total, 0, ',', '.') }}</span></b>
</div>
<form method="POST" action="{{ route('checkout.store') }}" class="card form">
    @csrf
    <label>Alamat pengiriman lengkap</label>
    <textarea name="address" rows="4" required>{{ old('address') }}</textarea>

    <label>Metode pembayaran</label>
    <label style="font-weight:400">
        <input type="radio" name="payment_method" value="qris" style="width:auto" @checked(old('payment_method', 'qris') === 'qris')>
        QRIS (scan lalu upload bukti bayar)
    </label>
    <label style="font-weight:400">
        <input type="radio" name="payment_method" value="cod" style="width:auto" @checked(old('payment_method') === 'cod')>
        COD (bayar saat buku diterima)
    </label>

    <p><button class="btn green">Buat Pesanan</button></p>
</form>
@endsection
