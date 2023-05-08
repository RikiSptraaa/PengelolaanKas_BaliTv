@extends('layout.main', ['title' => 'Pengguna', 'subtitle' => 'Daftar Pengguna'])

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
                    <h3 class="card-title">Data Pengguna</h3>
                </div>

                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 justify-content-start d-flex">
                                <div id="example1_filter" class="dataTables_filter ">
                                    <form action="" method="get">
                                        <label>Cari:<input type="search" name="search"
                                            class="form-control form-control-sm" placeholder=""
                                            aria-controls="example1"></label></div>
                                    </form>
                            </div>
                            <div class="col-sm-12 col-md-6 justify-content-md-end mb-3 d-flex justify-content-sm-start">
                                <button class="btn btn-secondary buttons-html5" data-toggle="modal"
                                    data-target="#modal-add-user">Tambah User +</button>
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
                                                <form method="post" id="add-user-form" action="">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="name">Nama</label>
                                                        <input type="text" class="form-control" id="name" name="name"
                                                            placeholder="Masukan Nama">
                                                        <div style="color: red; display: none;" class="error-name">

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="username">Username</label>
                                                        <input type="text" class="form-control" id="username"
                                                            name="username" placeholder="Masukan Username">
                                                        <div style="color: red; display: none;" class="error-username">

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password">Kata Sandi</label>
                                                        <input type="password" class="form-control" id="password"
                                                            name="password" placeholder="Masukan Password / Kata Sandi">
                                                        <div style="color: red; display: none;" class="error-password">

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                                                        <input type="password" class="form-control"
                                                            id="password_confirmation" name="password_confirmation"
                                                            placeholder="Masukan Kata Sandi Kembali">
                                                        <div style="color: red; display: none;"
                                                            class="error-password-confirm">

                                                        </div>
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
                                <table id="user-table" class="table table-bordered table-striped dataTable dtr-inline"
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
                                                Super Admin
                                            </th>
                                            <th tabindex="0" rowspan="1" colspan="1"
                                                aria-label="Engine version: activate to sort column ascending">
                                                Aksi
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php

                                        $no = 1;
                                        @endphp
                                        @foreach ($users as $key => $user)

                                        <tr class='odd'>
                                            <td>{{ $users->firstItem() + $key }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>
                                                {{ $user->is_super_admin == 1 ? "Ya" : "Tidak" }}


                                            </td>
                                            <td class='d-flex justify-content-center'>
                                                <form id='delete-user-form-{{ $user->username }}'>
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" class="get-username"
                                                        value="{{ $user->username }}">
                                                    <button style='border: none; background-color: transparent;'
                                                        class='delete-user-btn mr-2 text-center'><i style='color: red;'
                                                            class='fas fa-trash del-icon'></i></button>
                                                </form>
                                                <button class='edit-user-btn margin-right text-center'
                                                    id="edit-user-btn" data-toggle="modal"
                                                    data-target="#modal-update-user" data-id="{{ $user->username }}"
                                                    style='border: none; background-color: transparent;'>
                                                    <i class='fas fa-edit edit-icon'
                                                        style="color: rgb(75, 111, 255);"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="modal fade" id="modal-update-user" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"> Tambah
                                                    User </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" id="edit-user-form" class="edit-user-form"
                                                    action="">
                                                    @csrf
                                                    @method('put')
                                                    <input type="hidden" id="get-username" class="get-edit-username"
                                                        value="">
                                                    <div class="form-group">
                                                        <label for="edit-name">Nama</label>
                                                        <input type="text" class="form-control" id="edit-name"
                                                            name="name" placeholder="Masukan Nama">
                                                        <div style="color: red; display: none;" class="error-edit-name">

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="edit-username">Username</label>
                                                        <input type="text" class="form-control" id="edit-username"
                                                            name="username" placeholder="Masukan Username">
                                                        <div style="color: red; display: none;"
                                                            class="error-edit-username">

                                                        </div>
                                                    </div>

                                                    <button type="button" class="btn btn-sm btn-outline-secondary mb-2" 
                                                        data-toggle="collapse" data-target="#demo">Ubah Password <i
                                                            class="fas fa-caret-down"></i></button>
                                                    <div id="demo" class="collapse">
                                                        <div class="change-password">
                                                            <div class="form-group">
                                                                <label for="edit-old-password">Kata Sandi Lama</label>
                                                                <input type="password" class="form-control"
                                                                    id="edit-old-password" name="old_password"
                                                                    placeholder="Masukan Kata Sandi Lama">
                                                                <div style="color: red; display: none;"
                                                                    class="error-edit-old-password">

                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="password">Kata Sandi Baru</label>
                                                                <input type="password" class="form-control"
                                                                    id="edit-password" name="password"
                                                                    placeholder="Masukan Password / Kata Sandi">
                                                                <div style="color: red; display: none;"
                                                                    class="error-edit-password">

                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="password_confirmation">Konfirmasi
                                                                    Kata Sandi Baru</label>
                                                                <input type="password" class="form-control"
                                                                    id="edit-password_confirmation"
                                                                    name="password_confirmation"
                                                                    placeholder="Masukan Kata Sandi Kembali">
                                                                <div style="color: red; display: none;"
                                                                    class="error-edit-password-confirm">

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    {{-- <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="change_passwd" value="0"
                                                            id="check-password">
                                                        <button id="check-password" class="btn btn-secondary">Ubah Password</button>
                                                        <label class="form-check-label" for="check-password">
                                                            Ubah Password</label>
                                                    </div> --}}




                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" id="update-user-btn"
                                                    class="btn btn-secondary">Simpan Perubahan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        $('.edit-user-btn').click(function (e) {
            var username = $(this).data('id');
            var token = $('meta[name="csrf-token"]').attr('content');

            e.preventDefault();
            $.ajax({
                url: `/users/${username}`,
                type: "GET",
                cache: false,
                success: function (response) {

                    //fill data to form
                    // console.log(response.data.password);
                    $("input[name='_token']").val(token);
                    $('#edit-name').val(response.data.name);
                    $('#edit-username').val(response.data.username);
                    $('#get-username').val(response.data.username);
                    $('.error-edit-name').css('display', 'none');
                    $('.error-edit-username').css('display', 'none');
                    $('.error-edit-old-password').css('display', 'none');
                    $('.error-edit-password').css('display', 'none');
                    $('.error-edit-password-confirm').css('display', 'none');
                    // $('#content-edit').val(response.data.content);


                    //open modal
                    // $('#modal-edit').modal('show');
                }
            });

        });



        $('.delete-user-btn').click(function (e) {
            e.preventDefault();
            // console.log('abc');
            // var form_data = new FormData(this);

            var token = $('meta[name="csrf-token"]').attr('content');
            Swal.fire({
                title: 'Yakin Menghapus Pengguna?',
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
                        type: "POST",
                        url: "users/" + username,
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
                                text: 'Pengguna Berhasil Dihapus',
                            }).then((result) => {
                                location.reload();
                            })
                        }
                    });
                }
            });

        });

        $('.edit-user-form').submit(function (e) {
            e.preventDefault();
            var form_data = new FormData(this);
            var username2 = $('.get-edit-username').val();

            Swal.fire({
                title: 'Yakin Ingin Mengubah Pengguna?',
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
                        url: `users/${username2}`,
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
                                // $("#modal-update-user").modal("hide");
                                $('.error-name').hide();
                                $('.error-username').hide();
                                $('.error-old-password').hide();
                                $('.error-password').hide();
                                $('.error-password-confirm').hide();
                                location.reload()
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
                            $('.error-edit-name').text(error.responseJSON
                                .name).css('display', '');
                            $('.error-edit-username').text(error.responseJSON
                                .username).css('display', '');
                            $('.error-edit-old-password').text(error.responseJSON
                                .old_password).css('display', '');
                            $('.error-edit-password').text(error.responseJSON
                                .password).css('display', '');
                            $('.error-edit-password-confirm').text(error
                                .responseJSON
                                .password_confirmation).css('display', '');
                        },

                    });
                }
            });
        });

        $('#add-user-form').submit(function (e) {
            e.preventDefault();
            var form_data = new FormData(this);

            Swal.fire({
                title: 'Yakin Menambah Pengguna?',
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
                        url: "{{ route('users.store') }}",
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
                                text: 'Pengguna berhasil ditambah',
                            }).then((result) => {
                                // $("#modal-add-user").modal("hide");
                                location.reload()
                            });

                        },
                        error: function (error) {
                            Swal.fire(
                                'Gagal!',
                                'Pengguna gagal ditambah!',
                                'error',
                            )
                            // console.log(error);
                            $('.error-name').text(error.responseJSON
                                .name).css('display', '');
                            $('.error-username').text(error.responseJSON
                                .username).css('display', '');
                            $('.error-password').text(error.responseJSON
                                .password).css('display', '');
                            $('.error-password-confirm').text(error.responseJSON
                                .password_confirmation).css('display', '');
                            // $('#error-image').css('display', '');
                        },
                    });

                }
            })



        });
    });

</script>
@endsection
{{-- ajax --}}
