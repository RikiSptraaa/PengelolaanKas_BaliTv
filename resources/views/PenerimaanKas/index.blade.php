@extends('layout.main', ['title' => 'Penerimaan Kas', 'subtitle' => 'Daftar Penrimaan Kas'])

@section('style-head')
<style>
    .table-responsive {
        width: auto !important;
    }

    .del-icon:hover {
        color: rgb(195, 0, 0) !important;
    }

    .edit-icon:hover {
        color: rgb(0, 0, 195) !important;
    }

</style>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Penerimaan Kas</h3>
                </div>

                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 justify-content-start d-flex">
                                <div id="example1_filter" class="dataTables_filter ">
                                    <form action="" method="get">
                                        <label>Cari:<input type="search" name="search"
                                                class="form-control form-control-sm" placeholder=""
                                                aria-controls="example1"></label>
                                </div>
                                </form>
                            </div>
                            <div class="col-sm-12 col-md-6 justify-content-md-end mb-3 d-flex justify-content-sm-start">
                                <button class="btn btn-secondary buttons-html5" data-toggle="modal"
                                    data-target="#modal-tambah">Tambah Penerimaan Kas +</button>

                            </div>
                        </div>
                        <div class="row table-responsive">
                            <div class="col-sm-12">
                                <table id="user-table" class="table table-bordered table-striped dataTable dtr-inline"
                                    aria-describedby="example1_info" style="overflow: scroll;">
                                    <thead>
                                        <tr>
                                            <th tabindex="0" rowspan="1" colspan="1">
                                                Nomor Invoice</th>
                                            <th tabindex="0" rowspan="1" colspan="1">
                                                Client</th>
                                            <th tabindex="0" rowspan="1" colspan="1">
                                                Tanggal Bayar</th>
                                            <th tabindex="0" rowspan="1" colspan="1"
                                                aria-label="Engine version: activate to sort column ascending">
                                                Jumlah
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1"
                                                aria-label="Engine version: activate to sort column ascending">
                                                Keterangan
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1"
                                                aria-label="Engine version: activate to sort column ascending">
                                                Aksi
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $key => $value)
                                        <tr>
                                            <td>{{ $value->invoice_number }}</td>
                                            <td>{{ $value->client }}</td>
                                            <td>{{ $value->paid_date }}</td>
                                            <td>{{ $value->total }}</td>
                                            <td>{{ $value->note }}</td>
                                            <td class='d-flex justify-content-center'>
                                                <form>
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" id="invoice_number"
                                                        value="{{ $value->invoice_number }}">
                                                    <button style='border: none; background-color: transparent;'
                                                        class='delete-btn mr-2 text-center'><i style='color: red;'
                                                            class='fas fa-trash del-icon'></i></button>
                                                </form>
                                                <button class='edit-penerimaan-kas-btn margin-right text-center'
                                                    id="edit-user-btn" data-toggle="modal" data-target="#modal-update"
                                                    data-id="{{ $value->invoice_number }}"
                                                    style='border: none; background-color: transparent;'>
                                                    <i class='fas fa-edit edit-icon'
                                                        style="color: rgb(75, 111, 255);"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- Modal Tambah Data --}}
                        <div class="modal-create">
                            <div class="modal fade" id="modal-tambah" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Tambah Penerimaan Kas</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            {{-- form tambah --}}
                                            <form method="POST" id="form-tambah-penerimaan-kas">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="no-invoice">Nomor Invoice</label>
                                                    <input type="text" class="form-control" id="no-invoice"
                                                        name="nomor_invoice" placeholder="Masukan Nomor Invoice">
                                                    <div style="color: red; display: none;" class="error-no-invoice">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="client">Client</label>
                                                    <input type="text" class="form-control" id="client" name="client"
                                                        placeholder="Masukan Nama Client">
                                                    <div style="color: red; display: none;" class="error-client">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tanggal-bayar">Tanggal Bayar</label>
                                                    <input type="date" class="form-control" id="tanggal-bayar"
                                                        name="tanggal_bayar" placeholder="Masukan Tanggal Bayar">
                                                    <div style="color: red; display: none;" class="error-paid-date">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="jumlah">Jumlah</label>
                                                    <input type="text" class="form-control" id="jumlah" name="jumlah"
                                                        placeholder="Masukan Jumlah Bayar">
                                                    <div style="color: red; display: none;" class="error-jumlah">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="keterangan">Keterangan</label>
                                                    {{-- <input type="textarea" class="form-control" id="tanggal-bayar"
                                                    name="tanggal_bayar" placeholder="Masukan Nama Client"> --}}
                                                    <textarea id="keterangan" name="keterangan"
                                                        placeholder="Masukan Ketrangan" cols="50" class="form-control"
                                                        style="display: block"></textarea>
                                                    <div style="color: red; display: none;" class="error-keterangan">
                                                    </div>
                                                </div>

                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-secondary">Simpan</button>
                                            </form>
                                            {{-- endformtambah --}}
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        {{-- End Modal --}}

                        {{-- Modal Update --}}
                        <div class="modal-update">
                            <div class="modal fade" id="modal-update" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Ubah Penerimaan Kas</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            {{-- form update --}}
                                            <form method="POST" id="form-ubah-penerimaan-kas">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" name="invoice_number" id="invoice_number">
                                                <div class="form-group">
                                                    <label for="no-invoice">Nomor Invoice</label>
                                                    <input type="text" class="form-control" id="edit-no-invoice"
                                                        name="nomor_invoice" placeholder="Masukan Nomor Invoice">
                                                    <div style="color: red; display: none;"
                                                        class="error-edit-no-invoice">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="client">Client</label>
                                                    <input type="text" class="form-control" id="edit-client"
                                                        name="client" placeholder="Masukan Nama Client">
                                                    <div style="color: red; display: none;" class="error-edit-client">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tanggal-bayar">Tanggal Bayar</label>
                                                    <input type="date" class="form-control" id="edit-tanggal-bayar"
                                                        name="tanggal_bayar" placeholder="Masukan Tanggal Bayar">
                                                    <div style="color: red; display: none;"
                                                        class="error-edit-paid-date">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="jumlah">Jumlah</label>
                                                    <input type="text" class="form-control" id="edit-jumlah"
                                                        name="jumlah" placeholder="Masukan Jumlah Bayar">
                                                    <div style="color: red; display: none;" class="error-edit-jumlah">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="keterangan">Keterangan</label>
                                                    <textarea id="edit-keterangan" name="keterangan"
                                                        placeholder="Masukan Ketrangan" cols="50" class="form-control"
                                                        style="display: block"></textarea>
                                                    <div style="color: red; display: none;"
                                                        class="error-edit-keterangan">
                                                    </div>
                                                </div>

                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-secondary">Simpan</button>
                                            </form>
                                            {{-- endformubah--}}
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        {{-- End Modal --}}
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                                    {!! $data->links() !!}
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                                </div>
                            </div>
                        </div>
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
        //script show
        $('.edit-penerimaan-kas-btn').click(function (e) {
            var invoice_number = $(this).data('id');
            var token = $('meta[name="csrf-token"]').attr('content');

            e.preventDefault();
            $.ajax({
                url: `/penerimaan-kas/${invoice_number}`,
                type: "GET",
                cache: false,
                success: function (response) {

                    //fill data to form
                    // console.log(response.data.password);
                    $("input[name='_token']").val(token);
                    $('#edit-no-invoice').val(response.data.invoice_number);
                    $('#edit-client').val(response.data.client);
                    $('#edit-tanggal-bayar').val(response.data.paid_date);
                    $('#edit-jumlah').val(response.data.total);
                    $('#edit-keterangan').val(response.data.note);
                    $('#invoice_number').val(response.data.invoice_number);

                    // $('#get-username').val(response.data.username);
                    $('.error-edit-no-invoice').css('display', 'none');
                    $('.error-edit-client').css('display', 'none');
                    $('.error-edit-tanggal-bayar').css('display', 'none');
                    $('.error-edit-jumlah').css('display', 'none');
                    $('.error-edit-keterangan').css('display', 'none');
                    // $('#content-edit').val(response.data.content);


                    //open modal
                    // $('#modal-edit').modal('show');
                }
            });

        });

        //script update 
        $('#form-ubah-penerimaan-kas').submit(function (e) {
            e.preventDefault();
            var form_data = new FormData(this);


            var invoice_number = $('#invoice_number').val();
            // console.log(invoice_number);
            Swal.fire({
                title: 'Yakin Ingin Mengubah Penerimaan Kas?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ubah',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr(
                                'content'),
                            '_method': 'patch'
                        },
                        url: `penerimaan-kas/${invoice_number}`,
                        cache: false,
                        processData: false,
                        contentType: false,
                        data: form_data,
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                showCloseButton: true,
                                showCancelButton: false,
                                showConfirmButton: true,
                                confirmButtonText: 'Ok',
                                title: 'Berhasil!',
                                text: response.message,
                            }).then((result) => {
                                $("#modal-update-user").modal("hide");
                                $('.error-edit-no-invoice').css('display',
                                    'none');
                                $('.error-edit-client').css('display',
                                    'none');
                                $('.error-edit-tanggal-bayar').css(
                                    'display', 'none');
                                $('.error-edit-jumlah').css('display',
                                    'none');
                                $('.error-edit-keterangan').css('display',
                                    'none');
                            });

                        },
                        error: function (error) {
                            Swal.fire({
                                icon: 'error',
                                showCloseButton: true,
                                showCancelButton: false,
                                showConfirmButton: true,
                                confirmButtonText: 'Ok',
                                title: 'Gagal!',
                                text: error.responseJSON.message,
                            })
                            $('.error-edit-no-invoice').text(error.responseJSON
                                .nomor_invoice).css('display', '');
                            $('.error-edit-client').text(error.responseJSON
                                .client).css('display', '');
                            $('.error-edit-tanggal-bayar').text(error.responseJSON
                                .tanggal_bayar).css('display', '');
                            $('.error-edit-jumlah').text(error.responseJSON
                                .jumlah).css('display', '');
                            $('.error-edit-keterangan').text(error
                                .responseJSON
                                .keterangan).css('display', '');
                        },

                    });
                }
            });

        });



        // Script Delete Penerimaan Kas

        $('.delete-btn').click(function (e) {
            e.preventDefault();


            var invoice_number = $('#invoice_number').val();

            var token = $('meta[name="csrf-token"]').attr('content');
            Swal.fire({
                title: 'Yakin Menghapus Penerimaan Kas?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    var username = $('.get-username').val();
                    $.ajax({
                        type: "DELETE",
                        url: "penerimaan-kas/" + invoice_number,
                        data: {
                            "_token": token,
                            "_method": "DELETE",
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                showCloseButton: true,
                                showCancelButton: false,
                                showConfirmButton: true,
                                confirmButtonText: 'Ok',
                                title: 'Berhasil!',
                                text: response.message,
                            }).then((result) => {
                                location.reload();
                            })
                        }
                    });
                }
            });

        });


        // script add penerimaan kas
        $('#form-tambah-penerimaan-kas').submit(function (e) {
            e.preventDefault();
            var form_data = new FormData(this);

            Swal.fire({
                title: 'Yakin Menambah Penerimaan Kas?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Tambah',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('penerimaan-kas.store') }}",
                        cache: false,
                        processData: false,
                        contentType: false,
                        data: form_data,
                        success: function (response) {
                            console.log(response);
                            Swal.fire({
                                icon: 'success',
                                showCloseButton: true,
                                showCancelButton: false,
                                showConfirmButton: true,
                                confirmButtonText: 'Ok',
                                title: 'Berhasil!',
                                text: response.message,
                            }).then((result) => {
                                $("#modal-tambah").modal("hide");
                                location.reload()
                            });

                        },
                        error: function (error) {
                            Swal.fire(
                                'Kesalahan!',
                                'Penerimaan Kas gagal ditambah!',
                                'error',
                            )
                            // console.log(error);
                            $('.error-no-invoice').text(error.responseJSON
                                .nomor_invoice).css('display', '');
                            $('.error-client').text(error.responseJSON
                                .client).css('display', '');
                            $('.error-paid-date').text(error.responseJSON
                                .tanggal_bayar).css('display', '');
                            $('.error-jumlah').text(error.responseJSON
                                .jumlah).css('display', '');
                            $('.error-keterangan').text(error.responseJSON
                                .keterangan).css('display', '');
                            // $('#error-image').css('display', '');
                        },
                    });

                }
            })



        });
    });

</script>
@endsection
