<?php

namespace App\Http\Controllers;

use App\Models\Pengurus;
use App\Models\TentangKami;
use Illuminate\Http\Request;

class TentangKamiController extends Controller
{
    public function latarBelakang() {
        $param['title'] = 'Latar Belakang';
        $param['data'] = TentangKami::first();
        return view('frontend.tentang-kami.latar-belakang.index',$param);
    }

    public function visiMisi() {
        $param['title'] = 'Visi & Misi';
        $param['data'] = TentangKami::first();
        return view('frontend.tentang-kami.visi.index',$param);
    }

    public function keanggotaan() {
        $param['title'] = 'Keanggotaan';
        $param['data'] = TentangKami::first();
        $param['pengurus'] = Pengurus::latest()->get();
        return view('frontend.tentang-kami.keanggotaan.index',$param);
    }
}
