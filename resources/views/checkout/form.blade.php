@extends('layouts.app')
@section('title', 'Checkout')
@section('content')
<h1>Checkout</h1>
<div class="card">
    @foreach ($items as $i)
        <div class="row" style="justify-content:space-between;padding:6px 0"><span>{{ $i->book->title }} <span class="mut">x {{ $i->qty }}</span></span><span>Rp {{ number_format($i->qty * $i->book->price, 0, ',', '.') }}</span></div>
    @endforeach
    <hr>
    <div class="row" style="justify-content:space-between"><b>Total</b><b class="price">Rp {{ number_format($total, 0, ',', '.') }}</b></div>
</div>

<form method="POST" action="{{ route('checkout.store') }}" class="card">
    @csrf
    <label style="margin-top:0">Alamat pengiriman lengkap</label>
    <textarea name="address" rows="4" required>{{ old('address') }}</textarea>

    <label>Metode pembayaran</label>
    <div class="pay-grid">
        <label class="pay-opt">
            <input type="radio" name="payment_method" value="qris" @checked(old('payment_method', 'qris') === 'qris')>
            <span><b>QRIS</b><small>Scan, bayar, lalu upload bukti</small></span>
        </label>
        <label class="pay-opt">
            <input type="radio" name="payment_method" value="cod" @checked(old('payment_method') === 'cod')>
            <span><b>COD</b><small>Bayar tunai saat buku diterima</small></span>
        </label>
    </div>
    <button class="btn green">Buat Pesanan</button>
</form>
@endsection
