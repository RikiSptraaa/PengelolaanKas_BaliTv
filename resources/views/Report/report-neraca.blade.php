@php
use Carbon\Carbon;
use Akaunting\Money\Currency;
use Akaunting\Money\Money;
@endphp
@if(isset($is_print))
<style>
    table{
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
    }
    th, td{
        border: 1px solid black;
        border-collapse: collapse;
    }
    td{
        padding: 10px;
    }
    .title{
        text-align: center;
    }
</style>

    
@endif
<table id="user-table" class="table table-bordered dataTable dtr-inline" aria-describedby="example1_info"
    style="overflow: scroll;">
    <thead>
        <tr>
            <td colspan="4" class="text-center font-weight-bold title"
                style="background-color: rgba(220, 220, 220, 0.477);">
                <h3>Bali TV</h3>
                <h4>Laporan Neraca<h4>
                    @php $yearMonth = $month[0].'-'.$month[1]  @endphp
                        <p>Periode Yang Berakhir Pada
                            {{ Carbon::parse($yearMonth)->translatedFormat('F Y') }}</p>
            </td>
        </tr>
        <tr class="text-center" style="background-color: rgba(220, 220, 220, 0.477);">
            <td colspan="2" style="width: 50%;">
                Aktiva
            </td>
            <td colspan="2" style="width: 50%;">
                Pasiva
            </td>
        </tr>
    </thead>
    <tbody>
        <tr style="background-color: rgba(220, 220, 220, 0.477);">
            <td colspan="2">
                Aset Lancar
            </td>
            <td colspan="2">
                Liabilitas Lancar
            </td>
        </tr>
        <tr>
            <td>Kas</td>
            <td style="width: 20%">{{  Money::IDR(collect($acc_income)->where('acc_type', 1)->sum('total'), true)   }}
            </td>
            <td>Utang Usaha</td>
            <td style="width: 20%">{{  Money::IDR(collect($acc_outgoing)->where('acc_type', 2)->sum('total'), true)   }}</td>
        </tr>
        <tr>
            <td>Pendapatan Kunjungan</td>
            <td style="width: 20%">{{  Money::IDR(collect($acc_income)->where('acc_type', 2)->sum('total'), true)   }}
            </td>
            <td>Utang Upah</td>
            <td style="width: 20%">{{  Money::IDR(collect($acc_outgoing)->where('acc_type', 3)->sum('total'), true)   }}</td>
        </tr>
        <tr>
            <td>Pendapatan Iklan</td>
            <td style="width: 20%">{{  Money::IDR(collect($acc_income)->where('acc_type', 3)->sum('total'), true)   }}
            </td>
            <td>Beban Air, Listrik, Dan Telepon</td>
            <td style="width: 20%">{{  Money::IDR(collect($acc_outgoing)->where('acc_type', 6)->sum('total'), true)   }}</td>
        </tr>
        <tr>
            <td>Perlengkapan</td>
            <td style="width: 20%">{{  Money::IDR(collect($acc_income)->where('acc_type', 4)->sum('total'), true)   }}
            </td>
            <td>Beban Usaha</td>
            <td>{{  Money::IDR(collect($acc_outgoing)->whereIn('acc_type', 1)->sum('total'), true)   }}</td>
        </tr>
        <tr>
            <td>Pendapatan Liputan</td>
            <td style="width: 20%">{{  Money::IDR(collect($acc_income)->where('acc_type', 6)->sum('total'), true)   }}
            </td>
            <td>Akumulasi Penyusutan</td>
            <td style="width: 20%">{{  Money::IDR(collect($acc_outgoing)->where('acc_type', 5)->sum('total'), true) }}</td>
            
        </tr>
        <tr >
            <td style="background-color: rgba(220, 220, 220, 0.477);">Jumlah Aktiva Lancar</td>
            <td style="background-color: rgba(220, 220, 220, 0.477);">{{ Money::IDR(collect($acc_income)->whereIn('acc_type', [1,2,3,4,6])->sum('total'), true) }}</td>
            <td>-</td>
            <td style="width: 20%">-</td>
        </tr>
        <tr>
            <td colspan="2" style="background-color: rgba(220, 220, 220, 0.477);">
                Aktiva Tetap
            </td>
            <td style="background-color: rgba(220, 220, 220, 0.477);">Jumlah Liabilitas</td>
            <td style="background-color: rgba(220, 220, 220, 0.477);"> {{ Money::IDR(collect($acc_outgoing)->whereIn('acc_type', [1,2,3,6,5])->sum('total'), true) }} </td>
                     
        </tr>
        <tr>
            <td>Peralatan</td>
            <td style="width: 20%">{{  Money::IDR(collect($acc_income)->where('acc_type', 5)->sum('total'), true)   }}
            </td>
            <td colspan="2" style="background-color: rgba(220, 220, 220, 0.477);">
                Ekuitas
            </td>
          
        </tr>
        <tr>
            <td>-</td>
            <td style="width: 20%">-
            </td>
            <td>Prive</td>
            <td style="width: 20%">{{  Money::IDR(collect($acc_outgoing)->where('acc_type', 4)->sum('total'), true)   }}</td>
           
        </tr>
        <tr style="background-color: rgba(220, 220, 220, 0.477);">
            <td>Jumlah Aktiva Tetap</td>
            <td>{{ Money::IDR(collect($acc_income)->whereIn('acc_type', [5])->sum('total'), true) }}</td>
            <td>Jumlah Ekuitas</td>
            <td> {{ Money::IDR(collect($acc_outgoing)->whereIn('acc_type', [4,5])->sum('total'), true) }} </td>
        </tr>
        <tr style="background-color:{{ isset($is_print) ? 'rgba(86, 220, 220, 0.477)' : 'rgba(220, 220, 220, 0.477)'  }};">
            <td>Total Aktiva</td>
            <td>{{ Money::IDR(collect($acc_income)->where('acc_type', '!=', 7)->sum('total'), true) }}</td>
            <td>Total Liabilitas & Ekuitas</td>
            <td> {{ Money::IDR(collect($acc_outgoing)->sum('total'), true) }} </td>
        </tr>
    </tbody>
</table>
