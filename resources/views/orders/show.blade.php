@extends('layouts.app')
@section('title', 'Pesanan '.$order->code)
@section('content')
<h1>Pesanan {{ $order->code }}</h1>
<div class="card">
    <p>Status: <span class="badge {{ $order->status }}">{{ $order->status }}</span></p>
    <p>Metode bayar: <b>{{ $order->payment_method === 'qris' ? 'QRIS' : 'COD (bayar di tempat)' }}</b></p>
    <p>Alamat: {{ $order->address }}</p>
    <table>
        <tr><th>Buku</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th></tr>
        @foreach ($order->items as $i)
        <tr><td>{{ $i->book->title }}</td><td>Rp {{ number_format($i->price, 0, ',', '.') }}</td><td>{{ $i->qty }}</td><td>Rp {{ number_format($i->price * $i->qty, 0, ',', '.') }}</td></tr>
        @endforeach
        <tr><td colspan="3" class="right"><b>Total</b></td><td><b>Rp {{ number_format($order->total, 0, ',', '.') }}</b></td></tr>
    </table>
</div>

@if ($order->payment_method === 'qris' && in_array($order->status, ['pending', 'verifying']))
<div class="card">
    <h3>Pembayaran QRIS</h3>
    <p>Scan QRIS, bayar sebesar <b>Rp {{ number_format($order->total, 0, ',', '.') }}</b>, lalu unggah foto bukti pembayaran.</p>
    <div class="qris">
        <img class="qr" alt="QRIS" src="{{ asset(file_exists(public_path('images/qris.png')) ? 'images/qris.png' : 'images/qris-contoh.png') }}">
        <div>
            @if ($order->payment_proof)
                <p><b>Bukti yang sudah dikirim:</b></p>
                <img class="proof" src="{{ asset('storage/'.$order->payment_proof) }}" alt="Bukti pembayaran">
                <p class="mut">Menunggu verifikasi admin. Kamu bisa mengirim ulang bukti jika salah.</p>
            @endif
            <form method="POST" action="{{ route('orders.proof', $order) }}" enctype="multipart/form-data">
                @csrf
                <label style="margin-top:0">Foto bukti pembayaran</label>
                <input type="file" name="proof" accept="image/*" required>
                <p><button class="btn green">Kirim Bukti Pembayaran</button></p>
            </form>
        </div>
    </div>
</div>
@elseif ($order->payment_method === 'cod' && $order->status === 'pending')
<div class="card">
    <h3>Bayar di Tempat (COD)</h3>
    <p>Siapkan uang tunai <b>Rp {{ number_format($order->total, 0, ',', '.') }}</b> dan bayar ke kurir saat buku diterima.</p>
</div>
@endif

<a href="{{ route('orders.index') }}">&larr; Kembali ke pesanan</a>
@endsection
