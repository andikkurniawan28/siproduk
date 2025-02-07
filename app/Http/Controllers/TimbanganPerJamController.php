<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Weighing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimbanganPerJamController extends Controller
{
    public function index($context)
    {
        $context = strtoupper($context);
        $data = self::data($context);
        return view('timbangan_per_jam', compact('context', 'data'));
        return $data;
    }

    public function data($context)
    {
        $from = Carbon::today()->setHour(7)->setMinute(0);
        $to = $from->copy()->addHours(16);

        $data = Weighing::selectRaw("
                DATE_FORMAT(MIN(created_at), '%H:00-%H:59') as jam,
                COUNT(id) as perolehan_sak
            ")
            ->where('line', $context)
            ->whereBetween('created_at', [$from, $to])
            ->groupBy(DB::raw("HOUR(created_at)"))
            ->orderBy(DB::raw("HOUR(created_at)"))
            ->pluck('perolehan_sak', 'jam')
            ->toArray();

        $hours = [];
        for ($i = 0; $i < 16; $i++) {
            $start = $from->copy()->addHours($i);
            $end = $start->copy()->addHour()->subMinute(); // 07:00-07:59, 08:00-08:59, dst.

            $key = $start->format('H:00') . '-' . $end->format('H:59');
            $perolehan_sak = $data[$key] ?? '-';
            $perolehan_ku = is_numeric($perolehan_sak) ? $perolehan_sak / 2 : '-';

            $hours[] = [
                'jam' => $key,
                'perolehan_sak' => $perolehan_sak,
                'perolehan_ku' => $perolehan_ku,
            ];
        }

        return $hours;

    }
}
