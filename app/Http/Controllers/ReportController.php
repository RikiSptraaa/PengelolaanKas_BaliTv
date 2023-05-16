<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        $date = explode('-', request()->date);
        $startDate = Carbon::createFromFormat('d/m/Y',trim($date[0]))->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y',trim($date[1]))->format('Y-m-d');



        $acc_income = IncomingCash::whereBetween('paid_date', [$startDate, $endDate])->get()->toArray();
        $acc_outgoing = OutgoingCash::whereBetween('outgoing_date', [$startDate, $endDate])->get()->toArray();


        return response()->json([
            'report_view' => view(
                'report.report-laba',
                compact(
                    'acc_income',
                    'acc_outgoing',
                    'startDate', 
                    'endDate'
                )
            )->render(),
        ]);
    }

    public function printLaba(Request $request)
    {
        $date = explode('-', request()->date);
        $startDate = Carbon::createFromFormat('d/m/Y',trim($date[0]))->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y',trim($date[1]))->format('Y-m-d');

        $is_print = true;

        $acc_income = IncomingCash::whereBetween('paid_date', [$startDate, $endDate])->get()->toArray();
        $acc_outgoing = OutgoingCash::whereBetween('outgoing_date', [$startDate, $endDate])->get()->toArray();


        $pdf = Pdf::loadView('report.report-laba', compact('startDate', 'endDate','acc_income', 'acc_outgoing', 'is_print'));
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

        $date = explode('-', request()->date);
        $startDate = Carbon::createFromFormat('d/m/Y',trim($date[0]))->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y',trim($date[1]))->format('Y-m-d');


        $acc_income = IncomingCash::whereBetween('paid_date', [$startDate, $endDate])->get()->toArray();
        $acc_outgoing = OutgoingCash::whereBetween('outgoing_date', [$startDate, $endDate])->get()->toArray();
        
        $pendapatan = collect($acc_income)->whereIn('acc_type', [2,3,6])->sum('total') ?? 0;
        $beban = collect($acc_outgoing)->whereIn('acc_type', [1,6,7,8])->sum('total') ?? 0;                    
        $laba_bersih = $pendapatan - $beban;

        return response()->json([
            'report_view' => view(
                'report.report-equity',
                compact(
                    'acc_income',
                    'acc_outgoing',
                    'startDate', 
                    'endDate',
                    'laba_bersih'
                )
            )->render(),
        ]);
    }
    public function print_equity(Request $request)
    {
        $date = explode('-', request()->date);
        $startDate = Carbon::createFromFormat('d/m/Y',trim($date[0]))->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y',trim($date[1]))->format('Y-m-d');

        $is_print = true;

        $acc_income = IncomingCash::whereBetween('paid_date', [$startDate, $endDate])->get()->toArray();
        $acc_outgoing = OutgoingCash::whereBetween('outgoing_date', [$startDate, $endDate])->get()->toArray();

        $pendapatan = collect($acc_income)->whereIn('acc_type', [2,3,6])->sum('total') ?? 0;
        $beban = collect($acc_outgoing)->whereIn('acc_type', [1,6,7,8])->sum('total') ?? 0;                 
        $laba_bersih = $pendapatan - $beban;


        $pdf = Pdf::loadView('report.report-equity', compact( 'acc_income',
        'acc_outgoing',
        'startDate', 
        'endDate',
        'laba_bersih',
        'is_print'));
        return $pdf->stream('Perubahan Ekuitas '.$startDate.'-'.$endDate.'.pdf');
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
        $date = explode('-', request()->date);
        $startDate = Carbon::createFromFormat('d/m/Y',trim($date[0]))->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y',trim($date[1]))->format('Y-m-d');
       

     
        $acc_income = IncomingCash::whereBetween('paid_date', [$startDate, $endDate])->get()->toArray();
        $acc_outgoing = OutgoingCash::whereBetween('outgoing_date', [$startDate, $endDate])->get()->toArray();

        $pendapatan = collect($acc_income)->whereIn('acc_type', [2,3,6])->sum('total') ?? 0;
        $beban = collect($acc_outgoing)->whereIn('acc_type', [1,6,7,8])->sum('total') ?? 0;                 
        $laba_bersih = $pendapatan - $beban;

        $modal_awal = collect($acc_income)->whereIn('acc_type', 7 )->sum('total') ?? 0;
        $prive = collect($acc_outgoing)->where('acc_type', 4)->sum('total');    
        $penambahan_modal = $laba_bersih-$prive;
        $modal_akhir = $modal_awal + $penambahan_modal;

        return response()->json([
            'report_view' => view(
                'report.report-neraca',
                compact(
                    'acc_income',
                    'acc_outgoing',
                    'startDate',
                    'endDate',
                    'modal_akhir'
                )
            )->render(),
        ]);

    }
    public function print_neraca(Request $request)
    {
        $date = explode('-', request()->date);
        $startDate = Carbon::createFromFormat('d/m/Y',trim($date[0]))->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y',trim($date[1]))->format('Y-m-d');

        $is_print = true;

        $acc_income = IncomingCash::whereBetween('paid_date', [$startDate, $endDate])->get()->toArray();
        $acc_outgoing = OutgoingCash::whereBetween('outgoing_date', [$startDate, $endDate])->get()->toArray();

        $pendapatan = collect($acc_income)->whereIn('acc_type', [2,3,6])->sum('total') ?? 0;
        $beban = collect($acc_outgoing)->whereIn('acc_type', [1,6,7,8])->sum('total') ?? 0;                 
        $laba_bersih = $pendapatan - $beban;

        $modal_awal = collect($acc_income)->whereIn('acc_type', 7 )->sum('total') ?? 0;
        $prive = collect($acc_outgoing)->where('acc_type', 4)->sum('total');    
        $penambahan_modal = $laba_bersih-$prive;
        $modal_akhir = $modal_awal + $penambahan_modal;

        $pdf = Pdf::loadView('report.report-neraca', compact( 'acc_income',
        'acc_outgoing',
        'startDate',
        'endDate',
        'modal_akhir',
        'is_print'));
        return $pdf->stream('Laporan Neraca '.$startDate.'-'.$endDate.'.pdf');
    }
}
