<?php

namespace App\Http\Controllers;

use App\Models\Weighing;
use Illuminate\Http\Request;

class DashboardApiController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $date['from'] = date("Y-m-d 06:00");
        $date['to'] = date("Y-m-d H:i", strtotime($date['from'] . "+24 hours"));

        // Ambil semua data dalam rentang waktu
        $weighings = Weighing::whereBetween('created_at', [$date['from'], $date['to']])->get();

        // Inisialisasi array hasil
        $data = [];

        // Fungsi untuk memformat angka atau mengembalikan null jika datanya null
        $formatNumber = fn($value) => is_null($value) ? null : number_format($value, 2);

        // Hitung data global
        $data['global'] = [
            'tertimbang_sak' => $weighings->count(),
            'tertimbang_ku'  => $weighings->count() / 2,
            'min'           => $formatNumber($weighings->min('result')),
            'max'           => $formatNumber($weighings->max('result')),
            'avg'           => $formatNumber($weighings->avg('result')),
        ];

        // Daftar line yang akan diproses
        $lines = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'];

        foreach ($lines as $line) {
            $filtered = $weighings->where('line', $line);

            $data[$line] = [
                'tertimbang_sak' => $filtered->count(),
                'tertimbang_ku'  => $filtered->count() / 2,
                'min'           => $formatNumber($filtered->min('result')),
                'max'           => $formatNumber($filtered->max('result')),
                'avg'           => $formatNumber($filtered->avg('result')),
            ];
        }

        return $data;
    }

}
