<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Perlombaan;
use App\Models\User;
use App\Models\Wasit;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $getPerlombaan = Perlombaan::count();
        $getPengguna = User::where('role', '1')->count();
        $getBerita = Berita::count();
        $getVerifikasi = User::where('role', '1')->where('status_account', 'pending')->count();
        $getWasit = Wasit::count();
        return view('pages.admin.dashboard', compact('getPerlombaan', 'getPengguna', 'getBerita', 'getVerifikasi', 'getWasit'));
    }

    public function getVerifikasi()
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
                            <a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="tolakVerifikasi(' . $item->id . ')"><i class="fas fa-trash"></i></a>
                        </div>
                    ';
                })
                ->rawColumns(['alamat', 'avatar', 'action'])
                ->make(true);
        }
        return view('pages.admin.pengguna.verifikasi-peserta');
    }

    public function verifikasi(Request $request)
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

    public function detailVerifikasi($id)
    {
        $data = User::findOrFail($id);
        $users = User::where('id', $id)->first();
        return view('pages.admin.pengguna.detail-verifikasi', compact('data', 'users'));
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
