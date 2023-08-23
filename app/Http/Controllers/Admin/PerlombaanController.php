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
                    $cek_pertandingan_exists = Pertandingan::where('perlombaans_id', $item->id)->count();

                    if ($tanggal_sekarang > $tanggal_pendaftaran_ditutup) {
                        if ($cek_pertandingan_exists > 0) {
                            return '
                                <div class="d-flex">
                                    <a href="' . route('0.show.perlombaan', $item->id) . '" title="Tampil Detail Perlombaan" target="_blank" class="btn btn-info btn-sm mb-3 mx-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" title="Buat Jadwal Pertandingan Acak" class="btn btn-success btn-sm mb-3 mx-1" disabled>
                                        <i class="fas fa-random"></i>
                                    </button>
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
                        }
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

        // Cek jika kategori perlombaan adalah tunggal
        if ($data_perlombaan->kategori_perlombaan == 'Tunggal Putra' || $data_perlombaan->kategori_perlombaan == 'Tunggal Putri') {
            $data_peserta = Peserta::where('perlombaans_id', $id_perlombaan)->get()->toArray();
            $jumlah_peserta = count($data_peserta);

            // Jika jumlah peserta kurang dari 2
            if ($jumlah_peserta < 2) {
                return Response()->json(['status' => false, 'message' => 'Jumlah peserta kurang dari 2!']);
            } else {
                // Jika jumlah peserta genap
                if ($jumlah_peserta % 2 == 0) {
                    // Acak array data_peserta untuk mengacak urutan peserta, sehingga unik urutannya
                    shuffle($data_peserta);

                    // Buat pasangan untuk pertandingannya
                    $pair_count = $jumlah_peserta / 2;

                    // Dapatkan tanggal_pendaftaran_ditutup dari data perlombaan
                    $tanggal_pendaftaran_ditutup = Carbon::parse($data_perlombaan->tanggal_pendaftaran_ditutup);

                    // Kalkulasi tanggal mulai dan tanggal selesai berdasarkan 'tanggal_pendaftaran_ditutup'
                    // $start_date = $tanggal_pendaftaran_ditutup->addDay(1);
                    // $end_date = $start_date->addDay($pair_count - 1);

                    for ($i = 0; $i < $pair_count; $i++) {
                        $index1 = $i * 2;
                        $index2 = $index1 + 1;

                        // Cek jika index2 berada dalam batas array
                        if (isset($data_peserta[$index2])) {
                            // Generate random tanggal_jadwal between the calculated date range
                            // Buat tanggal jadwal secara acak antara tanggal mulai dan tanggal selesai
                            // $random_date = Carbon::createFromTimestamp(rand($start_date->timestamp, $end_date->timestamp));

                            // Buat tanggal jadwal baru secara random
                            $tanggal_jadwal = $tanggal_pendaftaran_ditutup->addDays(rand(1, 7))->format('Y-m-d H:i:s');

                            // Simpan pasangan pertandingannya ke tabel pertandingans
                            Pertandingan::create([
                                'perlombaans_id' => $id_perlombaan,
                                'pesertas_id_1' => $data_peserta[$index1]['id'],
                                'pesertas_id_2' => $data_peserta[$index2]['id'],
                                // 'tanggal_jadwal' => $random_date->format('Y-m-d H:i:s')
                                'tanggal_jadwal' => $tanggal_jadwal
                            ]);
                        }
                    }

                    return Response()->json(['status' => true, 'message' => 'Jadwal pertandingan berhasil dibuat!']);
                } else {
                    // Jika jumlah peserta ganjil
                    return Response()->json(['status' => false, 'message' => 'Jumlah peserta tidak boleh ganjil!']);
                }
            }
            // Cek jika kategori perlombaan adalah ganda
        } elseif ($data_perlombaan->kategori_perlombaan == 'Ganda Putra' || $data_perlombaan->kategori_perlombaan == 'Ganda Putri' || $data_perlombaan->kategori_perlombaan == 'Ganda Campuran') {
            $data_peserta = Peserta::where('perlombaans_id', $id_perlombaan)->get()->toArray();
            $jumlah_peserta = count($data_peserta);

            // Jika jumlah peserta kurang dari 2
            if ($jumlah_peserta < 2) {
                return Response()->json(['status' => false, 'message' => 'Jumlah peserta kurang dari 2!']);
            } else {
                // Jika jumlah peserta genap
                if ($jumlah_peserta % 2 == 0) {
                    // Acak array data_peserta untuk mengacak urutan peserta, sehingga unik urutannya
                    shuffle($data_peserta);

                    // Buat pasangan untuk pertandingannya
                    $pair_count = $jumlah_peserta / 2;

                    // Dapatkan tanggal_pendaftaran_ditutup dari data perlombaan
                    $tanggal_pendaftaran_ditutup = Carbon::parse($data_perlombaan->tanggal_pendaftaran_ditutup);

                    // Kalkulasi tanggal mulai dan tanggal selesai berdasarkan 'tanggal_pendaftaran_ditutup'
                    // $start_date = $tanggal_pendaftaran_ditutup->addDay(1);
                    // $end_date = $start_date->addDay($pair_count - 1);

                    for ($i = 0; $i < $pair_count; $i++) {
                        $index1 = $i * 2;
                        $index2 = $index1 + 1;

                        // Cek jika index2 berada dalam batas array
                        if (isset($data_peserta[$index2])) {
                            // Generate random tanggal_jadwal between the calculated date range
                            // Buat tanggal jadwal secara acak antara tanggal mulai dan tanggal selesai
                            // $random_date = Carbon::createFromTimestamp(rand($start_date->timestamp, $end_date->timestamp));

                            // Buat tanggal jadwal baru secara random
                            $tanggal_jadwal = $tanggal_pendaftaran_ditutup->addDays(rand(1, 7))->format('Y-m-d H:i:s');

                            // Simpan pasangan pertandingannya ke tabel pertandingans
                            Pertandingan::create([
                                'perlombaans_id' => $id_perlombaan,
                                'pesertas_id_1' => $data_peserta[$index1]['id'],
                                'pesertas_id_2' => $data_peserta[$index2]['id'],
                                // 'tanggal_jadwal' => $random_date->format('Y-m-d H:i:s')
                                'tanggal_jadwal' => $tanggal_jadwal
                            ]);
                        }
                    }

                    return Response()->json(['status' => true, 'message' => 'Jadwal pertandingan berhasil dibuat!']);
                } else {
                    // Jika jumlah peserta ganjil
                    return Response()->json(['status' => false, 'message' => 'Jumlah peserta tidak boleh ganjil!']);
                }
            }
        } else {
            return Response()->json(['status' => false, 'message' => 'Kategori perlombaan tidak ditemukan!']);
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
