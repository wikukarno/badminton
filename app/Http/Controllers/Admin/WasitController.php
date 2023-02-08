<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wasit;
use Illuminate\Http\Request;

class WasitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Wasit::query();

            return datatables()->of($query)
                ->addIndexColumn()
                ->editColumn('photo', function ($item) {
                    return '
                        <img src="' . asset('storage/' . $item->photo) . '" alt="" style="width: 50px; height: 50px; object-fit: cover; object-position: center;">
                    ';
                })
                ->editColumn('action', function ($item) {
                    return '
                        <button class="btn btn-warning btn-sm mb-3" onClick="btnUpdateWasit(' . $item->id . ')">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm mb-3" onClick="btnDeleteWasit(' . $item->id . ')">
                            <i class="fas fa-trash"></i>
                        </button>
                    ';
                })

                ->rawColumns(['action', 'photo'])
                ->make(true);
        }
        return view('pages.admin.wasit.index');
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
        $request->validate([
            'photo' => 'mimes:jpg,jpeg,png|max:2048',
        ]);
        $fileLama = Wasit::find($request->id_wasit);
        if ($request->hasFile('photo')) {
            $newFile = $request->file('photo')->storePubliclyAs('assets/wasit', $request->file('photo')->getClientOriginalName(), 'public');
        } else {
            $oldFile = $fileLama->photo;
        }
        $data = Wasit::updateOrCreate(
            ['id' => $request->id_wasit],
            [
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'phone' => $request->phone,
                'email' => $request->email,
                'status' => $request->status,
                'photo' => $newFile ?? $oldFile,
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
            $where = array('wasits.id' => $request->id);
            $result = Wasit::where($where)->first();
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
        $data = Wasit::findOrFail($request->id);
        $data->delete();

        if ($data) {
            return Response()->json(['status' => true, 'message' => 'Data berhasil dihapus!']);
        } else {
            return Response()->json(['status' => false, 'message' => 'Data gagal dihapus!']);
        }
    }
}
