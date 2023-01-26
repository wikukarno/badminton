<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perlombaan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PerlombaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Perlombaan::query();

            return datatables()->of($query)
                ->addIndexColumn()
                ->editColumn('action', function ($item) {
                    return '
                        <button class="btn btn-warning btn-sm mb-3" onClick="btnUpdatePerlombaan(' . $item->id . ')">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm mb-3" onClick="btnDeletePerlombaan(' . $item->id . ')">
                            <i class="fas fa-trash"></i>
                        </button>
                    ';
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.admin.perlombaan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = Perlombaan::updateOrCreate(
            ['id' => $request->id],
            [
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'tanggal' => $request->tanggal,
                'tempat' => $request->tempat,
                'kuota' => $request->kuota,
                'status' => $request->status,
            ]
        );

        if (!$data->wasRecentlyCreated && $data->wasChanged()) {
            return Response()->json(['status' => true, 'message' => 'Data berhasil diubah!']);
        }
        if (!$data->wasRecentlyCreated && !$data->wasChanged()) {
            return Response()->json(['status' => false, 'message' => 'Data tidak ada yang diubah!']);
        }
        if ($data->wasRecentlyCreated) {
            return Response()->json(['status' => true, 'message' => 'Data berhasil ditambahkan!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if (request()->ajax()) {
            $where = array('perlombaans.id' => $request->id);
            $result = Perlombaan::where($where)->first();
            if ($result) {
                return Response()->json($result);
            } else {
                return Response()->json(['error' => 'Akun tidak ditemukan!']);
            }
        } else {
            $result = (['status' => false, 'message' => 'Maaf, akses ditolak!']);
        }
        return Response()->json($result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = Perlombaan::findOrFail($request->id);
        $data->delete();

        if ($data) {
            return Response()->json(['status' => true, 'message' => 'Data berhasil dihapus!']);
        } else {
            return Response()->json(['status' => false, 'message' => 'Data gagal dihapus!']);
        }
    }
}
