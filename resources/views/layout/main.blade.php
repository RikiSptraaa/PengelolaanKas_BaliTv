<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
        
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


    {{-- <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script> --}}
    
    <script src="{{ asset('Admin-Lte/plugins/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('Admin-Lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('Admin-Lte/dist/js/adminlte.min.js?v=3.2.0') }}"></script>
    <script src="{{ asset('Admin-Lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    @yield('script')

    
</body>

</html>
