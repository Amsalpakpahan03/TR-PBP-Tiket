<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class KeretaViewController extends Controller
{
    //


    public function index()
    {
        $keretas = Http::get('http://localhost:8001/api/kereta')->json();
        return view('kereta.index', compact('keretas'));
    }

    public function formPesan($id)
    {
        $kereta = Http::get("http://localhost:8001/api/kereta/{$id}")->json();
        return view('tiket.form', compact('kereta'));
    }

}
