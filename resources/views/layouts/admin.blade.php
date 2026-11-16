<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - Admin BookStore</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<div class="admin">
    <aside class="side">
        <h3>&#128218; Admin</h3>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'on' : '' }}">Dashboard</a>
        <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'on' : '' }}">Kategori</a>
        <a href="{{ route('admin.books.index') }}" class="{{ request()->routeIs('admin.books.*') ? 'on' : '' }}">Buku</a>
        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'on' : '' }}">Daftar User</a>
        <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'on' : '' }}">Pesanan</a>
        <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages.*') ? 'on' : '' }}">Pesan Masuk</a>
        <hr style="border-color:#374151">
        <a href="{{ route('home') }}">Lihat Toko</a>
        <a href="{{ route('profile.show') }}">Profil Saya</a>
        <form method="POST" action="{{ route('logout') }}">@csrf<button class="link" style="padding:8px 10px;color:#d1d5db">Logout</button></form>
    </aside>
    <section class="main">
        @include('partials.flash')
        @yield('content')
    </section>
</div>
</body>
</html>
