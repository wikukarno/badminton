<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pertandingan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PertandinganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

                ->rawColumns(['peserta_1', 'peserta_2', 'tanggal_jadwal'])
                ->make(true);
        }

        return view('pages.admin.pertandingan.index');
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
        //
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
}
