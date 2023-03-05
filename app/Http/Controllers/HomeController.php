<?php

namespace App\Http\Controllers;

use App\Models\Pengurus;
use App\Models\User;
use App\Models\Wasit;
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
}
