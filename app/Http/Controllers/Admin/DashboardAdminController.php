<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Perlombaan;
use App\Models\User;
use App\Models\Wasit;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $getPerlombaan = Perlombaan::count();
        $getPengguna = User::where('role', '1')->count();
        $getBerita = Berita::count();
        $getVerifikasi = User::where('role', '1')->where('status_account', 'pending')->count();
        $getWasit = Wasit::count();
        return view('pages.admin.dashboard', compact('getPerlombaan', 'getPengguna', 'getBerita', 'getVerifikasi', 'getWasit'));
    }

    public function getVerifikasi()
    {
        
    }

    public function verifikasi(Request $request)
    {
        
    }

    public function detailVerifikasi($id)
    {
        
    }

    
}
