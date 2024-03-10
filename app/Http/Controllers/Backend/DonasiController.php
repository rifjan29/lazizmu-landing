<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\KategoriDonasi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class DonasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $param['title'] = "List Donasi";
        $param['data'] = Donasi::with('kategori')->latest()->get();

        $title = 'Delete Donasi!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('donasi.index',$param);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $param['title'] = 'Tambah Donasi';
        $param['kategori'] = KategoriDonasi::latest()->get();
        return view('donasi.create',$param);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = Validator::make($request->all(),[
            'title' => 'required',
            'kategori' => 'required|not_in:0',
            'content' => 'required',
            'sub_content' => 'required',
        ],[
            'required' => ':attribute data harus terisi',
        ],[
            'title' => 'Title',
            'kategori' => 'Kategori',
        ]);
        if ($validateData->fails()) {
            $html = "<ol class='max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400'>";
            foreach($validateData->errors()->getMessages() as $error) {
                $html .= "<li>$error[0]</li>";
            }
            $html .= "</ol>";

            alert()->html('Terjadi kesalahan eror!', $html, 'error')->autoClose(5000);
            return redirect()->route('donasi.index');
        }
        DB::beginTransaction();
        try {
            DB::commit();
            $tambah = new Donasi;
            if ($request->hasFile('file_input')) {
                $file = $request->file('file_input');
                $filename = str_replace(' ','-',$request->get('title')).'.'.$file->extension();
                $file->storeAs('public/donasi/'.$filename);
                $tambah->cover = $filename;
            }
            $tambah->title = $request->get('title');
            $tambah->kategori_id = $request->get('kategori');
            $tambah->status = 'pending';
            $tambah->user_id = auth()->user()->id;
            $tambah->content = $request->get('content');
            $tambah->sub_content = $request->get('sub_content');
            $tambah->total_dana = $request->has('total_donasi') ? $this->formatNumber($request->get('total_donasi')) : 0;
            $tambah->total_donatur = $request->has('total_donatur') ? $request->get('total_donatur') : 0;
            $tambah->slug = Str::slug($request->get('title'));
            $tambah->save();
            alert()->success('Sukses','Berhasil menambahkan data.');
            return redirect()->route('donasi.index');
        } catch (Exception $th) {
            return $th;
            DB::rollBack();
            alert()->error('Error','Terjadi kesalahan.');
            return redirect()->route('donasi.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $param['title'] = 'Show Data';
        $param['data'] = Donasi::with('kategori','user')->find($id);
        return view('donasi.show',$param);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $param['title'] = 'Show Data';
        $param['kategori'] = KategoriDonasi::latest()->get();
        $param['data'] = Donasi::with('kategori','user')->find($id);
        return view('donasi.edit',$param);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData = Validator::make($request->all(),[
            'title' => 'required',
            'kategori' => 'required|not_in:0',
            'content' => 'required',
            'sub_content' => 'required',
        ],[
            'required' => ':attribute data harus terisi',
        ],[
            'title' => 'Title',
            'kategori' => 'Kategori',
        ]);
        if ($validateData->fails()) {
            $html = "<ol class='max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400'>";
            foreach($validateData->errors()->getMessages() as $error) {
                $html .= "<li>$error[0]</li>";
            }
            $html .= "</ol>";

            alert()->html('Terjadi kesalahan eror!', $html, 'error')->autoClose(5000);
            return redirect()->route('donasi.index');
        }
        DB::beginTransaction();
        try {
            DB::commit();
            $update = Donasi::find($id);
            if ($request->hasFile('file_input')) {
                $file = $request->file('file_input');
                $filename = str_replace(' ','-',$request->get('title')).'.'.$file->extension();
                $file->storeAs('public/donasi/'.$filename);
                $update->cover = $filename;
            }
            $update->title = $request->get('title');
            $update->kategori_id = $request->get('kategori');
            $update->user_id = auth()->user()->id;
            $update->content = $request->get('content');
            $update->sub_content = $request->get('sub_content');
            $update->slug = Str::slug($request->get('title'));
            $update->update();
            alert()->success('Sukses','Berhasil mengganti data.');
            return redirect()->route('donasi.index');
        } catch (Exception $th) {
            DB::rollBack();
            alert()->error('Error','Terjadi kesalahan.');
            return redirect()->route('donasi.index');
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
            $delete = Donasi::find($id);
            if ($delete->cover) {
                $path = 'public/donasi/' . $delete->cover;
                Storage::delete($path);
            }
            $delete->delete();
            alert()->success('Sukses','Berhasil dihapus.');
            return redirect()->route('donasi.index');
        } catch (Exception $th) {
            DB::rollBack();
            alert()->success('Error','Terjadi kesalahan.');
            return redirect()->route('donasi.index');
        }
    }

    public function updateDonasiDetail(Request $request, $id) {
        $data = Donasi::with('kategori','user')->find($request->get('id'));
        return $data;
    }

    public function updateDonasi(Request $request) {
        $validateData = Validator::make($request->all(),[
            'total_donasi' => 'required',
            'total_donatur' => 'required|not_in:0',
            'status' => 'required',
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
            return redirect()->route('donasi.index');
        }
        DB::beginTransaction();
        try {
            DB::commit();
            $update = Donasi::find($request->get('id'));
            $update->total_dana = $request->has('total_donasi') ? $this->formatNumber($request->get('total_donasi')) : 0;
            $update->total_donatur = $request->has('total_donatur') ? $request->get('total_donatur') : 0;
            $update->status_donasi = $request->get('status');
            $update->update();
            alert()->success('Sukses','Berhasil mengganti status dana.');
            return redirect()->route('donasi.index');
        } catch (Exception $th) {
            DB::rollBack();
            alert()->error('Error','Terjadi kesalahan.');
            return redirect()->route('donasi.index');
        }
    }

    public function formatNumber($param)
    {
        $cleaned = str_replace(['.', ','], '', $param);
        return (int)$cleaned;
    }

    public function updateDetail($id) {
        $param['title'] = 'Update Data';
        $param['data'] = Donasi::with('kategori','user')->find($id);
        return view('donasi.update',$param);
    }

    public function updatePost(Request $request) {
        $validateData = Validator::make($request->all(),[
            'kategori' => 'required|not_in:0',
        ],[
            'required' => ':attribute data harus terisi',
        ],[
            'kategori' => 'Status',
        ]);
        if ($validateData->fails()) {
            $html = "<ol class='max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400'>";
            foreach($validateData->errors()->getMessages() as $error) {
                $html .= "<li>$error[0]</li>";
            }
            $html .= "</ol>";

            alert()->html('Terjadi kesalahan eror!', $html, 'error')->autoClose(5000);
            return redirect()->route('donasi.index');
        }
        DB::beginTransaction();
        try {
            DB::commit();
            $update = Donasi::find($request->get('id'));
            $update->status = $request->get('kategori');
            $update->update();
            alert()->success('Sukses','Berhasil mengganti status data.');
            return redirect()->route('donasi.index');
        } catch (Exception $th) {
            DB::rollBack();
            alert()->success('Error','Terjadi kesalahan.');
            return redirect()->route('donasi.index');
        }
    }
}
