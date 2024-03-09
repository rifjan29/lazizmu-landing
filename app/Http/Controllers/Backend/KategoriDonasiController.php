<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\KategoriDonasi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KategoriDonasiController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public $param;
    public function index()
    {
        $param['title'] = "List Kategori";
        $param['data'] = KategoriDonasi::latest()->get();

        $title = 'Delete Kategori!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('kategori-donasi.index',$param);
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
        ],[
            'required' => ':attribute data harus terisi',
        ],[
            'name' => 'Kategori',
        ]);
        if ($validateData->fails()) {
            $html = "<ol class='max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400'>";
            foreach($validateData->errors()->getMessages() as $error) {
                $html .= "<li>$error[0]</li>";
            }
            $html .= "</ol>";

            alert()->html('Terjadi kesalahan eror!', $html, 'error')->autoClose(5000);
            return redirect()->route('kategori-donasi.index');
        }
        DB::beginTransaction();
        try {
            DB::commit();
            $tambah = new KategoriDonasi;
            $tambah->title = $request->get('name');
            $tambah->keterangan = $request->get('keterangan');
            $tambah->save();
            alert()->success('Sukses','Berhasil menambahkan data.');
            return redirect()->route('kategori-donasi.index');
        } catch (Exception $e) {
            DB::rollBack();
            alert()->success('Error','Terjadi kesalahan.');
            return redirect()->route('kategori-donasi.index');
        };
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        try {
            $data = KategoriDonasi::find($request->get('id'));
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
            $data = KategoriDonasi::find($request->get('id'));
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
        ],[
            'required' => ':attribute data harus terisi',
        ],[
            'name' => 'Kategori',
        ]);
        if ($validateData->fails()) {
            $html = "<ol class='max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400'>";
            foreach($validateData->errors()->getMessages() as $error) {
                $html .= "<li>$error[0]</li>";
            }
            $html .= "</ol>";

            alert()->html('Terjadi kesalahan eror!', $html, 'error')->autoClose(5000);
            return redirect()->route('kategori-donasi.index');
        }
        DB::beginTransaction();
        try {
            DB::commit();
            $tambah = KategoriDonasi::find($request->get('id'));
            $tambah->title = $request->get('name');
            $tambah->keterangan = $request->get('keterangan');
            $tambah->update();
            alert()->success('Sukses','Berhasil mengganti data.');
            return redirect()->route('kategori-donasi.index');
        } catch (Exception $e) {
            DB::rollBack();
            alert()->success('Error','Terjadi kesalahan.');
            return redirect()->route('kategori-donasi.index');
        };
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        KategoriDonasi::find($id)->delete();
        alert()->success('Sukses','Berhasil dihapus.');
        return redirect()->route('kategori-donasi.index');
    }
}
