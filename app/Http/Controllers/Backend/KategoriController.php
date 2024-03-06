<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $param;
    public function index()
    {
        $param['title'] = "List Kategori";
        $param['data'] = Kategori::latest()->get();

        $title = 'Delete Kategori!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('kategori.index',$param);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = Validator::make($request->all(),[
            'name' => 'required|unique:kategori,title',
            'kategori' => 'required',
        ],[
            'required' => ':attribute data harus terisi',
        ],[
            'name' => 'Kategori',
            'kategori' => 'Status Kategori',
        ]);
        if ($validateData->fails()) {
            $html = "<ol class='max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400'>";
            foreach($validateData->errors()->getMessages() as $error) {
                $html .= "<li>$error[0]</li>";
            }
            $html .= "</ol>";

            alert()->html('Terjadi kesalahan eror!', $html, 'error')->autoClose(5000);
            return redirect()->route('kategori.index');
        }
        DB::beginTransaction();
        try {
            DB::commit();
            $tambah = new Kategori;
            $tambah->title = $request->get('name');
            $tambah->status_informasi = $request->get('kategori');
            $tambah->keterangan = $request->get('keterangan');
            $tambah->save();
            alert()->success('Sukses','Berhasil menambahkan data.');
            return redirect()->route('kategori.index');
        } catch (Exception $e) {
            DB::rollBack();
            alert()->success('Error','Terjadi kesalahan.');
            return redirect()->route('kategori.index');
        };
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        try {
            $data = Kategori::find($request->get('id'));
            return $data;
        } catch (Exception $th) {
            return $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        try {
            $data = Kategori::find($request->get('id'));
            return $data;
        } catch (Exception $th) {
            return $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData = Validator::make($request->all(),[
            'name' => 'required',
            'kategori' => 'required',
        ],[
            'required' => ':attribute data harus terisi',
        ],[
            'name' => 'Kategori',
            'kategori' => 'Status Kategori',
        ]);
        if ($validateData->fails()) {
            $html = "<ol class='max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400'>";
            foreach($validateData->errors()->getMessages() as $error) {
                $html .= "<li>$error[0]</li>";
            }
            $html .= "</ol>";

            alert()->html('Terjadi kesalahan eror!', $html, 'error')->autoClose(5000);
            return redirect()->route('kategori.index');
        }
        DB::beginTransaction();
        try {
            DB::commit();
            $tambah = Kategori::find($request->get('id'));
            $tambah->title = $request->get('name');
            $tambah->status_informasi = $request->get('kategori');
            $tambah->keterangan = $request->get('keterangan');
            $tambah->update();
            alert()->success('Sukses','Berhasil mengganti data.');
            return redirect()->route('kategori.index');
        } catch (Exception $e) {
            DB::rollBack();
            alert()->success('Error','Terjadi kesalahan.');
            return redirect()->route('kategori.index');
        };
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Kategori::find($id)->delete();
        alert()->success('Sukses','Berhasil dihapus.');
        return redirect()->route('kategori.index');
    }
}
