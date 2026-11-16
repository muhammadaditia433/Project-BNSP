<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Beranda') - BookStore</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<header class="nav"><div class="nav-in">
    <a class="brand" href="{{ route('home') }}"><span class="logo">B</span> BookStore</a>
    <nav class="links">
        <a href="{{ route('home') }}">Beranda</a>
        <a href="{{ route('about') }}">About Us</a>
        @auth
            <a href="{{ route('contact.create') }}">Hubungi Admin</a>
            <a href="{{ route('cart.index') }}">Keranjang <span class="pill">{{ auth()->user()->cartItems()->sum('qty') }}</span></a>
            <a href="{{ route('orders.index') }}">Pesanan</a>
            <a href="{{ route('profile.show') }}">Profil</a>
            @if (auth()->user()->isAdmin())<a href="{{ route('admin.dashboard') }}">Panel Admin</a>@endif
            <form method="POST" action="{{ route('logout') }}">@csrf<button class="link">Keluar</button></form>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a class="btn sm" href="{{ route('register') }}">Daftar</a>
        @endauth
    </nav>
</div></header>
<main class="container">
    @include('partials.flash')
    @yield('content')
</main>
<footer>&copy; {{ date('Y') }} BookStore &middot; Dibuat dengan Laravel</footer>
</body>
</html>
