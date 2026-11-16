@extends('layouts.admin')
@section('title', 'Daftar User')
@section('content')
<h1>User Terdaftar</h1>
<table>
    <tr><th>#</th><th>Nama</th><th>Email</th><th>Terdaftar</th><th>Jumlah Pesanan</th></tr>
    @forelse ($users as $u)
    <tr><td>{{ $users->firstItem() + $loop->index }}</td><td>{{ $u->name }}</td><td>{{ $u->email }}</td><td>{{ $u->created_at->format('d M Y') }}</td><td>{{ $u->orders_count }}</td></tr>
    @empty
    <tr><td colspan="5">Belum ada user.</td></tr>
    @endforelse
</table>
{{ $users->links() }}
@endsection
