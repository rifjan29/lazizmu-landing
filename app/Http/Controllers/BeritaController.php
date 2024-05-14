<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use App\Models\TentangKami;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(Request $request) {
        $param['berita'] = Informasi::with('kategori','user')
                        ->where('status_informasi','berita')
                        ->when($request->search, function ($query) use ($request) {
                            $query->where('title', 'like', '%' . $request->search . '%');
                        })
                        ->latest()
                        ->paginate(10);
        $param['tentang_kami'] = TentangKami::first();

        return view('frontend.berita.index',$param);
    }

    public function detail($slug) {
        $param['data'] = Informasi::with('kategori','user')
                                ->where('status_informasi','berita')
                                ->where('slug',$slug)->first();

        $param['tentang_kami'] = TentangKami::first();
        return view('frontend.berita.detail',$param);

    }
}
