<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pertandingan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PertandinganController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Pertandingan::with(['perlombaan', 'peserta_1', 'peserta_2', 'user'])->orderBy('id', 'DESC')->get();

            return datatables()->of($query)
                ->addIndexColumn()
                ->editColumn('peserta_1', function ($item) {
                    return $item->peserta_1->user->name;
                })
                ->editColumn('peserta_2', function ($item) {
                    return $item->peserta_2->user->name;
                })
                ->editColumn('tanggal_jadwal', function ($item) {
                    return Carbon::parse($item->tanggal_jadwal)->isoFormat('D MMMM Y');
                })
                ->editColumn('status', function ($item) {
                    if ($item->status == 'menunggu') {
                        return '<span class="badge badge-warning">Menunggu Skor</span>';
                    } elseif ($item->status == 'berlangsung') {
                        return '<span class="badge badge-primary">Sedang Berlangsung</span>';
                    } elseif ($item->status == 'selesai') {
                        return '<span class="badge badge-success">Selesai</span>';
                    }
                })
                ->editColumn('skor_peserta_1', function ($item) {
                    if ($item->skor_peserta_1 == null) {
                        return '-';
                    } else {
                        return $item->skor_peserta_1;
                    }
                })
                ->editColumn('skor_peserta_2', function ($item) {
                    if ($item->skor_peserta_2 == null) {
                        return '-';
                    } else {
                        return $item->skor_peserta_2;
                    }
                })
                ->editColumn('action', function ($item) {
                    $tanggal_jadwal = Carbon::parse($item->tanggal_jadwal)->format('Y-m-d');
                    $tanggal_sekarang = Carbon::now()->format('Y-m-d');

                    if ($tanggal_sekarang >= $tanggal_jadwal) {
                        return '
                            <div class="d-flex">
                                <button class="btn btn-warning btn-sm mb-3 mx-1" title="Update Skor Pertandingan" onClick="btnUpdateSkorPertandingan(' . $item->id . ')">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="btn btn-success btn-sm mb-3 mx-1" title="Update Status Pertandingan" onClick="btnUpdateStatusPertandingan(' . $item->id . ')">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                        ';
                    } else {
                        return '
                            <a href="javascript:void(0);" title="Lihat Info" class="btn btn-warning btn-sm mb-3 mx-1" onClick="btnInfoPertandingan()">
                                <i class="fas fa-exclamation-circle"></i>
                            </a>
                        ';
                    }
                })

                ->rawColumns(['peserta_1', 'peserta_2', 'tanggal_jadwal', 'status', 'skor_peserta_1', 'skor_peserta_2', 'action'])
                ->make(true);
        }

        return view('pages.admin.pertandingan.index');
    }

    public function update_skor(Request $request)
    {
        $data = Pertandingan::findOrFail($request->id);

        return Response()->json($data);
    }

    public function store_skor(Request $request)
    {
        try {
            $data = Pertandingan::findOrFail($request->id_pertandingan);

            $data->skor_peserta_1 = $request->skor_peserta_1;
            $data->skor_peserta_2 = $request->skor_peserta_2;
            $data->status = 'berlangsung';

            $data->save();

            $results = (['status' => true, 'message' => 'Skor berhasil diupdate.']);
        } catch (\Throwable $th) {
            $results = (['status' => false, 'message' => 'Terjadi kesalahan. ' . $th->getMessage()]);
        }

        return Response()->json($results);
    }
}
