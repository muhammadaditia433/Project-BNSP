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
    <p>Scan QRIS di bawah, bayar sebesar <b>Rp {{ number_format($order->total, 0, ',', '.') }}</b>, lalu unggah foto bukti pembayaran.</p>

    @if (file_exists(public_path('images/qris.png')))
        <img src="{{ asset('images/qris.png') }}" alt="QRIS" style="max-width:280px;border:1px solid #e5e7eb;border-radius:8px">
    @else
        <p class="mut">(Gambar QRIS belum dipasang. Taruh file di public/images/qris.png)</p>
    @endif

    @if ($order->payment_proof)
        <p>Bukti yang sudah dikirim:</p>
        <img src="{{ asset('storage/'.$order->payment_proof) }}" alt="Bukti" style="max-width:240px;border:1px solid #e5e7eb;border-radius:8px">
        <p class="mut">Menunggu verifikasi admin. Kamu bisa mengirim ulang bukti jika salah.</p>
    @endif

    <form method="POST" action="{{ route('orders.proof', $order) }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="proof" accept="image/*" required>
        <p><button class="btn green">Kirim Bukti Pembayaran</button></p>
    </form>
</div>
@elseif ($order->payment_method === 'cod' && $order->status === 'pending')
<div class="card">
    <h3>Bayar di Tempat (COD)</h3>
    <p>Siapkan uang tunai <b>Rp {{ number_format($order->total, 0, ',', '.') }}</b> dan bayar ke kurir saat buku diterima.</p>
</div>
@endif

<a href="{{ route('orders.index') }}">&larr; Kembali</a>
@endsection