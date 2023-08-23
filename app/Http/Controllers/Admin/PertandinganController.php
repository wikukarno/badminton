<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pertandingan;
use App\Models\Peserta;
use App\Models\User;
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
                // ->editColumn('skor_pertandingan', function ($item) {
                //     return '
                //         <a href="javascript:void(0);" title="Lihat Skor Pertandingan" class="btn btn-warning btn-sm mb-3 mx-1" onClick="btnSkorPertandingan()">
                //             <i class="fas fa-star"></i>
                //         </a>
                //     ';
                // })
                ->editColumn('durasi', function ($item) {
                    if ($item->durasi == null) {
                        return '-';
                    } else {
                        return $item->durasi . ' Menit';
                    }
                })
                ->editColumn('action', function ($item) {
                    $tanggal_jadwal = Carbon::parse($item->tanggal_jadwal)->format('Y-m-d');
                    $tanggal_sekarang = Carbon::now()->format('Y-m-d');
                    $status = $item->status;

                    if ($tanggal_sekarang >= $tanggal_jadwal) {
                        if ($status == 'selesai') {
                            return '
                                <div class="d-flex">
                                    <button class="btn btn-success btn-sm mb-3 mx-1" title="Lihat Hasil Pertandingan" onClick="btnLihatHasilPertandingan(' . $item->id . ')">
                                        <i class="fas fa-medal"></i>
                                    </button>
                                </div>
                            ';
                        } else {
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
                        }
                    } else {
                        return '
                            <a href="javascript:void(0);" title="Lihat Info" class="btn btn-warning btn-sm mb-3 mx-1" onClick="btnInfoPertandingan()">
                                <i class="fas fa-exclamation-circle"></i>
                            </a>
                        ';
                    }
                })

                ->rawColumns(['peserta_1', 'peserta_2', 'tanggal_jadwal', 'status', 'skor_pertandingan', 'durasi', 'action'])
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

            $data->skor_peserta_1_set_1 = $request->skor_peserta_1_set_1;
            $data->skor_peserta_2_set_1 = $request->skor_peserta_2_set_1;
            $data->skor_peserta_1_set_2 = $request->skor_peserta_1_set_2;
            $data->skor_peserta_2_set_2 = $request->skor_peserta_2_set_2;
            $data->skor_peserta_1_set_3 = $request->skor_peserta_1_set_3;
            $data->skor_peserta_2_set_3 = $request->skor_peserta_2_set_3;
            $data->durasi = $request->durasi;
            $data->status = 'berlangsung';

            $data->save();

            $results = (['status' => true, 'message' => 'Skor berhasil diupdate.']);
        } catch (\Throwable $th) {
            $results = (['status' => false, 'message' => 'Terjadi kesalahan. ' . $th->getMessage()]);
        }

        return Response()->json($results);
    }

    public function update_status(Request $request)
    {
        try {
            $data = Pertandingan::findOrFail($request->id);
            $skor_peserta_1_set_1 = $data->skor_peserta_1_set_1;
            $skor_peserta_2_set_1 = $data->skor_peserta_2_set_1;
            $skor_peserta_1_set_2 = $data->skor_peserta_1_set_2;
            $skor_peserta_2_set_2 = $data->skor_peserta_2_set_2;
            $skor_peserta_1_set_3 = $data->skor_peserta_1_set_3;
            $skor_peserta_2_set_3 = $data->skor_peserta_2_set_3;

            $pemenang_id = null;

            if ($skor_peserta_1_set_1 == null || $skor_peserta_2_set_1 == null || $skor_peserta_1_set_2 == null || $skor_peserta_2_set_2 == null) {
                $results = (['status' => false, 'message' => 'Skor pertandingan Set 1 dan Set 2 belum diisi semua.']);
            } else {
                // Check if Peserta 1 has won the first two sets
                if ($skor_peserta_1_set_1 > $skor_peserta_2_set_1 && $skor_peserta_1_set_2 > $skor_peserta_2_set_2) {
                    $pemenang_id = $data->pesertas_id_1;
                }
                // Check if Peserta 2 has won the first two sets
                elseif ($skor_peserta_2_set_1 > $skor_peserta_1_set_1 && $skor_peserta_2_set_2 > $skor_peserta_1_set_2) {
                    $pemenang_id = $data->pesertas_id_2;
                }
                // Check if both players have won one set each
                elseif (
                    ($skor_peserta_1_set_1 > $skor_peserta_2_set_1 && $skor_peserta_2_set_2 > $skor_peserta_1_set_2) ||
                    ($skor_peserta_2_set_1 > $skor_peserta_1_set_1 && $skor_peserta_1_set_2 > $skor_peserta_2_set_2)
                ) {
                    // Rubber set: Set 3 will be played again
                    if ($skor_peserta_1_set_3 > $skor_peserta_2_set_3) {
                        $pemenang_id = $data->pesertas_id_1;
                    } elseif ($skor_peserta_2_set_3 > $skor_peserta_1_set_3) {
                        $pemenang_id = $data->pesertas_id_2;
                    }
                }

                if ($pemenang_id != null) {
                    $data->pemenang_id = $pemenang_id;
                    $data->status = 'selesai';
                    $data->save();

                    $results = (['status' => true, 'message' => 'Status pertandingan berhasil diubah, dan pemenang telah ditentukan.']);
                } else {
                    $results = (['status' => false, 'message' => 'Skor pertandingan belum memenuhi syarat untuk menentukan pemenang.']);
                }
            }
        } catch (\Throwable $th) {
            $results = (['status' => false, 'message' => 'Terjadi kesalahan. ' . $th->getMessage()]);
        }

        return Response()->json($results);
    }

    public function hasil(Request $request)
    {
        $data = Pertandingan::with(['peserta_1', 'peserta_2'])->findOrFail($request->id);

        $pemenang = $this->_cek_peserta($data->pemenang_id);
        $skor_peserta_1_set_1 = $data->skor_peserta_1_set_1;
        $skor_peserta_2_set_1 = $data->skor_peserta_2_set_1;
        $skor_peserta_1_set_2 = $data->skor_peserta_1_set_2;
        $skor_peserta_2_set_2 = $data->skor_peserta_2_set_2;
        $skor_peserta_1_set_3 = $data->skor_peserta_1_set_3;
        $skor_peserta_2_set_3 = $data->skor_peserta_2_set_3;

        $peserta = '';

        // Check if Peserta 1 has won the first two sets
        if ($skor_peserta_1_set_1 > $skor_peserta_2_set_1 && $skor_peserta_1_set_2 > $skor_peserta_2_set_2) {
            $peserta = 'Peserta 1';
        }
        // Check if Peserta 2 has won the first two sets
        elseif ($skor_peserta_2_set_1 > $skor_peserta_1_set_1 && $skor_peserta_2_set_2 > $skor_peserta_1_set_2) {
            $peserta = 'Peserta 2';
        }
        // Check if both players have won one set each
        elseif (
            ($skor_peserta_1_set_1 > $skor_peserta_2_set_1 && $skor_peserta_2_set_2 > $skor_peserta_1_set_2) ||
            ($skor_peserta_2_set_1 > $skor_peserta_1_set_1 && $skor_peserta_1_set_2 > $skor_peserta_2_set_2)
        ) {
            // Rubber set: Set 3 will be played again
            if ($skor_peserta_1_set_3 > $skor_peserta_2_set_3) {
                $peserta = 'Peserta 1';
            } elseif ($skor_peserta_2_set_3 > $skor_peserta_1_set_3) {
                $peserta = 'Peserta 2';
            }
        }

        $data_results = [
            'pemenang' => $pemenang,
            'peserta' => $peserta,
            'skor_peserta_1_set_1' => $skor_peserta_1_set_1,
            'skor_peserta_2_set_1' => $skor_peserta_2_set_1,
            'skor_peserta_1_set_2' => $skor_peserta_1_set_2,
            'skor_peserta_2_set_2' => $skor_peserta_2_set_2,
            'skor_peserta_1_set_3' => $skor_peserta_1_set_3,
            'skor_peserta_2_set_3' => $skor_peserta_2_set_3,
            'durasi' => $data->durasi . ' Menit',
        ];

        return Response()->json($data_results);
    }

    private function _cek_peserta($id)
    {
        $data = Peserta::with(['user'])->findOrFail($id);
        $peserta = $data->user->name;

        return $peserta;
    }
}
