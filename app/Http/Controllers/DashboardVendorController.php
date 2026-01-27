<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardVendorController extends Controller
{
    public function index()
    {
        $company = session('user')->perusahaan;
        $tahun = date("Y");
        return view('vendor.dashboard')
            ->with([
                'tahun' => $tahun,
                'comp' => $company,
            ]);
    }
}
