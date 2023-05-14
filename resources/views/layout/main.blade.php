<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <title>Bali TV</title>
    @include('templates.header')
    @yield('style-head')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        @include('templates.navbar')

        @include('templates.sidebar')



        <div class="content-wrapper">

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">{{ ucfirst($title) }}</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">{{ ucfirst($title) }}</a></li>
                                <li class="breadcrumb-item active">{{ ucfirst($subtitle) }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                @yield('content')
            </div>
        </div>

        {{-- @include('templates.footer') --}}
        <footer class="main-footer">


            <strong> &copy; 2022 <a href="https://balitv.tv/">Bali TV</a>.</strong>
        </footer>

        <aside class="control-sidebar control-sidebar-dark">

            <div class="p-3">
                <h5>{{ Auth::user()->name }}</h5>
                <p></p>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-block btn-danger">Logout</button>
                </form>
            </div>
        </aside>
    </div>


    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>

    <script src="{{ asset('Admin-Lte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('Admin-Lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>

    <script src="{{ asset('Admin-Lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('Admin-Lte/dist/js/adminlte.min.js?v=3.2.0') }}"></script>
    <script src="{{ asset('Admin-Lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('Admin-Lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('Admin-Lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('Admin-Lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('Admin-Lte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('Admin-Lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('Admin-Lte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('Admin-Lte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('Admin-Lte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnify.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
    $(document).ready(function(){     

        $('.daterange').daterangepicker({
            autoUpdateInput: false,
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        $('.daterange').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });

        $('.daterange').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
    </script>

    @yield('script')


</body>

</html>
