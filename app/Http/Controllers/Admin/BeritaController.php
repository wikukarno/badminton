<?php

namespace App\Http\Controllers\Admin;

use App\Models\Berita;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Berita::query();
            return datatables()->of($query)
                ->addIndexColumn()
                ->editColumn('created_at', function($item){
                    return $item->created_at->isoFormat('D MMMM Y');
                })
                ->editColumn('updated_at', function($item){
                    return $item->updated_at->isoFormat('D MMMM Y');
                })
                ->editColumn('action', function ($item) {
                    return '
                            <a href="'. route('berita.show', $item->id) .'" class="btn btn-info btn-sm btn-pill">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="' . route('berita.edit', $item->id) . '" class="btn btn-secondary btn-sm btn-pill">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-pill" onclick="deleteBlog(' . $item->id . ')">
                                <i class="fa fa-trash"></i>
                            </a>
                    ';
                })
                ->rawColumns(['action'])->make(true);
        }

        return view('pages.admin.berita.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.berita.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // if ($request->id_artikel != null || $request->id_artikel != '') {
        //     if ($request->hasFile('gambar')) {
        //         $fileLama = Berita::where('id', $request->id_artikel)->first();
        //         // $newFile = $request->file('gambar')->storePubliclyAs('assets/blog', $request->file('gambar')->getClientOriginalName(), 'public');
        //         $newFile = $request->file('gambar')->storeAs('assets/blog', '' . date('Y-m-d') . '-' . $request->file('gambar')->getClientOriginalName(), 'public');
        //         // delete old file
        //         Storage::disk('public')->delete($fileLama->gambar);
        //     } else {
        //         $fileLama = Berita::where('id', $request->id_artikel)->first();
        //         $oldFile = $fileLama->gambar;
        //     }
        // } else {
        //     $newFile = $request->file('gambar')->storeAs('assets/blog', '' . date('Y-m-d') . '_' . $request->file('gambar')->getClientOriginalName(), 'public');
        // }

        $data = $request->all();
        $data['slug'] = Str::slug($request->judul);
        $data['gambar'] = $request->file('gambar')->store('assets/blog', 'public');

        $item = Berita::create($data);

        if($item){
            Alert::success('Berhasil', 'Data berhasil disimpan');
            return redirect()->route('berita.index');
        }else{
            Alert::error('Gagal', 'Data gagal disimpan');
            return redirect()->route('berita.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Berita::findOrFail($id);
        return view('pages.admin.berita.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Berita::findOrFail($id);
        return view('pages.admin.berita.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Berita::findOrFail($id);
        $data = $request->all();
        $data['slug'] = Str::slug($request->judul);
        if($request->file('gambar')){
            $data['gambar'] = $request->file('gambar')->store('assets/blog', 'public');
        }else{
            $data['gambar'] = $item->gambar;
        }

        $item->update($data);

        if($item){
            Alert::success('Berhasil', 'Data berhasil diubah');
            return redirect()->route('berita.index');
        }else{
            Alert::error('Gagal', 'Data gagal diubah');
            return redirect()->route('berita.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Berita::findOrFail($id);
        $item->delete();

        if($item){
            $result = (['status' => true, 'message' => 'Data berhasil dihapus']);
        }else{
            $result = (['status' => false, 'message' => 'Data gagal dihapus']);
        }

        return Response()->json($result);
    }
}
