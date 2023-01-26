<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = User::where('role', 1)->where('status_account', 'aktif')->get();

            return datatables()->of($query)
                ->addIndexColumn()
                ->editColumn('photo', function ($item) {
                    if ($item->photo != null) {
                        return '<img src="' . Storage::url($item->photo) . '" class="img-fluid rounded-circle" width="40px" height="40px">';
                    } else {
                        return '<img src="' . asset('assets/images/user.png') . '" class="img-fluid rounded-circle" width="40px" height="40px">';
                    }
                })
                ->editColumn('phone', function ($item) {
                    return $item->phone ?? '-';
                })
                ->editColumn('alamat', function ($item) {
                    return $item->alamat ?? '-';
                })
                ->rawColumns(['alamat', 'photo', 'phone', 'action'])
                ->make(true);
        }
        return view('pages.admin.pengguna.index');
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
    public function update(Request $request)
    {
        $data = User::findOrFail($request->id);
        $data->update([
            'status_account' => $request->status_account,
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);

        if($data){
            Alert::success('Berhasil', 'Data berhasil diubah');
            return redirect()->route('admin.pengguna.index');
        }else{
            Alert::error('Gagal', 'Data gagal diubah');
            return redirect()->route('admin.pengguna.index');
        }
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
