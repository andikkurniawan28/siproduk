<?php

namespace App\Http\Controllers;

use App\Models\Weighing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanPerTanggalController extends Controller
{
    public function index()
    {
        return view('laporan_per_tanggal');
    }

    public function data($from, $to)
    {
        $data = Weighing::select('line', 'created_at', 'result')
            ->whereBetween('created_at', [$from, $to])
            ->orderBy('line')
            ->orderBy('created_at', 'asc')
            ->get();

        return $data;
    }
}
