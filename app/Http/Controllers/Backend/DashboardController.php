<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\Informasi;
use App\Models\Kategori;
use App\Models\Pengurus;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {

        $param['user'] = User::count();
        $param['kategori'] = Kategori::count();
        $param['informasi'] = Informasi::where('status_informasi','informasi')->count();
        $param['berita'] =  Informasi::where('status_informasi','berita')->count();
        $param['donasi'] = Donasi::count();
        $param['pengurus'] = Pengurus::count();
        return view('dashboard',$param);
    }
}
