<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TentangKami;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TentangKamiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $param['title'] = "List Tentang Kami";
        $param['data'] = TentangKami::latest()->get();
        $title = 'Delete Tentang Kami!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('tentang-kami.index',$param);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $param['title'] = "Tambah Tentang Kami";
        return view('tentang-kami.create',$param);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = Validator::make($request->all(),[
            'latar_belakang' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'prinsip' => 'required',
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
            return redirect()->route('tentang-kami.index');
        }
        DB::beginTransaction();
        try {
            DB::commit();
            $tambah = new TentangKami;
            if ($request->hasFile('file_input')) {
                $file = $request->file('file_input');
                $filename = Carbon::now()->translatedFormat('his').'.'.$file->extension();
                $file->storeAs('public/tentang/'.$filename);
                $tambah->gambar = $filename;
            }
            $tambah->latar_belakang = $request->get('latar_belakang');
            $tambah->visi = $request->get('visi');
            $tambah->misi = $request->get('misi');
            $tambah->prinsip = $request->get('prinsip');
            $tambah->user_id = Auth::user()->id;
            $tambah->save();
            alert()->success('Sukses','Berhasil menambahkan data.');
            return redirect()->route('tentang-kami.index');
        } catch (Exception $th) {
            DB::rollBack();
            alert()->error('Error','Terjadi kesalahan.');
            return redirect()->route('tentang-kami.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $param['title'] = "Detail Tentang Kami";
        $param['data'] = TentangKami::find($id);
        return view('tentang-kami.show',$param);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $param['title'] = "Edit Tentang Kami";
        $param['data'] = TentangKami::find($id);
        return view('tentang-kami.edit',$param);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData = Validator::make($request->all(),[
            'latar_belakang' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'prinsip' => 'required',
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
            return redirect()->route('tentang-kami.index');
        }
        DB::beginTransaction();
        try {
            DB::commit();
            $update = TentangKami::findOrFail($id);
            if ($request->hasFile('file_input')) {
                $file = $request->file('file_input');
                $path = 'public/tentang/' . $update->gambar;
                Storage::delete($path);

                $filename = Carbon::now()->translatedFormat('his').'.'.$file->extension();
                $file->storeAs('public/tentang/'.$filename);
                $update->gambar = $filename;
            }
            $update->latar_belakang = $request->get('latar_belakang');
            $update->visi = $request->get('visi');
            $update->misi = $request->get('misi');
            $update->prinsip = $request->get('prinsip');
            $update->user_id = Auth::user()->id;
            $update->update();
            alert()->success('Sukses','Berhasil mengganti data.');
            return redirect()->route('tentang-kami.index');
        } catch (Exception $th) {
            DB::rollBack();
            alert()->error('Error','Terjadi kesalahan.');
            return redirect()->route('tentang-kami.index');
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
            $delete = TentangKami::find($id);
            if ($delete->gambar) {
                $path = 'public/tentang/' . $delete->gambar;
                Storage::delete($path);
            }
            $delete->delete();
            alert()->success('Sukses','Berhasil dihapus.');
            return redirect()->route('tentang-kami.index');
        } catch (Exception $th) {
            DB::rollBack();
            alert()->success('Error','Terjadi kesalahan.');
            return redirect()->route('tentang-kami.index');
        }
    }
}
