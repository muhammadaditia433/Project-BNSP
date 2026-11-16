@extends('layouts.admin')
@section('title', 'Pesanan')
@section('content')
<h1>Daftar Pesanan</h1>
<table>
    <tr><th>Kode</th><th>User</th><th>Tanggal</th><th>Bayar</th><th>Total</th><th>Status</th><th></th></tr>
    @forelse ($orders as $o)
    <tr>
        <td>{{ $o->code }}</td><td>{{ $o->user->name }}</td><td>{{ $o->created_at->format('d M Y H:i') }}</td>
        <td>{{ strtoupper($o->payment_method) }}</td>
        <td>Rp {{ number_format($o->total, 0, ',', '.') }}</td>
        <td><span class="badge {{ $o->status }}">{{ $o->status }}</span></td>
        <td><a class="btn sm" href="{{ route('admin.orders.show', $o) }}">Detail</a></td>
    </tr>
    @empty
    <tr><td colspan="7">Belum ada pesanan.</td></tr>
    @endforelse
</table>
{{ $orders->links() }}
@endsection
