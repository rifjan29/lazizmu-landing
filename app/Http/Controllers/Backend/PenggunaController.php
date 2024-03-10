<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index() {
        $param['title'] = "List User";
        $param['data'] = User::latest()->get();

        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('user.index',$param);
    }


}
