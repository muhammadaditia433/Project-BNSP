<?php

namespace App\Http\Controllers;

use App\Models\{Book, CartItem};
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = auth()->user()->cartItems()->with('book')->get();
        $total = $items->sum(fn ($i) => $i->qty * $i->book->price);
        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $r, Book $book)
    {
        $qty = max(1, (int) $r->input('qty', 1));
        $item = CartItem::firstOrNew(['user_id' => auth()->id(), 'book_id' => $book->id]);
        $new = min(($item->qty ?? 0) + $qty, $book->stock);

        if ($new < 1) {
            return back()->withErrors(['cart' => 'Stok buku habis.']);
        }
        $item->qty = $new;
        $item->save();
        return back()->with('ok', 'Buku ditambahkan ke keranjang.');
    }

    public function update(Request $r, CartItem $item)
    {
        abort_unless($item->user_id === auth()->id(), 403);
        $item->update(['qty' => min(max(1, (int) $r->qty), max(1, $item->book->stock))]);
        return back();
    }

    public function destroy(CartItem $item)
    {
        abort_unless($item->user_id === auth()->id(), 403);
        $item->delete();
        return back()->with('ok', 'Item dihapus dari keranjang.');
    }
}
