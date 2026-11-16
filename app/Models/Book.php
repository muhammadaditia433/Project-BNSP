<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];

    public function category() { return $this->belongsTo(Category::class); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }

    /**
     * Alamat gambar cover.
     * - 'images/...' : gambar bawaan di folder public/images
     * - lainnya      : hasil upload admin di storage (public/storage)
     */
    public function getCoverUrlAttribute(): ?string
    {
        if (!$this->cover) return null;
        return str_starts_with($this->cover, 'images/')
            ? asset($this->cover)
            : asset('storage/'.$this->cover);
    }
}
