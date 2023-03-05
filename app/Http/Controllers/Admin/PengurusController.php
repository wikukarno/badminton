<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengurus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class PengurusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Pengurus::query();

            return datatables()->of($query)
                ->addIndexColumn()
                ->editColumn('photo', function ($item) {
                    if ($item->photo != null) {
                        return '<img src="' . Storage::url($item->photo) . '" class="img-fluid rounded-circle" width="40px" height="40px">';
                    } else {
                        return '<img src="' . asset('assets/images/user.png') . '" class="img-fluid rounded-circle" width="40px" height="40px">';
                    }
                })
                ->editColumn('phone', function ($item) {
                    return $item->phone ?? '-';
                })
                ->editColumn('action', function ($item) {
                    return '
                        <a href="' . route('pengurus.edit', $item->id) . '" class="btn btn-sm btn-primary">
                            <i class="fa fa-pencil-alt"></i>
                        </a>
                        <button class="btn btn-sm btn-danger btn-delete" onclick="hapusPengurus('. $item->id .')">
                            <i class="fa fa-trash"></i>
                        </button>
                    ';
                })
                ->rawColumns(['alamat', 'photo', 'phone', 'action'])
                ->make(true);
        }
        return view('pages.admin.pengurus.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.pengurus.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Pengurus::create($data);
        if($data){
            Alert::success('Berhasil', 'Data berhasil ditambahkan');
            return redirect()->route('pengurus.index');
        }else{
            Alert::error('Gagal', 'Data gagal ditambahkan');
            return redirect()->route('pengurus.index');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Pengurus::findOrFail($id);
        return view('pages.admin.pengurus.edit', compact('data'));
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
        $data = $request->all();
        $item = Pengurus::findOrFail($id);
        $item->update($data);
        if($data){
            Alert::success('Berhasil', 'Data berhasil diubah');
            return redirect()->route('pengurus.index');
        }else{
            Alert::error('Gagal', 'Data gagal diubah');
            return redirect()->route('pengurus.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $item = Pengurus::findOrFail($request->id);
        $item->delete();
        if($item){
            Alert::success('Berhasil', 'Data berhasil dihapus');
            return redirect()->route('pengurus.index');
        }else{
            Alert::error('Gagal', 'Data gagal dihapus');
            return redirect()->route('pengurus.index');
        }
    }
}
