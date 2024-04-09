<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use Illuminate\Http\Request;

class DonasiController extends Controller
{
    public function index(Request $request) {
        $param['donasi'] = Donasi::with('kategori','user')
                        ->when($request->search, function ($query) use ($request) {
                            $query->where('title', 'like', '%' . $request->search . '%');
                        })
                        ->latest()
                        ->paginate(10);
        return view('frontend.donasi.index', $param);
    }

    public function detail($slug) {
        $param['title'] = 'Detail Donasi';
        $param['data'] = Donasi::with('kategori','user')->where('slug',$slug)->first();
        return view('frontend.donasi.detail',$param);
    }
}
