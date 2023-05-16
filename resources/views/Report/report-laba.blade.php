@php
    use Carbon\Carbon;
    use Akaunting\Money\Currency;
    use Akaunting\Money\Money;

    $pendapatan = collect($acc_income)->whereIn('acc_type', [2,3,6])->sum('total') ?? 0;
    $beban = collect($acc_outgoing)->whereIn('acc_type', [1,6,7,8])->sum('total') ?? 0;                 
    $laba = $pendapatan - $beban;
@endphp
@if(isset($is_print))
<style>
    table{
        width: 100%;
        border: 1px solid black;
        background:  rgba(220, 220, 220, 0.477);
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
                    <h4>Laporan Laba / Rugi<h4>
                        <p>Periode {{ Carbon::parse($startDate)->translatedFormat('D, d F Y') . ' - ' . Carbon::parse($endDate)->translatedFormat('D, d F Y') }}</p>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2" style="background-color: rgba(220, 220, 220, 0.477)">Pendapatan :</td>
            </tr>
            @foreach( collect($acc_income)->whereIn('acc_type', [2,3,6])->toArray() as $key => $value)
            <tr>
                <td>
                    {{ '('.$value['invoice_number'].') ' . $value['note'] }}
                </td>
                <td>
                    {{ Money::IDR($value['total'], true) }}
                </td>

            </tr>
            @endforeach

            <tr>
                <td style="background-color: {{ isset($is_print) ? 'rgba(86, 220, 220, 0.477)' : 'rgba(220, 220, 220, 0.477)'  }}">
                    Total Pendapatan
                </td>
                <td style="background-color: {{ isset($is_print) ? 'rgba(86, 220, 220, 0.477)' : 'rgba(220, 220, 220, 0.477)'  }}">
                    {{ Money::IDR($pendapatan, true) }}

                </td>
            </tr>
            <tr>
                <td colspan="2" style="background-color: rgba(220, 220, 220, 0.477)">Beban :</td>
            </tr>
            @foreach( collect($acc_outgoing)->whereIn('acc_type', [1,6, 7, 8])->toArray() as $key => $value)
            <tr>
                <td>
                    {{ '('.$value['note_number'].') ' . $value['note'] }}
                </td>
                <td>
                    {{ Money::IDR($value['total'], true) }}
                </td>

            </tr>
            @endforeach
            <tr>
                <td style="background-color: {{ isset($is_print) ? 'rgba(86, 220, 220, 0.477)' : 'rgba(220, 220, 220, 0.477)'  }}">Total Beban</td>
                <td style="background-color: {{ isset($is_print) ? 'rgba(86, 220, 220, 0.477)' : 'rgba(220, 220, 220, 0.477)'  }}"> {{ Money::IDR($beban, true) }}</td>
            </tr>
            <tr>
                <td style="background-color: {{ isset($is_print) ? 'rgba(86, 220, 220, 0.477)' : 'rgba(220, 220, 220, 0.477)'  }}">Laba Bersih</td>
                <td style="background-color: {{ isset($is_print) ? 'rgba(86, 220, 220, 0.477)' : 'rgba(220, 220, 220, 0.477)'  }}">{{  Money::IDR($laba, true) }}</td>
            </tr>
        </tbody>
    </table>
</div>
