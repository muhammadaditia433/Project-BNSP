<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Book, Category, Message, Order, User};

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'books'      => Book::count(),
            'categories' => Category::count(),
            'users'      => User::where('role', 'user')->count(),
            'orders'     => Order::count(),
            'pending'    => Order::where('status', 'pending')->count(),
            'messages'   => Message::count(),
            'latest'     => Order::with('user')->latest()->take(5)->get(),
        ]);
    }
}
