<?php

namespace App\Http\Controllers;

use App\Models\IncomingCash;
use Illuminate\Validation\Rule;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class IncomingCashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request()->all();
        $data = IncomingCash::latest();
        if (Request::input('search')) {
            $data =  $data->where('invoice_number', 'LIKE', '%' . request()->search . '%')->orWhere('description', 'LIKE', '%' . request()->search . '%');
        }
        if (Request::input('date')) {
            $data =  $data->where('paid_date', '=', request()->date);
        }
        $data = $data->paginate(10);
        return view('PenerimaanKas.index', compact('data'))->with('request');
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
            'keterangan' => 'required|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'acc_type' => $validator->errors()->get('acc_type'),
                'nomor_invoice' => $validator->errors()->get('nomor_invoice'),
                'description' => $validator->errors()->get('description'),
                'tanggal_bayar' => $validator->errors()->get('tanggal_bayar'),
                'jumlah' => $validator->errors()->get('jumlah'),
                'keterangan' => $validator->errors()->get('keterangan'),
                'status' => false,
                'message' => "Penerimaan Kas Gagal Ditambah!"
            ], 422);
        }

        IncomingCash::create([
            'user_id' => Auth::user()->id,
            'invoice_number' => request()->nomor_invoice,
            'acc_type' => request()->acc_type,
            'description' => request()->description,
            'paid_date' => request()->tanggal_bayar,
            'total' => request()->jumlah,
            'note' => request()->keterangan,
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
        // dd(request()->all());
        // if (request()->nomor_invoice == $penerimaan_ka->invoice_number) {

        $validator = Validator::make(request()->all(), [
            'nomor_invoice' => 'required|max:50|unique:incoming_cash,invoice_number,' . $penerimaan_ka->id,
            // 'nomor_invoice' => ['required', 'max:50', Rule::unique('incoming_cash')->ignore(request()->nomor_invoice)],
            'acc_type' => 'required',
            'description' => 'required|max:50',
            'tanggal_bayar' => 'date|required',
            'jumlah' => 'numeric|required',
            'keterangan' => 'required|max:100'
        ]);
        // } 

        if ($validator->fails()) {
            return response()->json([
                'nomor_invoice' => $validator->errors()->get('nomor_invoice'),
                'description' => $validator->errors()->get('description'),
                'tanggal_bayar' => $validator->errors()->get('tanggal_bayar'),
                'jumlah' => $validator->errors()->get('jumlah'),
                'keterangan' => $validator->errors()->get('keterangan'),
                'status' => false,
                'message' => "Penerimaan Kas Gagal Ditambah!"
            ], 422);
        }

        $penerimaan_ka->update([
            'invoice_number' => request()->nomor_invoice,
            'acc_type' => request()->acc_type,
            'description' => request()->description,
            'paid_date' => request()->tanggal_bayar,
            'total' => request()->jumlah,
            'note' => request()->keterangan,
        ]);

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
