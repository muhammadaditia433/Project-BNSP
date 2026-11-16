<?php

namespace App\Http\Controllers;

use App\Models\{Book, Category};
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $r)
    {
        $books = Book::with('category')
            ->when($r->q, fn ($q, $s) => $q->where(fn ($w) => $w->where('title', 'like', "%$s%")->orWhere('author', 'like', "%$s%")))
            ->when($r->category, fn ($q, $c) => $q->where('category_id', $c))
            ->latest()->paginate(8)->withQueryString();

        return view('home', ['books' => $books, 'categories' => Category::orderBy('name')->get()]);
    }

    public function show(Book $book)
    {
        return view('books.show', ['book' => $book->load('category')]);
    }
}
