<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use App\Models\Kategori;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $param['title'] = "List Berita";
        $param['data'] = Informasi::with('kategori')->where('status_informasi','berita')->latest()->get();

        $title = 'Delete Berita!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('berita.index',$param);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $param['title'] = 'Tambah Berita';
        $param['kategori'] = Kategori::where('status_informasi','berita')->latest()->get();
        return view('berita.create',$param);
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
            'sub_content' => 'required'
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
            return redirect()->route('petugas.create');
        }
        DB::beginTransaction();
        try {
            DB::commit();
            $tambah = new Informasi;
            if ($request->hasFile('file_input')) {
                $file = $request->file('file_input');
                $filename = str_replace(' ','-',$request->get('title')).'.'.$file->extension();
                $file->storeAs('public/cover/'.$filename);
                $tambah->cover = $filename;
            }
            $tambah->title = $request->get('title');
            $tambah->kategori_id = $request->get('kategori');
            $tambah->status_informasi = 'berita';
            $tambah->status = 'pending';
            $tambah->user_id = auth()->user()->id;
            $tambah->content = $request->get('content');
            $tambah->sub_content = $request->get('sub_content');
            $tambah->slug = Str::slug($request->get('title'));
            $tambah->save();
            alert()->success('Sukses','Berhasil menambahkan data.');
            return redirect()->route('berita.index');
        } catch (Exception $th) {
            DB::rollBack();
            alert()->success('Error','Terjadi kesalahan.');
            return redirect()->route('berita.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $param['title'] = 'Show Data';
        $param['data'] = Informasi::with('kategori','user')->find($id);
        return view('berita.show',$param);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $param['title'] = 'Edit Informasi';
        $param['kategori'] = Kategori::where('status_informasi','berita')->latest()->get();
        $param['data'] = Informasi::findOrFail($id);
        return view('berita.edit',$param);
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
            'sub_content' => 'required'
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
            return redirect()->route('berita.index');
        }
        DB::beginTransaction();
        try {
            DB::commit();
            $edit = Informasi::find($id);
            if ($request->hasFile('file_input')) {
                $path = 'public/cover/' . $edit->cover;
                Storage::delete($path);

                $file = $request->file('file_input');
                $filename = str_replace(' ','-',$request->get('title')).'.'.$file->extension();
                $file->storeAs('public/cover/'.$filename);
                $edit->cover = $filename;
            }
            $edit->title = $request->get('title');
            $edit->kategori_id = $request->get('kategori');
            $edit->status_informasi = 'berita';
            $edit->status = 'pending';
            $edit->user_id = auth()->user()->id;
            $edit->content = $request->get('content');
            $edit->sub_content = $request->get('sub_content');
            $edit->slug = Str::slug($request->get('title'));
            $edit->update();
            alert()->success('Sukses','Berhasil mengganti data.');
            return redirect()->route('berita.index');
        } catch (Exception $th) {
            DB::rollBack();
            alert()->success('Error','Terjadi kesalahan.');
            return redirect()->route('berita.index');
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
            $delete = Informasi::find($id);
            if ($delete->cover) {
                $path = 'public/cover/' . $delete->cover;
                Storage::delete($path);
            }
            $delete->delete();
            alert()->success('Sukses','Berhasil dihapus.');
            return redirect()->route('berita.index');
        } catch (Exception $th) {
            DB::rollBack();
            alert()->success('Error','Terjadi kesalahan.');
            return redirect()->route('berita.index');
        }
    }

    public function updateDetail($id) {
        $param['title'] = 'Update Data';
        $param['data'] = Informasi::with('kategori','user')->find($id);
        return view('berita.update',$param);
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
            return redirect()->route('berita.index');
        }
        DB::beginTransaction();
        try {
            DB::commit();
            $update = Informasi::find($request->get('id'));
            $update->status = $request->get('kategori');
            $update->update();
            alert()->success('Sukses','Berhasil mengganti status data.');
            return redirect()->route('berita.index');
        } catch (Exception $th) {
            DB::rollBack();
            alert()->success('Error','Terjadi kesalahan.');
            return redirect()->route('berita.index');
        }
    }
}
