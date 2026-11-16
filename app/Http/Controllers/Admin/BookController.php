<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Book, Category};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    private function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|max:200',
            'author'      => 'required|max:150',
            'price'       => 'required|integer|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|max:3000',
            'cover'       => 'nullable|image|max:2048',
        ];
    }

    public function index()
    {
        return view('admin.books.index', ['books' => Book::with('category')->latest()->paginate(10)]);
    }

    public function create()
    {
        return view('admin.books.form', ['book' => new Book, 'categories' => Category::orderBy('name')->get()]);
    }

    public function store(Request $r)
    {
        $data = $r->validate($this->rules());
        if ($r->hasFile('cover')) $data['cover'] = $r->file('cover')->store('covers', 'public');
        Book::create($data);
        return redirect()->route('admin.books.index')->with('ok', 'Buku ditambahkan.');
    }

    public function edit(Book $book)
    {
        return view('admin.books.form', ['book' => $book, 'categories' => Category::orderBy('name')->get()]);
    }

    public function update(Request $r, Book $book)
    {
        $data = $r->validate($this->rules());
        if ($r->hasFile('cover')) {
            if ($book->cover) Storage::disk('public')->delete($book->cover);
            $data['cover'] = $r->file('cover')->store('covers', 'public');
        }
        $book->update($data);
        return redirect()->route('admin.books.index')->with('ok', 'Buku diperbarui.');
    }

    public function destroy(Book $book)
    {
        if ($book->orderItems()->exists()) {
            return back()->withErrors(['book' => 'Buku sudah pernah dipesan, tidak bisa dihapus. Ubah stok menjadi 0 sebagai gantinya.']);
        }
        if ($book->cover) Storage::disk('public')->delete($book->cover);
        $book->delete();
        return back()->with('ok', 'Buku dihapus.');
    }
}
