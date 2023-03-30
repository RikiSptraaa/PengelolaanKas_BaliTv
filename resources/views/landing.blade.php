@extends('layout.main', ['title' => 'Homepage', 'subtitle' => 'Landing'])

@section('content')

<div style="display: flex; justify-content: center;">
    <img src="{{ asset('storage/img/bali-tv.png') }}" style="width: 200px; height: 200px;">
</div>

<div class="container">
    <div class="row">
        <div class="col-6">
            <canvas id="canvas-month"></canvas>
        </div>
        <div class="col-6">
            <canvas id="canvas-day"></canvas>
        </div>
        {{-- <h1 class="text-center">ASDASDSADASDSA</h1> --}}
        {{-- <h1>ASDASDSADASDSA</h1>
        <h1>ASDASDSADASDSA</h1> --}}
    </div>
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
<script>
    const penerimaan = {{ $penerimaan }};
    const penerimaanDay = {{ $penerimaanDaily }};
    const pengeluaran = {{ $pengeluaran }};
    const pengeluaranDay = {{ $pengeluaranDaily }};

    const ctx = document.getElementById('canvas-month');
    const ctx2 = document.getElementById('canvas-day');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Penerimaan & Pengeluaran Kas Bulanan'],
            datasets: [{
                label: 'Penerimaan Kas Bulan Ini',
                data: [penerimaan],
                borderWidth: 1,
            },
            {
                label: 'Pengeluaran Kas Bulan Ini',
                data: [pengeluaran],
                borderWidth: 1,
            } 
        ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Penerimaan & Pengeluaran Kas Harian'],
            datasets: [{
                label: 'Penerimaan Kas Hari Ini',
                data: [penerimaanDay],
                borderWidth: 1,
            },
            {
                label: 'Pengeluaran Kas Hari Ini',
                data: [pengeluaranDay],
                borderWidth: 1,
            } 
        ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

</script>
@endsection
