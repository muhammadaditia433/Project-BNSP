<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::where('role', 'user')->withCount('orders')->latest()->paginate(10),
        ]);
    }
}
