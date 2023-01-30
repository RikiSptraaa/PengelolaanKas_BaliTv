<?php

namespace App\Http\Controllers;

use App\Models\OutgoingCash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OutgoingCashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($print = false)
    {
        $data =  OutgoingCash::latest();

        if (request()->input('search')) {
            $data = $data->Where('description', 'LIKE', '%' . request('search') . '%')->orWhere('note_number', 'LIKE', '%' . request('search') . '%');
        }
        if (request()->input('date')) {
            $data = $data->where('outgoing_date', '=',  request('date'));
        }
        if (request()->input('acc_type')) {
            $data =  $data->where('acc_type', '=', request()->acc_type);
        }

        $data = $data->paginate(10);

        return view('PengeluaranKas.index', compact('data'));
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
        $validator = Validator::make($request->all(), [
            "nomor_nota" => "required|max:50|unique:outgoing_cash,note_number",
            "acc_type" => "required",
            "description" => 'required|max:50',
            "tanggal_pengeluaran" => "required|date",
            "jumlah" => "required|numeric",
            "keterangan" => "required|max:100"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "nomor_nota" => $validator->errors()->get('nomor_nota'),
                "acc_type" => $validator->errors()->get('acc_type'),
                "description" => $validator->errors()->get('description'),
                "tanggal_pengeluaran" => $validator->errors()->get('tanggal_pengeluaran'),
                "jumlah" => $validator->errors()->get('jumlah'),
                "keterangan" => $validator->errors()->get('keterangan'),
                "status" => false,
                "message" => "Pengeluaran Kas Gagal Ditambah!"
            ], 422);
        }

        OutgoingCash::create([
            "user_id" => Auth::user()->id,
            "acc_type" => $request->acc_type,
            "note_number" => $request->nomor_nota,
            "description" => $request->description,
            "outgoing_date" => $request->tanggal_pengeluaran,
            "total" => $request->jumlah,
            "note" => $request->keterangan
        ]);

        return response()->json([
            "status" => true,
            "message" => "Pengeluaran Kas Berhasil Ditambah!"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(OutgoingCash $pengeluaran_ka)
    {
        $data = $pengeluaran_ka->toArray();

        return response()->json([
            "data" => $data
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
    public function update(Request $request, OutgoingCash $pengeluaran_ka)
    {
        $validator = Validator::make($request->all(), [
            "nomor_nota" => "required|max:50|unique:outgoing_cash,note_number," . $pengeluaran_ka->id,
            "description" => 'required|max:100',
            "tanggal_pengeluaran" => "required|date",
            "jumlah" => "required|numeric",
            "keterangan" => "required|max:100"
        ]);

        // if ($request->nomor_nota == $pengeluaran_ka->note_number) {
        //     $validator = Validator::make($request->all(), [
        //         "nomor_nota" => "required|max:50",
        //         "nama_karyawan" => 'required|max:100',
        //         "jabatan" => "required|max:50",
        //         "tanggal_pengeluaran" => "required|date",
        //         "jumlah" => "required|numeric",
        //         "keterangan" => "required|max:100"
        //     ]);
        // }

        if ($validator->fails()) {
            return response()->json([
                "nomor_nota" => $validator->errors()->get('nomor_nota'),
                "description" => $validator->errors()->get('description'),
                "tanggal_pengeluaran" => $validator->errors()->get('tanggal_pengeluaran'),
                "jumlah" => $validator->errors()->get('jumlah'),
                "keterangan" => $validator->errors()->get('keterangan'),
                "status" => false,
                "message" => "Pengeluaran Kas Gagal Diubah!"
            ], 422);
        }

        $pengeluaran_ka->update([
            "note_number" => $request->nomor_nota,
            "acc_type" => $request->acc_type,
            "description" => $request->description,
            "outgoing_date" => $request->tanggal_pengeluaran,
            "total" => $request->jumlah,
            "note" => $request->keterangan
        ]);
        return response()->json([
            "status" => true,
            "message" => "Pengeluaran Kas Berhasil Ditambah!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(OutgoingCash $pengeluaran_ka)
    {
        $pengeluaran_ka->delete();
    }
}
