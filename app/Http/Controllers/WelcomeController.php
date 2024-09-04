<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Donasi;
use App\Models\Galeri;
use App\Models\Informasi;
use App\Models\TentangKami;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Do_;

class WelcomeController extends Controller
{
    public function index(Request $request) {
        $pilih_program = $request->has('pilih_program') ? $request->pilih_program : 'semua';
        $pilih_status = $request->has('status_donasi') ? $request->status_donasi : 'semua';
        $param['total_donasi'] = Donasi::where('status','publis')->sum('total_donatur');
        $param['total_program'] = Donasi::where('status','publis')->count();
        $param['total_rupiah'] =  Donasi::where('status','publis')->sum('total_dana');
        $param['banner'] = Banner::latest()->first();
        $param['donasi'] = Donasi::with('kategori','user')
            ->whereHas('kategori', function ($query) use ($pilih_program) {
                if ($pilih_program != 'semua') {
                    $query->where('title', $pilih_program);
                }
            })
            ->where('status','publis')
            ->when($pilih_status != 'semua', function ($query) use ($pilih_status) {
                $query->where('status_donasi', $pilih_status);
            })
            ->latest()->get()->take(3);
        $param['berita'] = Informasi::with('kategori','user')->where('status_informasi','berita')->latest()->get()->take(3);
        $param['galeri'] = Galeri::with('user')->latest()->get()->take(3);
        $param['tentang_kami'] = TentangKami::first();
        return view('frontend.welcome',$param);
    }
}
