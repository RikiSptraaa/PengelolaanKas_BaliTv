<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\IncomingCash;
use App\Models\OutgoingCash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            $thisDay= Carbon::now()->format('Y-m-d');
            $thisMonth = Carbon::now()->month;
            $penerimaanDaily = IncomingCash::whereDate('paid_date', $thisDay)->get()->sum('total');
            $pengeluaranDaily = OutgoingCash::whereDate('outgoing_date', $thisDay)->get()->sum('total');
            $penerimaan = IncomingCash::whereMonth('paid_date', $thisMonth)->get()->sum('total');
            $pengeluaran = OutgoingCash::whereMonth('outgoing_date', $thisMonth)->get()->sum('total');
            return view('landing', compact('penerimaan', 'pengeluaran', 'penerimaanDaily', 'pengeluaranDaily'));
        }

        return redirect('/login');
    }
}
