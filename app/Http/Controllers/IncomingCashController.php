<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Akaunting\Money\Money;
// use Illuminate\Http\Request;
use App\Models\IncomingCash;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class IncomingCashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $print = false)
    {     
         
        
        $user = Auth::user();
        
        
        $data = IncomingCash::orderBy('paid_date', 'asc');
        if (request()->input('acc_type')) {
            $data =  $data->where('acc_type', '=', request()->acc_type);
        }
        if (Request::input('date')) {
            $date = explode('-', request()->date);
            $startDate = Carbon::createFromFormat('d/m/Y',trim($date[0]))->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d/m/Y',trim($date[1]))->format('Y-m-d');
            $data = $data->whereBetween('paid_date', [$startDate, $endDate]);
        }

        if($print){
            $total = $data->sum('total');
            $data_print = $data->get()->toArray();
            return response()->json(['data' => $data_print, 'total' => $total]);
        }
        
        $data = $data->paginate(10);

        $totalPerPage = $data->sum('total');
        return view('PenerimaanKas.index', compact('data', 'totalPerPage' ,'user'))->with('request');
    }

    public function print(Request $request){
        $dataReq = $this->index($request, true)->original;
        $data = $dataReq['data'];
        $total = $dataReq['total'];



        $pdf = Pdf::loadView('PenerimaanKas.pdf', compact('data','total'));
        return $pdf->stream('Penerimaan Kas.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make(Request::all(), [
            'nomor_invoice' => 'required|unique:incoming_cash,invoice_number|max:50',
            'acc_type' => 'required',
            'description' => 'required|max:50',
            'tanggal_bayar' => 'required|date',
            'jumlah' => 'required|numeric',
            'keterangan' => 'required|max:100',
            "bukti_penerimaan" => "required|mimes:jpg,pdf,png,jpeg,docx"
        ]);

        if ($validator->fails()) {
            return response()->json([
                'acc_type' => $validator->errors()->get('acc_type'),
                'nomor_invoice' => $validator->errors()->get('nomor_invoice'),
                'description' => $validator->errors()->get('description'),
                'tanggal_bayar' => $validator->errors()->get('tanggal_bayar'),
                'jumlah' => $validator->errors()->get('jumlah'),
                'keterangan' => $validator->errors()->get('keterangan'),
                "bukti_penerimaan" => $validator->errors()->get('bukti_penerimaan'),
                'status' => false,
                'message' => "Penerimaan Kas Gagal Ditambah!"
            ], 422);
        }

        $filename = md5(request()->file('bukti_penerimaan')->getClientOriginalName() . time()) . '.' . request()->file('bukti_penerimaan')->getClientOriginalExtension();
        request()->file('bukti_penerimaan')->move(public_path('bukti'), $filename);

        IncomingCash::create([
            'user_id' => Auth::user()->id,
            'invoice_number' => request()->nomor_invoice,
            'acc_type' => request()->acc_type,
            'description' => request()->description,
            'paid_date' => request()->tanggal_bayar,
            'total' => request()->jumlah,
            'note' => request()->keterangan,
            'file' => $filename 
        ]);

        return response()->json([
            'status' => true,
            'message' => "Penerimaan Kas Berhasil Ditambah!"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(IncomingCash $penerimaan_ka)
    {
        return response()->json([
            'data' => $penerimaan_ka->toArray(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IncomingCash $penerimaan_ka)
    {
    

        $validator = Validator::make(request()->all(), [
            'nomor_invoice' => 'required|max:50|unique:incoming_cash,invoice_number,' . $penerimaan_ka->id,
            // 'nomor_invoice' => ['required', 'max:50', Rule::unique('incoming_cash')->ignore(request()->nomor_invoice)],
            'acc_type' => 'required',
            'description' => 'required|max:50',
            'tanggal_bayar' => 'date|required',
            'jumlah' => 'numeric|required',
            'keterangan' => 'required|max:100',
            "bukti_penerimaan" => "mimes:jpg,pdf,png,jpeg,docx"
        ]);
        // } 

        if ($validator->fails()) {
            return response()->json([
                'nomor_invoice' => $validator->errors()->get('nomor_invoice'),
                'description' => $validator->errors()->get('description'),
                'tanggal_bayar' => $validator->errors()->get('tanggal_bayar'),
                'jumlah' => $validator->errors()->get('jumlah'),
                'keterangan' => $validator->errors()->get('keterangan'),
                "bukti_penerimaan" => $validator->errors()->get('bukti_penerimaan'),
                'status' => false,
                'message' => "Penerimaan Kas Gagal Ditambah!"
            ], 422);
        }

        $data = [
            'invoice_number' => request()->nomor_invoice,
            'acc_type' => request()->acc_type,
            'description' => request()->description,
            'paid_date' => request()->tanggal_bayar,
            'total' => request()->jumlah,
            'note' => request()->keterangan,
        ];

          if(isset(request()->bukti_penerimaan) && !is_null(request()->bukti_penerimaan)){
            $old_file = $penerimaan_ka->file;

            

            if (File::exists(public_path('bukti/').$old_file)) {
                File::delete(public_path('bukti/').$old_file);
            }

            $filename = md5(request()->file('bukti_penerimaan')->getClientOriginalName() . time()) . '.' . request()->file('bukti_penerimaan')->getClientOriginalExtension();
            request()->file('bukti_penerimaan')->move(public_path('bukti'), $filename);
            $data['file'] = $filename;
          }

        $penerimaan_ka->update($data);

        return response()->json([
            'status' => true,
            'message' => "Penerimaan Kas Berhasil Diubah!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(IncomingCash $penerimaan_ka)
    {
        $penerimaan_ka->delete();
        // dd($incomingCash);

        return response()->json([
            'status' => true,
            'message' => 'Penerimaan Kas Berhasil Dihapus!'
        ]);
    }
}
