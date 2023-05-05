@php
    use Carbon\Carbon;
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
<div class="col-sm-12">
    <table id="user-table" class="table table-bordered dataTable dtr-inline"
        aria-describedby="example1_info" style="overflow: scroll;">
        <thead>
            <tr>
                <td colspan="2" class="text-center font-weight-bold title" style="background-color: rgba(220, 220, 220, 0.477)">
                    <h3>Bali TV</h3>
                    <h4>Laporan Perubahan Equitas<h4>
                        @php $yearMonth = $month[0].'-'.$month[1]  @endphp
                        <p>Periode Yang Berakhir Pada {{ Carbon::parse($yearMonth)->translatedFormat('F Y') }}</p>
                    {{-- <p>Periode Yang Berakhir Pada {{Carbon::parse($date)->format('F Y') }}</p> --}}
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="background-color: rgba(220, 220, 220, 0.477); border: none;">
                    Modal Awal
                </td>
                @php
                    use Akaunting\Money\Currency;
                    use Akaunting\Money\Money;
                    $modal_awal = collect($acc_income)->whereIn('acc_type', [1,2] )->sum('total') ?? 0;
                    // $pendapatan = collect($acc_income)->where('acc_type', 2)->sum('total') ?? 0;
                    $prive = collect($acc_outgoing)->where('acc_type', 4)->sum('total');    
                    // $laba = $pendapatan - $beban;
                    $penambahan_modal = $laba_bersih-$prive;
                    $modal_akhir = $modal_awal + $penambahan_modal;
                
                @endphp
                <td style="background-color: rgba(220, 220, 220, 0.477); border: none; ">
                    {{ Money::IDR($modal_awal, true) }}

                </td>
            </tr>
            <tr>
                <td>
                    Laba Bersih
                </td>
                <td>
                    {{ Money::IDR($laba_bersih, true) }}
                </td>

            </tr>
            <tr>
                <td>
                    Prive
                </td>
                <td>
                    {{ Money::IDR($prive, true) }}
                </td>

            </tr>
            <tr>
                <td>Penambahan Modal</td>
                <td> {{ Money::IDR($penambahan_modal, true) }}</td>
            </tr>
            <tr>
                <td style="background-color:{{ isset($is_print) ? 'rgba(86, 220, 220, 0.477)' : 'rgba(220, 220, 220, 0.477)'  }}">Modal Akhir</td>
                <td style="background-color:{{ isset($is_print) ? 'rgba(86, 220, 220, 0.477)' : 'rgba(220, 220, 220, 0.477)'  }}">{{  Money::IDR($modal_akhir, true) }}</td>
            </tr>
        </tbody>
    </table>
</div>
