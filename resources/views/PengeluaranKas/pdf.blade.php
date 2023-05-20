<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        td {
            padding: 10px;
        }

        .title {
            text-align: center;
        }

    </style>
</head>

@php
use Carbon\Carbon;
use Akaunting\Money\Currency;
use Akaunting\Money\Money;
$acc_type = [
1 => "Beban Sewa",
2 => "Utang Usaha",
3 => "Utang Upah",
4 => "Prive",
5 => "Akumulasi Penyusutan",
6 => "Beban Air, Listrik, Dan Telepon",
7 => "Beban Peralatan",
8 => "Beban Administrasi",
9 => "Beban Lain-Lain",
10 => 'Beban Konsumsi'
]
@endphp

<body>
    <table>
        <thead>
            <tr>
                <td colspan="6" class="text-center font-weight-bold title"
                    style="background-color: rgba(220, 220, 220, 0.477);">
                    <h3>Bali TV</h3>
                    <h4>Pengeluaran Kas<h4>
                </td>
            </tr>
            <tr class="text-center" style="background-color: rgba(220, 220, 220, 0.477);">
                <td>
                    Nomor Nota
                </td>
                <td>
                    Jenis Akun
                </td>
                <td tabindex="0" rowspan="1" colspan="1">
                    Deskripsi</td>
                <td>
                    Tanggal Pengeluaran
                </td>
                <td>
                    Jumlah
                </td>
                <td>
                    Keterangan
                </td>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $value)
            <tr>
                <td>{{ $value['note_number'] }}</td>
                <td>{{ $acc_type[$value['acc_type']]  }}</td>
                <td>{{ $value['description'] }}</td>
                <td>{{ Carbon::parse($value['outgoing_date'])->dayName .', ' .Carbon::parse($value['outgoing_date'])->translatedFormat('d F Y')  }}</td>
                <td>{{ Money::IDR($value['total'], true) }}</td>
                <td>{{ $value['note'] }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
              <td colspan="4" class="text-right text-bold">Total</td>
              <td colspan="2"> @money($total, 'IDR', true)</td>
            </tr>
        </tfoot>
    </table>

</body>

</html>
