<?php

namespace App\Http\Controllers;

use App\Models\Perlombaan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $perlombaan = Perlombaan::count();
        return view('pages.user.dashboard', compact('perlombaan'));
    }
}
