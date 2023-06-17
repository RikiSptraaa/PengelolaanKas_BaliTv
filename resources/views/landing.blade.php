@extends('layout.main', ['title' => 'Homepage', 'subtitle' => 'Landing'])

@section('content')


<div style="display: flex; justify-content: center;">
    <img src="{{ asset('storage/img/bali-tv.png') }}" style="width: 200px; height: 200px;">
</div>

<div class="row">
    <div class="container">
    </div>
</div>

<div class="row">
    <div class="col-7">    
        <div class="container">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Grafik Laporan Tahunan</h3>
                </div>
        
                <div class="card-body d-flex justify-content-center">        
                    <canvas id="canvas-year" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>  
        <div class="container">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Penerimaan</h3>
                </div>
        
                <div class="card-body d-flex justify-content-center">   
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr >
                                    <th colspan="2" class="text-center">Penerimaan Kas</th>
                                </tr>
                                <tr>
                                    <th>Akun</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allIncome as $key => $value)
                                <tr>
                                    <td>{{ $acc_type_income[$key] }}</td>
                                    <td>@money($value, 'IDR', true)</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                            
                    </div>     
                </div>
            </div>
        </div>  
    </div>
    <div class="col-5">
        <div class="container">
            <div class="card card-widget widget-user-2 shadow-sm">
                <div class="widget-user-header bg-secondary">
                    <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="{{ asset('img/blank-pfp.webp') }}" alt="User Avatar">
                    </div>
                    <small class="m-2">Selamat Datang Kembali,</small>
                    <h3 class="widget-user-username">{{ Auth::user()->name }}</h3>
                    <h5 class="widget-user-desc">{{ Auth::user()->is_super_admin ? 'Kasir' : 'Pimpinan' }}</h5>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Pengeluaran</h3>
                </div>
        
                <div class="card-body d-flex justify-content-center">   
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr >
                                    <th colspan="2" class="text-center">Pengeluaran Kas</th>
                                </tr>
                                <tr>
                                    <th>Akun</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allOutgoing as $key => $value)
                                <tr>
                                    <td>{{ $acc_type_outgoing[$key] }}</td>
                                    <td>@money($value, 'IDR', true)</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                            
                    </div>     
                </div>
            </div>
        </div>  
        <div class="container">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Kasbon</h3>
                </div>
        
                <div class="card-body d-flex justify-content-center">   
                    <ul>
                        <li>Kasbon BBM</li>
                        <li>Kasbon Konsumsi</li>
                    </ul>
                                         
                </div>
            </div>
        </div>  
       
    </div>
</div>

<div class="row">
    <div class="col-6">
 
    </div>
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
<script>
    const penerimaan = {{ $penerimaan }};
    const pengeluaran = {{ $pengeluaran }};

    const ctx = document.getElementById('canvas-year');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Penerimaan & Pengeluaran Kas Tahunan'],
            datasets: [{
                    label: 'Penerimaan Kas Tahun Ini',
                    data: [penerimaan],
                    borderWidth: 0,
                    backgroundColor: '#007bff'
                },
                {
                    label: 'Pengeluaran Kas Tahun Ini',
                    data: [pengeluaran],
                    borderWidth: 0,
                    backgroundColor: '#6c757d'


                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            barPercentage: 0.9, // set the width of the bars
            categoryPercentage:0.3, // set the width of the bars
        }
});
</script>
@endsection
