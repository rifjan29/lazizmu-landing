<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index() {
        return view('frontend.berita.index');
    }

    public function detail($slug) {
        return view('frontend.berita.detail');

    }
}
