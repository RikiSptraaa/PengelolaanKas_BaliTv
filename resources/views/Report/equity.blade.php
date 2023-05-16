@extends('layout.main', ['title' => 'Laporan', 'subtitle' => 'Perubahan Equitas'])

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Laporan Perubahan Equitas</h3>
                </div>

                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 col-md-8 justify-content-start justify-content-sm-start d-flex">
                                <div id="example1_filter">
                                    <form action="{{ url('laporan/perubahan-equitas/cetak') }}" method="get"
                                        id="form-generate-report">
                                        <label class="mr-1">Tanggal:<input type="text" name="date" id="date" readonly
                                            class="form-control form-control-sm daterange" style="background-color: transparent" autocomplete="off" aria-controls="example1"></label>
                                        <button class="btn btn-sm btn-secondary" id="btn-show"
                                            data-url='{{  url('laporan/perubahan-equitas') }}'>
                                            Cari </button>
                                        <button type="submit" class="btn btn-sm btn-secondary" id="btn-cetak" disabled>
                                            Cetak </button>
                                </div>
                                </form>
                            </div>
                        </div>
                        <div class="row table-responsive" id="div-report">

                        </div>

                        {{-- <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                                    {!! $data->links() !!}
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#btn-show').click(function (e) {
            $(this).html('Generating Report...').attr('disabled', 'disabled');
            var date = $('#date').val();

            $.ajax({
                type: "POST",
                url: $(this).data("url"),
                data: {
                    date: date,
                    _token: "{{csrf_token()}}"
                },
                beforeSend: function () {
                    swal.fire({
                        html: '<h5>Loading...</h5>',
                        showConfirmButton: false,
                        didOpen: function () {
                            Swal.showLoading()
                            // there will only ever be one sweet alert open.
                        }
                    });
                },
                success: function (response) {
                    swal.close();
                    swal.fire({
                        title: "Success",
                        icon: "success",
                        showConfirmButton: true,
                    });
                    $('#btn-show').html('Cari').removeAttr('disabled');
                    $('#btn-cetak').removeAttr('disabled');
                    $('#div-report').hide();
                    $('#div-report').html('');
                    $('#div-report').html(response.report_view);
                    $('#div-report').show();
                    // // countTotalBalance();



                },
                error: function(error){
                    $('#btn-show').html('Cari').removeAttr('disabled');
                    $('#btn-cetak').removeAttr('disabled');
                    swal.fire({
                        title: "Error",
                        icon: "error",
                        text: error.responseJSON.message,
                        showConfirmButton: true,
                    });
                }
            });
        });
    });

</script>
@endsection
