<?php

namespace App\Http\Controllers;

use App\Models\IncomingCash;
use App\Models\OutgoingCash;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.laba');
    }

    public function show(Request $request)
    {

        $date = $request->date == null ? date('Y-m-d') : $request->date;

        $acc_income = IncomingCash::whereDate('paid_date', '<=', $date)->get()->toArray();
        $acc_outgoing = OutgoingCash::whereDate('outgoing_date', '<=', $date)->where('acc_type', 1)->get()->toArray();


        return response()->json([
            'report_view' => view(
                'report.report-laba',
                compact(
                    'acc_income',
                    'acc_outgoing',
                    'date'
                )
            )->render(),
        ]);
    }

    public function printLaba(Request $request)
    {
        $date = $request->date == null ? date('Y-m-d') : $request->date;
        $is_print = true;

        $acc_income = IncomingCash::whereDate('paid_date', '<=', $date)->get()->toArray();
        $acc_outgoing = OutgoingCash::whereDate('outgoing_date', '<=', $date)->where('acc_type', 1)->get()->toArray();


        $pdf = Pdf::loadView('report.report-laba', compact('date', 'acc_income', 'acc_outgoing', 'is_print'));
        return $pdf->stream('Laba.pdf');
    }
}
