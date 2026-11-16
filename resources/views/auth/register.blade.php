@extends('layouts.app')
@section('title', 'Daftar')
@section('content')
<div class="auth">
    <div class="auth-card">
        <h2>Buat akun baru</h2>
        <p class="sub">Setelah mendaftar, kamu akan diarahkan ke halaman login.</p>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <label>Nama</label><input name="name" value="{{ old('name') }}" required autofocus>
            <label>Email</label><input type="email" name="email" value="{{ old('email') }}" required>
            <label>Password (min. 6 karakter)</label><input type="password" name="password" required>
            <label>Konfirmasi password</label><input type="password" name="password_confirmation" required>
            <p><button class="btn block">Daftar</button></p>
        </form>
        <p class="mut" style="text-align:center">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
    </div>
</div>
@endsection
