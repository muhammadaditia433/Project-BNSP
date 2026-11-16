<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Beranda') - BookStore</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<nav class="nav"><div class="container">
    <a class="brand" href="{{ route('home') }}">&#128218; BookStore</a>
    <a href="{{ route('home') }}">Beranda</a>
    <a href="{{ route('about') }}">About Us</a>
    @auth
        <a href="{{ route('contact.create') }}">Hubungi Admin</a>
        <a href="{{ route('cart.index') }}">Keranjang ({{ auth()->user()->cartItems()->sum('qty') }})</a>
        <a href="{{ route('orders.index') }}">Pesanan Saya</a>
        @if (auth()->user()->isAdmin())<a href="{{ route('admin.dashboard') }}">Panel Admin</a>@endif
        <form method="POST" action="{{ route('logout') }}">@csrf<button class="link">Logout ({{ auth()->user()->name }})</button></form>
    @else
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}">Register</a>
    @endauth
</div></nav>
<main class="container">
    @include('partials.flash')
    @yield('content')
</main>
<footer>&copy; {{ date('Y') }} BookStore - Projek Laravel</footer>
</body>
</html>
