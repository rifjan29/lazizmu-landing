<?php

namespace App\Http\Controllers;

use App\Models\Pengurus;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PengurusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $param['title']= 'List Pengurus';
        $param['data'] = Pengurus::latest()->get();
        return view('pengurus.index', $param);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $param['title'] = 'Create Pengurus';
        $title = 'Delete Pengurus!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('pengurus.create',$param);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = Validator::make($request->all(),[
            'nama' => 'required',
            'jabatan' => 'required',
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
            return redirect()->route('pengurus.index');
        }
        DB::beginTransaction();
        try {
            DB::commit();
            $tambah = new Pengurus;
            if ($request->hasFile('file_input')) {
                $file = $request->file('file_input');
                $filename = Carbon::now()->translatedFormat('his').'.'.$file->extension();
                $file->storeAs('public/pengurus/'.$filename);
                $tambah->gambar = $filename;
            }
            $tambah->nama = $request->get('nama');
            $tambah->jabatan = $request->get('jabatan');
            $tambah->save();
            alert()->success('Sukses','Berhasil menambahkan data.');
            return redirect()->route('pengurus.index');
        } catch (Exception $th) {
            DB::rollBack();
            alert()->error('Error','Terjadi kesalahan.');
            return redirect()->route('pengurus.index');
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
        $param['title'] = 'Edit Pengurus';
        $param['data'] = Pengurus::find($id);
        return view('pengurus.edit',$param);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData = Validator::make($request->all(),[
            'nama' => 'required',
            'jabatan' => 'required',
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
            return redirect()->route('pengurus.index');
        }
        DB::beginTransaction();
        try {
            DB::commit();
            $edit = Pengurus::find($id);
            if ($request->hasFile('file_input')) {
                $path = 'public/pengurus/' . $edit->gambar;
                Storage::delete($path);

                $file = $request->file('file_input');
                $filename = Carbon::now()->translatedFormat('his').'.'.$file->extension();
                $file->storeAs('public/pengurus/'.$filename);
                $edit->gambar = $filename;
            }
            $edit->nama = $request->get('nama');
            $edit->jabatan = $request->get('jabatan');
            $edit->update();
            alert()->success('Sukses','Berhasil mengganti data.');
            return redirect()->route('pengurus.index');
        } catch (Exception $th) {
            DB::rollBack();
            alert()->error('Error','Terjadi kesalahan.');
            return redirect()->route('pengurus.index');
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
            $delete = Pengurus::find($id);
            if ($delete->gambar) {
                $path = 'public/pengurus/' . $delete->gambar;
                Storage::delete($path);
            }
            $delete->delete();
            alert()->success('Sukses','Berhasil dihapus.');
            return redirect()->route('pengurus.index');
        } catch (Exception $th) {
            DB::rollBack();
            alert()->success('Error','Terjadi kesalahan.');
            return redirect()->route('pengurus.index');
        }
    }
}
