@extends('layouts.app')
@section('title', 'Hubungi Admin')
@section('content')
<div class="card form">
    <h2>Hubungi Admin</h2>
    <form method="POST" action="{{ route('contact.store') }}">
        @csrf
        <label>Subjek</label><input name="subject" value="{{ old('subject') }}" required>
        <label>Pesan</label><textarea name="body" rows="6" required>{{ old('body') }}</textarea>
        <p><button class="btn">Kirim Pesan</button></p>
    </form>
</div>
@endsection
