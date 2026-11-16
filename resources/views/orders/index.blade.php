@extends('layouts.app')
@section('title', 'Pesanan Saya')
@section('content')
<h1>Pesanan Saya</h1>
@if ($orders->isEmpty())
    <div class="card">Belum ada pesanan.</div>
@else
<table>
    <tr><th>Kode</th><th>Tanggal</th><th>Total</th><th>Status</th><th></th></tr>
    @foreach ($orders as $o)
    <tr>
        <td>{{ $o->code }}</td><td>{{ $o->created_at->format('d M Y H:i') }}</td>
        <td>Rp {{ number_format($o->total, 0, ',', '.') }}</td>
        <td><span class="badge {{ $o->status }}">{{ $o->status }}</span></td>
        <td><a class="btn sm" href="{{ route('orders.show', $o) }}">Detail</a></td>
    </tr>
    @endforeach
</table>
@endif
@endsection
