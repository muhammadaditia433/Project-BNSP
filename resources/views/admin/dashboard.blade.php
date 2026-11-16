@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<h1>Dashboard</h1>
<div class="stats">
    <div class="stat"><b>{{ $books }}</b>Buku</div>
    <div class="stat"><b>{{ $categories }}</b>Kategori</div>
    <div class="stat"><b>{{ $users }}</b>User terdaftar</div>
    <div class="stat"><b>{{ $orders }}</b>Total pesanan</div>
    <div class="stat"><b>{{ $pending }}</b>Menunggu pembayaran</div>
    <div class="stat"><b>{{ $messages }}</b>Pesan masuk</div>
</div>
<h3>Pesanan Terbaru</h3>
<table>
    <tr><th>Kode</th><th>User</th><th>Total</th><th>Status</th><th></th></tr>
    @forelse ($latest as $o)
    <tr>
        <td>{{ $o->code }}</td><td>{{ $o->user->name }}</td>
        <td>Rp {{ number_format($o->total, 0, ',', '.') }}</td>
        <td><span class="badge {{ $o->status }}">{{ $o->status }}</span></td>
        <td><a class="btn sm" href="{{ route('admin.orders.show', $o) }}">Detail</a></td>
    </tr>
    @empty
    <tr><td colspan="5">Belum ada pesanan.</td></tr>
    @endforelse
</table>
@endsection
