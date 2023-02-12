<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VerifikasiPenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = User::where('role', '1')->where('status_account', 'pending')->get();

            return datatables()->of($query)
                ->addIndexColumn()
                ->editColumn('avatar', function ($item) {
                    if ($item->avatar == null) {
                        return '<img src="' . asset('assets/images/user.png') . '" class="img-fluid" width="50" height="50">';
                    } else {
                        return '
                            <img src="' . asset('storage/' . $item->avatar) . '" alt="avatar" width="50px" height="50px">
                        ';
                    }
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at->isoFormat('D MMMM Y');
                })
                ->editColumn('action', function ($item) {
                    return '
                        <div class="form-group">
                            <a href="' . route('0.detail.verifikasi', $item->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-success" onclick="verifikasiPengguna(' . $item->id . ')"><i class="fas fa-user-check"></i></a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="tolakVerifikasi(' . $item->id . ')"><i class="fas fa-user-alt-slash"></i></a>
                        </div>
                    ';
                })
                ->rawColumns(['alamat', 'avatar', 'action'])
                ->make(true);
        }
        return view('pages.admin.verifikasi.verifikasi-peserta');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::findOrFail($id);
        $users = User::where('id', $id)->first();
        return view('pages.admin.verifikasi.detail-verifikasi', compact('data', 'users'));
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
    public function update(Request $request)
    {
        $data = User::findOrFail($request->id);
        $data->status_account = 'aktif';
        $data->save();

        if ($data) {
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil verifikasi pengguna'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal verifikasi pengguna'
            ]);
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
        //
    }

    public function tolakVerifikasi(Request $request)
    {
        $data = User::findOrFail($request->id_penolakan);
        $data->status_account = 'ditolak';
        $data->alasan_penolakan = $request->alasan_penolakan;
        $data->save();

        if ($data) {
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil ditolak'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal ditolak'
            ]);
        }
    }
}
