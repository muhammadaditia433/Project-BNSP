<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function create() { return view('contact'); }

    public function store(Request $r)
    {
        auth()->user()->messages()->create($r->validate([
            'subject' => 'required|max:150',
            'body'    => 'required|max:2000',
        ]));
        return back()->with('ok', 'Pesan terkirim ke admin.');
    }
}
