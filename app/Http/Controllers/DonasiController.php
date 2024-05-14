<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\TentangKami;
use Illuminate\Http\Request;

class DonasiController extends Controller
{
    public function index(Request $request) {
        $param['tentang_kami'] = TentangKami::first();
        $param['donasi'] = Donasi::with('kategori','user')
                        ->when($request->search, function ($query) use ($request) {
                            $query->where('title', 'like', '%' . $request->search . '%');
                        })
                        ->where('status','publis')
                        ->latest()
                        ->paginate(10);
        return view('frontend.donasi.index', $param);
    }

    public function detail($slug) {
        $param['tentang_kami'] = TentangKami::first();
        $param['title'] = 'Detail Donasi';
        $param['data'] = Donasi::with('kategori','user')->where('slug',$slug)->first();
        return view('frontend.donasi.detail',$param);
    }
}
