<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Tiket;

class FrontendTiketController extends Controller
{
    public function create()
    {
        $keretas = Http::get('http://localhost:8002/api/kereta')->json(); // Ambil data dari service lain
        return view('tiket.pesan', compact('keretas'));
    }

    public function store(Request $request)
    {
        Tiket::create($request->all());
        return redirect()->route('tiket.pesan')->with('success', 'Tiket berhasil dipesan!');
    }
}
