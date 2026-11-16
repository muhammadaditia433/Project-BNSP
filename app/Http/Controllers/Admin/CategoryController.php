<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', ['categories' => Category::withCount('books')->orderBy('name')->get()]);
    }

    public function create() { return view('admin.categories.form', ['category' => new Category]); }

    public function store(Request $r)
    {
        Category::create($r->validate(['name' => 'required|max:100|unique:categories,name']));
        return redirect()->route('admin.categories.index')->with('ok', 'Kategori ditambahkan.');
    }

    public function edit(Category $category) { return view('admin.categories.form', compact('category')); }

    public function update(Request $r, Category $category)
    {
        $category->update($r->validate(['name' => 'required|max:100|unique:categories,name,'.$category->id]));
        return redirect()->route('admin.categories.index')->with('ok', 'Kategori diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->books()->exists()) {
            return back()->withErrors(['category' => 'Kategori masih dipakai oleh buku, tidak bisa dihapus.']);
        }
        $category->delete();
        return back()->with('ok', 'Kategori dihapus.');
    }
}
