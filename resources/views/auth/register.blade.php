@extends('layouts.app')
@section('title', 'Register')
@section('content')
<div class="card center">
    <h2>Registrasi User</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <label>Nama</label><input name="name" value="{{ old('name') }}" required autofocus>
        <label>Email</label><input type="email" name="email" value="{{ old('email') }}" required>
        <label>Password (min. 6 karakter)</label><input type="password" name="password" required>
        <label>Konfirmasi Password</label><input type="password" name="password_confirmation" required>
        <p><button class="btn">Daftar</button></p>
    </form>
    <p class="mut">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
</div>
@endsection
