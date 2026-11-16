@extends('layouts.app')
@section('title', 'Profil Saya')
@section('content')
<h1>Profil Saya</h1>

<div class="card">
    <div class="profile-head">
        <div class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
        <div>
            <h2 style="margin:0">{{ $user->name }}</h2>
            <div class="mut">{{ $user->email }}</div>
            <span class="badge {{ $user->role }}">{{ $user->role }}</span>
        </div>
    </div>
    <div class="profile-stats">
        <div><b>{{ $orderCount }}</b><span class="mut">Total pesanan</span></div>
        <div><b>{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</b><span class="mut">Terdaftar sejak</span></div>
    </div>
</div>

<div class="cols">
    <form method="POST" action="{{ route('profile.update') }}" class="card">
        @csrf @method('PUT')
        <h3>Ubah Data</h3>
        <label>Nama</label>
        <input name="name" value="{{ old('name', $user->name) }}" required>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
        <p><button class="btn">Simpan Profil</button></p>
    </form>

    <form method="POST" action="{{ route('profile.password') }}" class="card">
        @csrf @method('PUT')
        <h3>Ubah Password</h3>
        <label>Password saat ini</label>
        <input type="password" name="current_password" required>
        <label>Password baru (min. 6 karakter)</label>
        <input type="password" name="password" required>
        <label>Konfirmasi password baru</label>
        <input type="password" name="password_confirmation" required>
        <p><button class="btn">Ubah Password</button></p>
    </form>
</div>
@endsection
