<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $param['title'] = "List Galeri";
        $param['data'] = Galeri::latest()->get();

        $title = 'Delete Galeri!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('galeri.index',$param);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $param['title'] = 'Tambah Galeri';
        return view('galeri.create',$param);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = Validator::make($request->all(),[
            'keterangan' => 'required',
            'file_input' => 'required',
        ],[
            'required' => ':attribute data harus terisi',
        ]);
        if ($validateData->fails()) {
            $html = "<ol class='max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400'>";
            foreach($validateData->errors()->getMessages() as $error) {
                $html .= "<li>$error[0]</li>";
            }
            $html .= "</ol>";

            alert()->html('Terjadi kesalahan eror!', $html, 'error')->autoClose(5000);
            return redirect()->route('galeri.index');
        }
        DB::beginTransaction();
        try {
            DB::commit();
            $tambah = new Galeri;
            if ($request->hasFile('file_input')) {
                $file = $request->file('file_input');
                $filename = Carbon::now()->translatedFormat('his').'.'.$file->extension();
                $file->storeAs('public/galeri/'.$filename);
                $tambah->galeri = $filename;
            }
            $tambah->keterangan = $request->get('keterangan');
            $tambah->user_id = Auth::user()->id;
            $tambah->save();
            alert()->success('Sukses','Berhasil menambahkan data.');
            return redirect()->route('galeri.index');
        } catch (Exception $th) {
            DB::rollBack();
            alert()->error('Error','Terjadi kesalahan.');
            return redirect()->route('galeri.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $param['title'] = 'Edit Galeri';
        $param['data'] = Galeri::findOrFail($id);
        return view('galeri.edit',$param);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData = Validator::make($request->all(),[
            'keterangan' => 'required',
        ],[
            'required' => ':attribute data harus terisi',
        ]);
        if ($validateData->fails()) {
            $html = "<ol class='max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400'>";
            foreach($validateData->errors()->getMessages() as $error) {
                $html .= "<li>$error[0]</li>";
            }
            $html .= "</ol>";

            alert()->html('Terjadi kesalahan eror!', $html, 'error')->autoClose(5000);
            return redirect()->route('galeri.index');
        }
        DB::beginTransaction();
        try {
            DB::commit();
            $edit = Galeri::find($id);
            if ($request->hasFile('file_input')) {
                $path = 'public/galeri/' . $edit->galeri;
                Storage::delete($path);

                $file = $request->file('file_input');
                $filename = Carbon::now()->translatedFormat('his').'.'.$file->extension();
                $file->storeAs('public/galeri/'.$filename);
                $edit->galeri = $filename;
            }
            $edit->keterangan = $request->get('keterangan');
            $edit->save();
            alert()->success('Sukses','Berhasil mengganti data.');
            return redirect()->route('galeri.index');
        } catch (Exception $th) {
            DB::rollBack();
            alert()->error('Error','Terjadi kesalahan.');
            return redirect()->route('galeri.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            DB::commit();
            $delete = Galeri::find($id);
            if ($delete->gambar) {
                $path = 'public/galeri/' . $delete->galeri;
                Storage::delete($path);
            }
            $delete->delete();
            alert()->success('Sukses','Berhasil dihapus.');
            return redirect()->route('galeri.index');
        } catch (Exception $th) {
            DB::rollBack();
            alert()->success('Error','Terjadi kesalahan.');
            return redirect()->route('galeri.index');
        }
    }
}
