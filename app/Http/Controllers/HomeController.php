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
            $acc_type_income = [
                1 => 'kas',
                2 => 'Pendapatan Kunjungan',
                3 => 'Pendapatan Iklan',
                4 => 'Perlengkapan',
                5 => 'Peralatan',
                6 => 'Pendapatan Liputan',
                7 => 'Modal'
            ];
            $acc_type_outgoing = [
                1 => "Beban Sewa",
                2 => "Utang Usaha",
                3 => "Utang Upah",
                4 => "Prive",
                5 => "Akumulasi Penyusutan",
                6 => "Beban Air, Listrik, Dan Telepon",
                7 => "Beban Peralatan",
                8 => "Beban Administrasi"
            ];
            $thisYear = Carbon::now()->year;
            $penerimaan = IncomingCash::whereYear('paid_date', $thisYear)->get()->sum('total');
            $pengeluaran = OutgoingCash::whereYear('outgoing_date', $thisYear)->get()->sum('total');
            $allIncome = IncomingCash::all()->groupBy('acc_type')->map(function ($group) {
                return $group->sum('total');
            });
            $allOutgoing = OutgoingCash::all()->groupBy('acc_type')->map(function ($group) {
                return $group->sum('total');
            });
            return view('landing', compact('penerimaan', 'pengeluaran', 'allIncome', 'allOutgoing', 'acc_type_income', 'acc_type_outgoing'));
        }

        return redirect('/login');
    }
}
