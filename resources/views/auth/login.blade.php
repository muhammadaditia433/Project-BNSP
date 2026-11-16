@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="card center">
    <h2>Login</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label>Email</label><input type="email" name="email" value="{{ old('email') }}" required autofocus>
        <label>Password</label><input type="password" name="password" required>
        <label style="font-weight:400"><input type="checkbox" name="remember" style="width:auto"> Ingat saya</label>
        <p><button class="btn">Masuk</button></p>
    </form>
    <p class="mut">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
</div>
@endsection
