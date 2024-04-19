<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Donasi;
use App\Models\Galeri;
use App\Models\Informasi;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Do_;

class WelcomeController extends Controller
{
    public function index() {
        $param['total_donasi'] = Donasi::where('status','publis')->sum('total_donatur');
        $param['total_program'] = Donasi::where('status','publis')->count();
        $param['total_rupiah'] =  Donasi::where('status','publis')->sum('total_dana');
        $param['banner'] = Banner::latest()->first();
        $param['donasi'] = Donasi::with('kategori','user')->where('status','publis')->where('status_donasi','berjalan')->latest()->get()->take(3);
        $param['berita'] = Informasi::with('kategori','user')->where('status_informasi','berita')->latest()->get()->take(3);
        $param['galeri'] = Galeri::with('user')->latest()->get()->take(3);
        return view('frontend.welcome',$param);
    }
}
