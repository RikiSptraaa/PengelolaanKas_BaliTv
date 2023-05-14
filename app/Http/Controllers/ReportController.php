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

        if($request->date == null){
            return response()->json([
                'status' => false,
                'message' => "Silahkan Pilih Bulan Terlebihdahulu"
            ], 400);
        }
        $month = explode('-', $request['date']?? null);


        $acc_income = IncomingCash::whereMonth('paid_date', $month[1])->whereYear('paid_date', $month[0])->get()->toArray();
        $acc_outgoing = OutgoingCash::whereMonth('outgoing_date', $month[1])->whereYear('outgoing_date', $month[0])->get()->toArray();


        return response()->json([
            'report_view' => view(
                'report.report-laba',
                compact(
                    'acc_income',
                    'acc_outgoing',
                    'month'
                )
            )->render(),
        ]);
    }

    public function printLaba(Request $request)
    {
        // $date = $request->date == null ? date('Y-m-d') : $request->date;
        $month = explode('-', $request['date']?? null);

        $is_print = true;

        $acc_income = IncomingCash::whereMonth('paid_date', $month[1])->whereYear('paid_date', $month[0])->get()->toArray();
        $acc_outgoing = OutgoingCash::whereMonth('outgoing_date', $month[1])->whereYear('outgoing_date', $month[0])->get()->toArray();


        $pdf = Pdf::loadView('report.report-laba', compact('month', 'acc_income', 'acc_outgoing', 'is_print'));
        return $pdf->stream('Laba.pdf');
    }

    public function index_equity(){
        return view('report.equity');
    }

    public function show_equity(Request $request){

        if($request->date == null){
            return response()->json([
                'status' => false,
                'message' => "Silahkan Pilih Bulan Terlebihdahulu"
            ], 400);
        }

        $month = explode('-', $request['date']?? null);


        $acc_income = IncomingCash::whereMonth('paid_date', $month[1])->whereYear('paid_date', $month[0])->get()->toArray();
        $acc_outgoing = OutgoingCash::whereMonth('outgoing_date', $month[1])->whereYear('outgoing_date', $month[0])->get()->toArray();

        $pendapatan = collect($acc_income)->whereIn('acc_type', [2,3,6])->sum('total') ?? 0;
        $beban = collect($acc_outgoing)->whereIn('acc_type', [1,6,7,8])->sum('total') ?? 0;                    
        $laba_bersih = $pendapatan - $beban;

        return response()->json([
            'report_view' => view(
                'report.report-equity',
                compact(
                    'acc_income',
                    'acc_outgoing',
                    'month',
                    'laba_bersih'
                )
            )->render(),
        ]);
    }
    public function print_equity(Request $request)
    {
        $month = explode('-', $request['date']?? null);
        $date = $request->date == null ? date('Y-m-d') : $request->date;
        $is_print = true;

        $acc_income = IncomingCash::whereMonth('paid_date', $month[1])->whereYear('paid_date', $month[0])->get()->toArray();
        $acc_outgoing = OutgoingCash::whereMonth('outgoing_date', $month[1])->whereYear('outgoing_date', $month[0])->get()->toArray();

        $pendapatan = collect($acc_income)->where('acc_type', 2)->sum('total') ?? 0;
        $beban = collect($acc_outgoing)->where('acc_type', 1)->sum('total') ?? 0;                 
        $laba_bersih = $pendapatan - $beban;


        $pdf = Pdf::loadView('report.report-equity', compact( 'acc_income',
        'acc_outgoing',
        'month',
        'laba_bersih',
        'is_print'));
        return $pdf->stream('Perubahan Ekuitas '.$date.'.pdf');
    }

    public function index_neraca(){
        return view('report.neraca');
    }
    public function show_neraca(Request $request){
        if($request->date == null){
            return response()->json([
                'status' => false,
                'message' => "Silahkan Pilih Bulan Terlebihdahulu"
            ], 400);
        }
        $month = explode('-', $request['date']?? null);

        $date = $request->date == null ? date('Y-m-d') : $request->date;
       

        $acc_income = IncomingCash::whereMonth('paid_date', $month[1])->whereYear('paid_date', $month[0])->get()->toArray();
        $acc_outgoing = OutgoingCash::whereMonth('outgoing_date', $month[1])->whereYear('outgoing_date', $month[0])->get()->toArray();

        return response()->json([
            'report_view' => view(
                'report.report-neraca',
                compact(
                    'acc_income',
                    'acc_outgoing',
                    'month',
                )
            )->render(),
        ]);

    }
    public function print_neraca(Request $request)
    {
        $month = explode('-', $request['date']?? null);

        $date = $request->date == null ? date('Y-m-d') : $request->date;
        $is_print = true;

        $acc_income = IncomingCash::whereMonth('paid_date', $month[1])->whereYear('paid_date', $month[0])->get()->toArray();
        $acc_outgoing = OutgoingCash::whereMonth('outgoing_date', $month[1])->whereYear('outgoing_date', $month[0])->get()->toArray();

        $pdf = Pdf::loadView('report.report-neraca', compact( 'acc_income',
        'acc_outgoing',
        'month',
        'is_print'));
        return $pdf->stream('Laporan Neraca '.$date.'.pdf');
    }
}
