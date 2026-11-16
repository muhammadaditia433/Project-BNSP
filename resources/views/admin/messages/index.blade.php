@extends('layouts.admin')
@section('title', 'Pesan Masuk')
@section('content')
<h1>Pesan dari User</h1>
@forelse ($messages as $m)
<div class="card">
    <b>{{ $m->subject }}</b>
    <div class="mut">{{ $m->user->name }} ({{ $m->user->email }}) &middot; {{ $m->created_at->format('d M Y H:i') }}</div>
    <p>{{ $m->body }}</p>
</div>
@empty
<div class="card">Belum ada pesan.</div>
@endforelse
{{ $messages->links() }}
@endsection
