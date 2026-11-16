<?php

namespace App\Http\Controllers;

use App\Models\{Book, Order};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Storage};
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function form()
    {
        $items = auth()->user()->cartItems()->with('book')->get();
        if ($items->isEmpty()) return redirect()->route('cart.index')->withErrors(['cart' => 'Keranjang masih kosong.']);
        return view('checkout.form', ['items' => $items, 'total' => $items->sum(fn ($i) => $i->qty * $i->book->price)]);
    }

    public function store(Request $r)
    {
        $r->validate([
            'address'        => 'required|min:10',
            'payment_method' => 'required|in:qris,cod',
        ]);
        $user = auth()->user();

        $order = DB::transaction(function () use ($user, $r) {
            $items = $user->cartItems()->with('book')->get();
            if ($items->isEmpty()) return null;

            foreach ($items as $i) {
                $b = Book::lockForUpdate()->find($i->book_id);
                if ($b->stock < $i->qty) {
                    throw ValidationException::withMessages(['cart' => "Stok \"{$b->title}\" tidak cukup (sisa {$b->stock})."]);
                }
            }

            $order = Order::create([
                'user_id'        => $user->id,
                'code'           => 'BK-'.strtoupper(Str::random(8)),
                'total'          => $items->sum(fn ($i) => $i->qty * $i->book->price),
                'address'        => $r->address,
                'payment_method' => $r->payment_method,
            ]);
            foreach ($items as $i) {
                $order->items()->create(['book_id' => $i->book_id, 'price' => $i->book->price, 'qty' => $i->qty]);
                $i->book->decrement('stock', $i->qty);
            }
            $user->cartItems()->delete();
            return $order;
        });

        if (!$order) return redirect()->route('home');

        return redirect()->route('orders.show', $order)->with('ok', 'Pesanan berhasil dibuat.');
    }

    public function history()
    {
        return view('orders.index', ['orders' => auth()->user()->orders()->latest()->get()]);
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        return view('orders.show', ['order' => $order->load('items.book')]);
    }

    /** Upload foto bukti pembayaran QRIS. */
    public function uploadProof(Request $r, Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        abort_unless($order->payment_method === 'qris' && in_array($order->status, ['pending', 'verifying']), 403);

        $r->validate(['proof' => 'required|image|max:2048']);

        if ($order->payment_proof) Storage::disk('public')->delete($order->payment_proof);
        $order->update([
            'payment_proof' => $r->file('proof')->store('proofs', 'public'),
            'status'        => 'verifying',
        ]);

        return back()->with('ok', 'Bukti pembayaran terkirim. Menunggu verifikasi admin.');
    }
}
