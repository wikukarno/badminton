<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Pengurus;
use App\Models\Pertandingan;
use App\Models\User;
use App\Models\Wasit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome');
    }

    public function atlet()
    {
        if (request()->ajax()) {
            $query = User::where('role', '1')->get();

            return datatables()->of($query)
                ->addIndexColumn()
                ->editColumn('phone', function ($item) {
                    return $item->phone ?? '-';
                })
                ->rawColumns(['alamat', 'photo', 'phone', 'action'])
                ->make(true);
        }
        return view('pages.atlet');
    }

    public function wasit()
    {
        if (request()->ajax()) {
            $query = Wasit::query();

            return datatables()->of($query)
                ->addIndexColumn()
                ->editColumn('phone', function ($item) {
                    return $item->phone ?? '-';
                })
                ->rawColumns(['alamat', 'photo', 'phone', 'action'])
                ->make(true);
        }
        return view('pages.wasit');
    }

    public function pengurus()
    {
        if (request()->ajax()) {
            $query = Pengurus::query();

            return datatables()->of($query)
                ->addIndexColumn()
                ->editColumn('phone', function ($item) {
                    return $item->phone ?? '-';
                })
                ->rawColumns(['alamat', 'photo', 'phone', 'action'])
                ->make(true);
        }
        return view('pages.pengurus');
    }

    public function pertandingan()
    {
        if (request()->ajax()) {
            $query = Pertandingan::with(['perlombaan', 'peserta_1', 'peserta_2', 'user'])->orderBy('id', 'DESC')->get();

            return datatables()->of($query)
                ->addIndexColumn()
                ->editColumn('pesertas_id_1', function ($item) {
                    return $item->peserta_1->user->name;
                })
                ->editColumn('pesertas_id_2', function ($item) {
                    return $item->peserta_2->user->name;
                })
                ->editColumn('tanggal_jadwal', function ($item) {
                    return Carbon::parse($item->tanggal_jadwal)->isoFormat('D MMMM Y');
                })

                ->rawColumns(['peserta_1', 'peserta_2', 'tanggal_jadwal'])
                ->make(true);
        }
        return view('pages.pertandingan');
    }

    public function berita()
    {
        $items = Berita::all();
        return view('pages.berita', compact('items'));
    }

    public function detailBerita($slug)
    {
        $item = Berita::where('slug', $slug)->firstOrFail();
        return view('pages.detail-berita', compact('item'));
    }
}
