<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function user() { return $this->belongsTo(User::class); }
    public function items() { return $this->hasMany(OrderItem::class, 'order_id'); }

    /** Batalkan pesanan dan kembalikan stok buku. */
    public function cancel(): void
    {
        if ($this->status === 'cancelled') return;
        foreach ($this->items()->with('book')->get() as $i) {
            $i->book?->increment('stock', $i->qty);
        }
        $this->update(['status' => 'cancelled']);
    }

    /** Terapkan status dari Midtrans (callback / cek status). */
    public function applyMidtransStatus(?string $status, ?string $fraud = null): void
    {
        if (in_array($status, ['capture', 'settlement']) && $fraud !== 'challenge') {
            if ($this->status === 'pending') $this->update(['status' => 'paid']);
        } elseif (in_array($status, ['cancel', 'expire', 'deny'])) {
            $this->cancel();
        }
    }
}
