<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];

    public function category() { return $this->belongsTo(Category::class); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }

    public function getCoverUrlAttribute(): ?string
    {
        if (!$this->cover) return null;

        return str_starts_with($this->cover, 'images/')
            ? asset($this->cover)             // gambar bawaan di public/images
            : asset('storage/'.$this->cover); // hasil upload admin
    }
}