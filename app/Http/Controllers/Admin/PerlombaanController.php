<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perlombaan;
use App\Models\Pertandingan;
use App\Models\Peserta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
                ->editColumn('tanggal_pendaftaran_dibuka', function ($item) {
                    return Carbon::parse($item->tanggal_pendaftaran_dibuka)->isoFormat('D MMMM Y');
                })
                ->editColumn('tanggal_pendaftaran_ditutup', function ($item) {
                    return Carbon::parse($item->tanggal_pendaftaran_ditutup)->isoFormat('D MMMM Y');
                })
                ->editColumn('action', function ($item) {
                    $tanggal_pendaftaran_ditutup = Carbon::parse($item->tanggal_pendaftaran_ditutup)->format('Y-m-d');
                    $tanggal_sekarang = Carbon::now()->format('Y-m-d');

                    if ($tanggal_sekarang > $tanggal_pendaftaran_ditutup) {
                        return '
                            <div class="d-flex">
                                <a href="' . route('0.show.perlombaan', $item->id) . '" title="Tampil Detail Perlombaan" target="_blank" class="btn btn-info btn-sm mb-3 mx-1">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="javascript:void(0);" title="Buat Jadwal Pertandingan Acak" class="btn btn-success btn-sm mb-3 mx-1" onClick="btnCreateRandomPertandingan(' . $item->id . ')">
                                    <i class="fas fa-random"></i>
                                </a>
                                <button class="btn btn-warning btn-sm mb-3 mx-1" title="Update Perlombaan" onClick="btnUpdatePerlombaan(' . $item->id . ')">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm mb-3 mx-1" title="Hapus Perlombaan" onClick="btnDeletePerlombaan(' . $item->id . ')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div> 
                        ';
                    } else {
                        return '
                            <div class="d-flex">
                                <a href="' . route('0.show.perlombaan', $item->id) . '" target="_blank" class="btn btn-info btn-sm mb-3 mx-1">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-warning btn-sm mb-3 mx-1" onClick="btnUpdatePerlombaan(' . $item->id . ')">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm mb-3 mx-1" onClick="btnDeletePerlombaan(' . $item->id . ')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div> 
                        ';
                    }
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
        // Untuk validasi tanggal pendaftaran dibuka dan ditutup
        $tanggal_pendaftaran_dibuka = Carbon::parse($request->tanggal_pendaftaran_dibuka)->format('Y-m-d');
        $tanggal_pendaftaran_ditutup = Carbon::parse($request->tanggal_pendaftaran_ditutup)->format('Y-m-d');

        if ($tanggal_pendaftaran_ditutup <= $tanggal_pendaftaran_dibuka) {
            return Response()->json(['status' => false, 'message' => 'Tanggal pendaftaran ditutup tidak boleh kurang atau sama dengan tanggal pendaftaran dibuka!']);
        } else {
            $data = Perlombaan::updateOrCreate(
                ['id' => $request->id],
                [
                    'nama_perlombaan' => $request->nama_perlombaan,
                    'deskripsi_perlombaan' => $request->deskripsi_perlombaan,
                    'tanggal_pendaftaran_dibuka' => $request->tanggal_pendaftaran_dibuka,
                    'tanggal_pendaftaran_ditutup' => $request->tanggal_pendaftaran_ditutup,
                    'tempat_pelaksanaan' => $request->tempat_pelaksanaan,
                    'kategori_perlombaan' => $request->kategori_perlombaan,
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
    }

    // Buat jadwal pertandingan acak
    public function create_random_pertandingan(Request $request)
    {
        $id_perlombaan = $request->id;
        $data_perlombaan = Perlombaan::findOrFail($id_perlombaan);

        // Cek jika kategori perlombaan adalah single
        if ($data_perlombaan->kategori_perlombaan == 'Single') {
            $data_peserta = Peserta::where('perlombaans_id', $id_perlombaan)->get();
            $jumlah_peserta = count($data_peserta);

            // Jika jumlah peserta kurang dari 2
            if ($jumlah_peserta < 2) {
                return Response()->json(['status' => false, 'message' => 'Jumlah peserta kurang dari 2!']);
            } else {
                $jumlah_pertandingan = 0;

                // Jika jumlah peserta genap
                if ($jumlah_peserta % 2 == 0) {
                    $jumlah_pertandingan = $jumlah_peserta / 2;
                    $data_pertandingan = [];

                    for ($i = 0; $i < $jumlah_pertandingan; $i++) {
                        $data_pertandingan[$i] = [
                            'perlombaans_id' => $id_perlombaan,
                            'pesertas_id_1' => $data_peserta[$i]->id,
                            'pesertas_id_2' => $data_peserta[$i + 1]->id,
                            'tanggal_jadwal' => Carbon::now()->format('Y-m-d H:i:s')
                        ];
                    }

                    Pertandingan::insert($data_pertandingan);

                    return Response()->json(['status' => true, 'message' => 'Jadwal pertandingan berhasil dibuat!']);
                } else {
                    // Jika jumlah peserta ganjil
                    return Response()->json(['status' => false, 'message' => 'Jumlah peserta tidak boleh ganjil!']);
                }
            }
        } else {
            return Response()->json(['status' => false, 'message' => 'Untuk double masih dalam tahap pengembangan!']);
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
        $data = Perlombaan::findOrFail($id);
        if (request()->ajax()) {
            $data = Perlombaan::findOrFail($id);
            $peserta = Peserta::with('user')->where('perlombaans_id', $data->id)->get();

            return datatables()->of($peserta)
                ->addIndexColumn()
                ->editColumn('photo', function ($item) {
                    return '<img src="' . Storage::url($item->user->photo) . '" alt="photo" style="width: 50px; height: 50px; object-fit: cover; object-position: center;" class="rounded-circle">';
                })
                ->editColumn('action', function ($item) {
                    return '
                        <div class="d-flex">
                            <button class="btn btn-warning btn-sm mb-3 mx-1" onClick="btnUpdatePeserta(' . $item->id . ')">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm mb-3 mx-1" onClick="btnDeletePeserta(' . $item->id . ')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div> 
                    ';
                })
                ->rawColumns(['action', 'photo'])
                ->make(true);
        }
        return view('pages.admin.perlombaan.show', compact('data'));
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
        $data = Perlombaan::findOrFail($request->id);

        return Response()->json($data);
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

    public function showPerlombaan(Request $request)
    {
        $data = Perlombaan::findOrFail($request->id);
        $perserta = Peserta::where('perlombaans_id', $data->id)->get();
        return view('pages.admin.perlombaan.show', compact('data', 'perserta'));
    }
}
