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
                ->editColumn('skor_pertandingan', function ($item) {
                    return '
                        <a href="javascript:void(0);" title="Lihat Skor Pertandingan" class="btn btn-warning btn-sm mb-3 mx-1" onClick="btnSkorPertandingan()">
                            <i class="fas fa-star"></i>
                        </a>
                    ';
                })
                ->editColumn('durasi', function ($item) {
                    if ($item->durasi == null) {
                        return '-';
                    } else {
                        return $item->durasi;
                    }
                })
                ->editColumn('action', function ($item) {
                    $tanggal_jadwal = Carbon::parse($item->tanggal_jadwal)->format('Y-m-d');
                    $tanggal_sekarang = Carbon::now()->format('Y-m-d');
                    $status = $item->status;
                    $skor_peserta_1 = $item->skor_peserta_1;
                    $skor_peserta_2 = $item->skor_peserta_2;

                    if ($tanggal_sekarang >= $tanggal_jadwal) {
                        if ($status == 'selesai') {
                            if ($skor_peserta_1 != $skor_peserta_2) {
                                return '
                                    <div class="d-flex">
                                        <button class="btn btn-success btn-sm mb-3 mx-1" title="Lihat Hasil Pertandingan" onClick="btnLihatHasilPertandingan(' . $item->id . ')">
                                            <i class="fas fa-medal"></i>
                                        </button>
                                    </div>
                                ';
                            } else {
                                return '
                                    <a href="javascript:void(0);" title="Lihat Info" class="btn btn-success btn-sm mb-3 mx-1" onClick="btnSeriPertandingan()">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </a>
                                ';
                            }
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

    public function update_status(Request $request)
    {
        try {
            $data = Pertandingan::findOrFail($request->id);
            $skor_peserta_1 = $data->skor_peserta_1;
            $skor_peserta_2 = $data->skor_peserta_2;

            if ($skor_peserta_1 == $skor_peserta_2) {
                $data->status = 'selesai';
                $data->save();

                // Buat tanggal jadwal baru secara random
                $tanggal_jadwal = Carbon::now()->addDays(rand(1, 7))->format('Y-m-d H:i:s');

                // Adu ulang pertandingannya jika seri
                Pertandingan::create([
                    'perlombaans_id' => $data->perlombaans_id,
                    'pesertas_id_1' => $data->pesertas_id_1,
                    'pesertas_id_2' => $data->pesertas_id_2,
                    'tanggal_jadwal' => $tanggal_jadwal,
                    'status' => 'menunggu',
                ]);

                $results = (['status' => true, 'message' => 'Status pertandingan berhasil diubah, dan pertandingan akan diadu ulang.']);
            } else {
                $data->status = 'selesai';
                $pemenang_id = null;

                // Jika skor peserta 1 lebih besar dari peserta 2, maka peserta 1 menang
                // Selain itu, peserta 2 menang
                if ($skor_peserta_1 > $skor_peserta_2) {
                    $pemenang_id = $data->pesertas_id_1;
                } else {
                    $pemenang_id = $data->pesertas_id_2;
                }

                $data->pemenang_id = $pemenang_id;
                $data->save();

                $results = (['status' => true, 'message' => 'Status pertandingan berhasil diubah, dan pemenang telah ditentukan.']);
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
        $skor_peserta_1 = $data->skor_peserta_1;
        $skor_peserta_2 = $data->skor_peserta_2;
        $peserta = '';

        if ($skor_peserta_1 > $skor_peserta_2) {
            $peserta = 'Peserta 1';
        } else {
            $peserta = 'Peserta 2';
        }

        $data_results = [
            'pemenang' => $pemenang,
            'peserta' => $peserta,
            'skor_peserta_1' => $skor_peserta_1,
            'skor_peserta_2' => $skor_peserta_2,
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
