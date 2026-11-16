<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.orders.index', ['orders' => Order::with('user')->latest()->paginate(10)]);
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', ['order' => $order->load('user', 'items.book')]);
    }

    public function update(Request $r, Order $order)
    {
        $status = $r->validate([
            'status' => 'required|in:pending,verifying,paid,shipped,done,cancelled',
        ])['status'];

        if ($order->status === 'cancelled') {
            return back()->withErrors(['status' => 'Pesanan yang sudah dibatalkan tidak dapat diubah.']);
        }

        if ($status === 'cancelled') {
            $order->cancel(); // stok dikembalikan
        } else {
            $order->update(['status' => $status]);
        }

        return back()->with('ok', 'Status pesanan diperbarui.');
    }
}