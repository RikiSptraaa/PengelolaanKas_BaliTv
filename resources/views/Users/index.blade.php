@extends('layout.main', ['title' => 'Users', 'subtitle' => 'User List'])

@section('style-head')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
    .table-responsive {
        width: auto !important;
    }

</style>
@endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data User</h3>
                </div>

                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 justify-content-start d-flex">
                                <div id="example1_filter" class="dataTables_filter "><label>Cari:<input type="search"
                                            class="form-control form-control-sm" placeholder=""
                                            aria-controls="example1"></label></div>
                            </div>
                            <div class="col-sm-12 col-md-6 justify-content-md-end d-flex justify-content-sm-start">
                                <button class="btn btn-secondary buttons-html5" data-toggle="modal"
                                    data-target="#modal-add-user">Tambah User +</button>
                                {{-- <div class="dt-buttons btn-group flex-wrap"> <button
                                        class="btn btn-secondary buttons-copy buttons-html5 " tabindex="0"
                                        aria-controls="example1" type="button"><span>Copy</span></button> <button
                                        class="btn btn-secondary buttons-csv buttons-html5" tabindex="0"
                                        aria-controls="example1" type="button"><span>CSV</span></button> <button
                                        class="btn btn-secondary buttons-excel buttons-html5" tabindex="0"
                                        aria-controls="example1" type="button"><span>Excel</span></button> <button
                                        class="btn btn-secondary buttons-pdf buttons-html5" tabindex="0"
                                        aria-controls="example1" type="button"><span>PDF</span></button> <button
                                        class="btn btn-secondary buttons-print" tabindex="0" aria-controls="example1"
                                        type="button"><span>Print</span></button>
                                </div> --}}
                                <div class="modal fade" id="modal-add-user" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"> Tambah User </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" id="add-user-form">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="name">Nama</label>
                                                        <input type="text" class="form-control" id="name" name="name"
                                                            placeholder="Masukan Nama">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="username">Username</label>
                                                        <input type="text" class="form-control" id="username"
                                                            name="username" placeholder="Masukan Username">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password">Kata Sandi</label>
                                                        <input type="password" class="form-control" id="password"
                                                            name="password" placeholder="Masukan Password / Kata Sandi">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                                                        <input type="password" class="form-control"
                                                            id="password_confirmation" name="password_confirmation"
                                                            placeholder="Masukan Kata Sandi Kembali">
                                                    </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" id="add-user-btn"
                                                    class="btn btn-secondary">Simpan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row table-responsive">
                            <div class="col-sm-12">
                                <table id="example1" class="table table-bordered table-striped dataTable dtr-inline"
                                    aria-describedby="example1_info" style="overflow: scroll;">
                                    <thead>
                                        <tr>
                                            <th tabindex="0" rowspan="1" colspan="1">
                                                No</th>
                                            <th tabindex="0" rowspan="1" colspan="1">
                                                Nama</th>
                                            <th tabindex="0" rowspan="1" colspan="1">
                                                Nama Pengguna</th>
                                            <th tabindex="0" rowspan="1" colspan="1"
                                                aria-label="Engine version: activate to sort column ascending">
                                                SuperAdmin
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php

                                        $no = 1;
                                        @endphp
                                        @foreach ($users as $user)
                                        <tr class="odd">
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ 'isadmin' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">

                                    {!! $users->links() !!}
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">

                                <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                                    {{-- <ul class="pagination">
                                        <li class="paginate_button page-item previous disabled" id="example1_previous">
                                            <a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0"
                                                class="page-link">Previous</a></li>
                                        <li class="paginate_button page-item active"><a href="#"
                                                aria-controls="example1" data-dt-idx="1" tabindex="0"
                                                class="page-link">1</a></li>
                                        <li class="paginate_button page-item "><a href="#" aria-controls="example1"
                                                data-dt-idx="2" tabindex="0" class="page-link">2</a></li>
                                        <li class="paginate_button page-item "><a href="#" aria-controls="example1"
                                                data-dt-idx="3" tabindex="0" class="page-link">3</a></li>
                                        <li class="paginate_button page-item "><a href="#" aria-controls="example1"
                                                data-dt-idx="4" tabindex="0" class="page-link">4</a></li>
                                        <li class="paginate_button page-item "><a href="#" aria-controls="example1"
                                                data-dt-idx="5" tabindex="0" class="page-link">5</a></li>
                                        <li class="paginate_button page-item "><a href="#" aria-controls="example1"
                                                data-dt-idx="6" tabindex="0" class="page-link">6</a></li>
                                        <li class="paginate_button page-item next" id="example1_next"><a href="#"
                                                aria-controls="example1" data-dt-idx="7" tabindex="0"
                                                class="page-link">Next</a></li>
                                    </ul> --}}
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
        // $('#add-user-btn').click(function (e) {
        //     console.log('abc');
        //     Swal.fire('Any fool can use a computer');
        // })
        $('#add-user-btn').click(function (e) {
            e.preventDefault();
            let name = $('#name').val();
            let username = $('#username').val();
            let password = $('#password').val();
            let password_confirmation = $('#password_confirmation').val();
            let company_address = $('#alamat').val();
            let token = $("meta[name='csrf-token']").attr("content");
            // var form_data = new FormData(this);
            // console.log(name);
          
            Swal.fire({
                title: 'Yakin Menambah Pengguna?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Tambah'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                type: "POST",
                url: "{{ route('users.store') }}",
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: {
                    "name": name,
                    "username": username,
                    "password": password,
                    "password_confirmation": password_confirmation,
                },
                cache: false,
           
                success: function (response) {
                    Swal.fire(
                        'Berhasil!',
                        'Data Berhasil Ditambah',
                        'success'
                    )
                    $("#modal-add-user").modal("hide");

                    // resolve(response);
                },
                error: function (error) {
                    Swal.fire(
                        'Failed!',
                        'Data gagal ditambah!',
                        'error'
                    )
                    // console.log(error);
                    // $('#error-image').text(error.responseJSON
                    //     .struktur_organisasi);
                    // $('#error-image').css('display', '');


                    // resolve(error);
                },
            });

                }
            })
            // swal.fire({
            //     title: "Apakah Yakin Menambahkan Data?",
            //     icon: "warning",
            //     showCancelButton: true,
            //     confirmButtonColor: "#DD6B55",
            //     confirmButtonText: "Ubah",
            //     showLoaderOnConfirm: true,
            //     cancelButtonText: "Batal",
            //     preConfirm: function () {
            //         return new Promise(function (resolve) {
            //             $.ajax({
            //                 type: "POST",
            //                 url: "{{ route('users.store') }}",
            //                 cache: false,
            //                 data: form_data,
            //                 cache: false,
            //                 contentType: false,
            //                 processData: false,
            //                 success: function (response) {
            //                     $("#modal-add-user").modal("hide");

            //                     resolve(response);
            //                 },
            //                 error: function (error) {
            //                     // console.log(error);
            //                     // $('#error-image').text(error.responseJSON
            //                     //     .struktur_organisasi);
            //                     // $('#error-image').css('display', '');


            //                     resolve(error);
            //                 },
            //             });

            //         });

            //     }
            // }).then((result) => {
            //     var data = result.value;
            //     console.log(data);
            //     if (typeof data === 'object') {
            //         if (data.status) {
            //             swal(data.message, '', 'success');
            //         } else {
            //             swal(data.message, '', 'error');
            //         }
            //     }
            // });


        });
    });

</script>
@endsection
{{-- ajax --}}
