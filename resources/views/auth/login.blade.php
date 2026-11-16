@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="auth">
    <div class="auth-card">
        <h2>Selamat datang</h2>
        <p class="sub">Login untuk melanjutkan belanja.</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label>Email</label><input type="email" name="email" value="{{ old('email') }}" required autofocus>
            <label>Password</label><input type="password" name="password" required>
            <label style="font-weight:400;display:flex;gap:8px;align-items:center"><input type="checkbox" name="remember"> Ingat saya</label>
            <p><button class="btn block">Masuk</button></p>
        </form>
        <p class="mut" style="text-align:center">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
    </div>
</div>
@endsection
