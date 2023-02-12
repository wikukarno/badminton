<?php

namespace App\Http\Controllers;

use App\Models\Perlombaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    public function index()
    {
        $perlombaan = Perlombaan::count();
        $user = User::where('id', Auth::user()->id)->first();
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

        return view('pages.user.dashboard', compact('perlombaan'));
    }
}
