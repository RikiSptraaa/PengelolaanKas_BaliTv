<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\OutgoingCash;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class OutgoingCashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $print = false)
    {
        $data =  OutgoingCash::orderBy('outgoing_date', 'asc');
        $user = Auth::user();

        if (request()->input('date')) {
            $date = explode('-', request()->date);
            $startDate = Carbon::createFromFormat('d/m/Y',trim($date[0]))->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d/m/Y',trim($date[1]))->format('Y-m-d');
            $data = $data->whereBetween('outgoing_date', [$startDate, $endDate]);
        }
        if (request()->input('acc_type')) {
            $data =  $data->where('acc_type', '=', request()->acc_type);
        }
        
        if($print){
            $total = $data->sum('total');
            $data_print = $data->get()->toArray();
      
            return response()->json(['data' => $data_print, 'total' => $total]) ;
        }

        $data = $data->paginate(10);

        $totalPerPage = $data->sum('total');

        return view('PengeluaranKas.index', compact('data', 'totalPerPage' ,'user'));
    }

    public function print(Request $request){
        $dataReq = $this->index($request, true)->original;
        $data = $dataReq['data'];
        $total = $dataReq['total'];

        $pdf = Pdf::loadView('PengeluaranKas.pdf', compact('data', 'total'));
        return $pdf->stream('Pengeluaran Kas.pdf');
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
            "keterangan" => "required|max:100",
            "bukti_pengeluaran" => "required|mimes:jpg,pdf,png,jpeg,docx"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "nomor_nota" => $validator->errors()->get('nomor_nota'),
                "acc_type" => $validator->errors()->get('acc_type'),
                "description" => $validator->errors()->get('description'),
                "tanggal_pengeluaran" => $validator->errors()->get('tanggal_pengeluaran'),
                "jumlah" => $validator->errors()->get('jumlah'),
                "keterangan" => $validator->errors()->get('keterangan'),
                "bukti_pengeluaran" => $validator->errors()->get('bukti_pengeluaran'),
                "status" => false,
                "message" => "Pengeluaran Kas Gagal Ditambah!"
            ], 422);
        }

        $filename = md5(request()->file('bukti_pengeluaran')->getClientOriginalName() . time()) . '.' . request()->file('bukti_pengeluaran')->getClientOriginalExtension();
        request()->file('bukti_pengeluaran')->move(public_path('bukti'), $filename);

        OutgoingCash::create([
            "user_id" => Auth::user()->id,
            "acc_type" => $request->acc_type,
            "note_number" => $request->nomor_nota,
            "description" => $request->description,
            "outgoing_date" => $request->tanggal_pengeluaran,
            "total" => $request->jumlah,
            "note" => $request->keterangan,
            "file" => $filename
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
            "keterangan" => "required|max:100",
            "bukti_pengeluaran" => "mimes:jpg,pdf,png,jpeg,docx"
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
                "bukti_pengeluaran" => $validator->errors()->get('bukti_pengeluaran'),
                "status" => false,
                "message" => "Pengeluaran Kas Gagal Diubah!"
            ], 422);
        }

        $data = [
            "note_number" => $request->nomor_nota,
            "acc_type" => $request->acc_type,
            "description" => $request->description,
            "outgoing_date" => $request->tanggal_pengeluaran,
            "total" => $request->jumlah,
            "note" => $request->keterangan
        ];
        
        
        
        if(isset($request->bukti_pengeluaran) && !is_null($request->bukti_pengeluaran)){
            $old_file = $pengeluaran_ka->file;

            

            if (File::exists(public_path('bukti/').$old_file)) {
                File::delete(public_path('bukti/').$old_file);
            }

            $filename = md5(request()->file('bukti_pengeluaran')->getClientOriginalName() . time()) . '.' . request()->file('bukti_pengeluaran')->getClientOriginalExtension();
            request()->file('bukti_pengeluaran')->move(public_path('bukti'), $filename);
            $data['file'] = $filename;
        }


        $pengeluaran_ka->update($data);
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
