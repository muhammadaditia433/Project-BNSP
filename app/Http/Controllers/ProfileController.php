<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('profile', ['user' => $user, 'orderCount' => $user->orders()->count()]);
    }

    public function update(Request $r)
    {
        $user = auth()->user();
        $data = $r->validate([
            'name'  => 'required|max:100',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
        ]);
        $user->update($data);
        return back()->with('ok', 'Profil diperbarui.');
    }

    public function updatePassword(Request $r)
    {
        $r->validate([
            'current_password' => 'required',
            'password'         => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();
        if (!Hash::check($r->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $user->update(['password' => $r->password]); // otomatis di-hash oleh cast di model User
        return back()->with('ok', 'Password diperbarui.');
    }
}
