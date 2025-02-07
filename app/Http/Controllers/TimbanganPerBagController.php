<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Weighing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimbanganPerBagController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $context)
    {
        $context = strtoupper($context);
        if ($request->ajax()) {
            $data = Weighing::where('line', $context)->select(['id', 'setting', 'result', 'created_at']);
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('setting', function($row) {
                    return number_format($row->setting, 2);
                })
                ->editColumn('result', function($row) {
                    return number_format($row->result, 2);
                })
                ->editColumn('created_at', function($row) {
                    return date("Y-m-d H:i:s", strtotime($row->created_at));
                })
                ->make(true);
        }
        return view('timbangan_per_line', compact('context'));
    }
}
