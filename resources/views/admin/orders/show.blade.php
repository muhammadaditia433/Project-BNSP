@extends('layouts.admin')
@section('title', 'Pesanan '.$order->code)
@section('content')
<h1>Pesanan {{ $order->code }}</h1>
<div class="card">
    <p><b>Pemesan:</b> {{ $order->user->name }} ({{ $order->user->email }})</p>
    <p><b>Alamat:</b> {{ $order->address }}</p>
    <p><b>Metode bayar:</b> {{ strtoupper($order->payment_method) }}</p>

    @if ($order->payment_proof)
        <p><b>Bukti pembayaran:</b></p>
        <a href="{{ asset('storage/'.$order->payment_proof) }}" target="_blank">
            <img class="proof" src="{{ asset('storage/'.$order->payment_proof) }}" alt="Bukti pembayaran">
        </a>
    @elseif ($order->payment_method === 'qris')
        <p class="mut">Belum ada bukti pembayaran dari user.</p>
    @endif

    <p><b>Status:</b> <span class="badge {{ $order->status }}">{{ $order->status }}</span></p>
    <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="inline">
        @csrf @method('PATCH')
        <select name="status" style="max-width:200px">
            @foreach (['pending', 'verifying', 'paid', 'shipped', 'done', 'cancelled'] as $s)
                <option value="{{ $s }}" @selected($order->status === $s)>{{ $s }}</option>
            @endforeach
        </select>
        <button class="btn">Ubah Status</button>
    </form>
</div>
<table>
    <tr><th>Buku</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th></tr>
    @foreach ($order->items as $i)
    <tr><td>{{ $i->book->title }}</td><td>Rp {{ number_format($i->price, 0, ',', '.') }}</td><td>{{ $i->qty }}</td><td>Rp {{ number_format($i->price * $i->qty, 0, ',', '.') }}</td></tr>
    @endforeach
    <tr><td colspan="3" class="right"><b>Total</b></td><td><b>Rp {{ number_format($order->total, 0, ',', '.') }}</b></td></tr>
</table>
<p><a href="{{ route('admin.orders.index') }}">&larr; Kembali</a></p>
@endsection
