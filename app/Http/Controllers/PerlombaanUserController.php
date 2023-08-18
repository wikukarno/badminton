<?php

namespace App\Http\Controllers;

use App\Models\Perlombaan;
use App\Models\Peserta;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;

class PerlombaanUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('id', Auth::user()->id)->first();
        $data = Perlombaan::first();
        $peserta = Peserta::where('users_id', Auth::user()->id)->first();
        if (
            $user->phone == null || $user->jenis_kelamin == null ||
            $user->tempat_lahir == null || $user->tanggal_lahir == null ||
            $user->pekerjaan == null || $user->agama == null ||
            $user->kabupaten == null || $user->kecamatan == null ||
            $user->desa == null || $user->alamat == null ||
            $user->phone == null || $user->ktp == null || $user->kk == null
        ) {
            Alert::warning('Mohon Maaf!', 'Silahkan Lengkapi Data Anda Terlebih Dahulu');
            return redirect()->route('akun.index');
        }

        if (request()->ajax()) {
            $jenis_kelamin = Auth::user()->jenis_kelamin;
            $cek_jenis_kelamin = $jenis_kelamin == 'Laki-laki' ? 'Putra' : 'Putri';

            $query = Perlombaan::where('kategori_perlombaan', 'like', '%' . $cek_jenis_kelamin . '%')->orWhere('kategori_perlombaan', 'like', '%' . 'Campuran' . '%')->get();

            return datatables()->of($query)
                ->addIndexColumn()
                ->editColumn('tanggal_pelaksanaan', function ($item) {
                    return Carbon::parse($item->tanggal_pelaksanaan)->isoFormat('D MMMM Y');
                })
                ->editColumn('tanggal_pendaftaran_dibuka', function ($item) {
                    return Carbon::parse($item->tanggal_pendaftaran_dibuka)->isoFormat('D MMMM Y');
                })
                ->editColumn('tanggal_pendaftaran_ditutup', function ($item) {
                    return Carbon::parse($item->tanggal_pendaftaran_ditutup)->isoFormat('D MMMM Y');
                })
                ->editColumn('action', function ($item) {
                    $peserta = Peserta::where('users_id', Auth::user()->id)->where('perlombaans_id', $item->id)->first();
                    if ($peserta != null) {
                        return '
                            <a href="' . route('1.download.kartu', $item->id) . '" class="btn btn-success">Download Kartu Peserta</a>
                        ';
                    } else {
                        return '
                            <a href="' . route('perlombaan.show', $item->id) . '" class="btn btn-info btn-sm mb-3" >
                                <i class="fas fa-eye"></i>
                            </a>
                        ';
                    }
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.user.perlombaan.index', compact('data', 'peserta', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.user.perlombaan.create');
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
        $data['users_id'] = Auth::user()->id;
        $data['perlombaans_id'] = $request->perlombaans_id;
        Peserta::create($data);

        if ($data) {
            Alert::success('Berhasil', 'Data Berhasil Ditambahkan');
            return redirect()->route('perlombaan.index');
        } else {
            Alert::error('Gagal', 'Data Gagal Ditambahkan');
            return redirect()->route('perlombaan.index');
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
        return view('pages.user.perlombaan.show', compact('data'));
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
    public function destroy($id)
    {
        //
    }

    public function daftar($id)
    {
        $data = Perlombaan::findOrFail($id);
        return view('pages.user.perlombaan.create', compact('data'));
    }

    public function downloadKartu($id)
    {
        $path = base_path('/public/assets/images/pbsi.png');
        // $path = url('/backend/img/team-1.jpg');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $pic = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $data = Peserta::with('user')->where('users_id', Auth::user()->id)->where('perlombaans_id', $id)->first();

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('cetak/kartu-peserta', [
            'data' => $data,
            'pic' => $pic,
        ])->setPaper('a4', 'potrait');
        // return $pdf->stream();
        return $pdf->download('Kartu Peserta - ' . Auth::user()->name . '.pdf');
    }
}
