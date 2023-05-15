@extends('layout.main', ['title' => 'Pengeluaran Kas', 'subtitle' => 'Daftar Pengeluaran Kas'])

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
@php
use Carbon\Carbon;

$acc_type = [
1 => "Beban Sewa",
2 => "Utang Usaha",
3 => "Utang Upah",
4 => "Prive",
5 => "Akumulasi Penyusutan",
6 => "Beban Air, Listrik, Dan Telepon",
7 => "Beban Peralatan",
8 => "Beban Administrasi"
]
@endphp

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pengeluaran Kas</h3>
                </div>

                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 col-md-9 justify-content-start justify-content-sm-start d-flex">
                                <div id="example1_filter">
                                    <form action="" method="get" id="form-cari">
                                        <label class="mr-1">Jenis Akun:
                                            <select type="select" name="acc_type" class="form-control form-control-sm" id="acc_type"
                                                aria-controls="example1">
                                                <option disabled selected>Pilih Jenis Akun</option>
                                                @foreach($acc_type as $key => $value)
                                                <option {{ request('acc_type') == $key ? 'selected': '' }}
                                                    value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label class="mr-1">Tanggal:<input type="text" name="date" id="date" readonly
                                            value="{{ request()->date ? request()->date : null }}"
                                            class="form-control form-control-sm daterange" style="background-color: transparent" autocomplete="off" aria-controls="example1"></label>

                                        <br>
                                        <button type="submit" class="btn btn-sm btn-secondary">Cari</button>
                                        <button id="btn-cetak" class="btn btn-sm btn-secondary">Cetak</button>
                                        {{-- <a href="{{ route('pengeluaran-kas.print') }}" class="btn btn-sm
                                        btn-secondary">Cetak</a> --}}
                                </div>
                                </form>
                            </div>
                            <div
                                class="mt-2 col-sm-12 col-md-3 justify-content-md-end d-flex justify-content-sm-start align-items-center">
                                @if($user->is_super_admin == 1)
                                <button class="btn btn-secondary buttons-html5" data-toggle="modal"
                                data-target="#modal-tambah">Tambah Pengeluaran Kas +</button>
                                @endif

                            </div>
                        </div>
                        <div class="row table-responsive">
                            <div class="col-sm-12">
                                <table id="user-table" class="table table-bordered table-striped dataTable dtr-inline"
                                    aria-describedby="example1_info" style="overflow: scroll;">
                                    <thead>
                                        <tr>
                                            <th tabindex="0" rowspan="1" colspan="1">
                                                No. Nota</th>
                                            <th tabindex="0" rowspan="1" colspan="1">
                                                Jenis Akun</th>
                                            <th tabindex="0" rowspan="1" colspan="1">
                                                Deskripsi</th>
                                            <th tabindex="0" rowspan="1" colspan="1"
                                                aria-label="Engine version: activate to sort column ascending">
                                                Tanggal Pengeluaran
                                            </th>
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
                                                Bukti
                                            </th>

                                            <th tabindex="0" rowspan="1" colspan="1"
                                                aria-label="Engine version: activate to sort column ascending">
                                                aksi
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($data as $key => $value)
                                        <tr>
                                            <td>{{ $value->note_number }}</td>
                                            <td>{{ $acc_type[$value->acc_type] }}</td>
                                            <td>{{ $value->description }}</td>
                                            <td>{{  Carbon::parse($value->outgoing_date)->dayName .', ' .Carbon::parse($value->outgoing_date)->translatedFormat('d F Y') }}
                                            </td>
                                            <td> @money($value->total, 'IDR', true)</td>
                                            <td>{{ $value->note }}</td>
                                            <td>
                                                @php
                                                    $fileExt = explode(".", $value->file);
                                                @endphp
                                                @if($fileExt[1] != 'pdf') 
                                                <div class="text-center">
                                                    <a data-magnify="gallery" data-src="" data-caption="Bukti" href="{{ asset('bukti').'/'.$value->file }}">
                                                        <img src="{{ asset('bukti').'/'.$value->file }}" class="rounded img-thumbnail" alt="Bukti" onclick="openFile({{ asset('bukti').'/'.$value->file }})">
                                                    </a>
                                                </div>
                                                @else
                                                <div class="text-center">
                                                    <a href="{{ asset('bukti').'/'.$value->file }}" target="_blank">
                                                        <button class="btn btn-sm btn-secondary">
                                                            Perlihatkan File
                                                        </button>
                                                    </a>
                                                </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <form>
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" id="nomor_nota"
                                                            value="{{ $value->note_number }}">
                                                        <button style='border: none; background-color: transparent;'
                                                            class='delete-btn mr-2 text-center'
                                                            data-id="{{ $value->note_number }}"><i style='color: red;'
                                                                class='fas fa-trash del-icon'></i></button>
                                                    </form>
                                                    <button class='edit-pengeluaran-kas-btn margin-right text-center'
                                                        id="edit-btn" data-toggle="modal" data-target="#modal-update"
                                                        data-id="{{ $value->note_number }}"
                                                        style='border: none; background-color: transparent;'>
                                                        <i class='fas fa-edit edit-icon'
                                                            style="color: rgb(75, 111, 255);"></i>
                                                    </button>
                                                    <a id="btn-download" data-toggle="tooltip" data-placement="top" title="Download/Unduh Bukti" class='margin-right text-center' href="{{ asset('bukti').'/'.$value->file }}" download > <i class='fas fa-download edit-icon'
                                                    style="color: rgb(75, 111, 255);"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                          <td colspan="4" class="text-right text-bold">Total</td>
                                          <td colspan="4"> @money($totalPerPage, 'IDR', true)</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        {{-- Modal Tambah Data --}}
                        <div class="modal-create">
                            <div class="modal fade" id="modal-tambah" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Tambah Pengeluaran Kas</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            {{-- form tambah --}}
                                            <form method="POST" id="form-tambah-pengeluaran-kas">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="no-nota">Nomor Nota</label>
                                                    <input type="text" class="form-control" id="no-nota"
                                                        name="nomor_nota" placeholder="Masukan Nomor Nota">
                                                    <div style="color: red; display: none;" class="error-no-nota">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="acc-type">Tipe Akun</label>
                                                    <select class="form-control" name="acc_type" id="acc-type">
                                                        @foreach($acc_type as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div style="color: red; display: none;" class="error-acc-type">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Deskripsi</label>
                                                    <input type="text" class="form-control" id="description"
                                                        name="description" placeholder="Masukan Deskripsi">
                                                    <div style="color: red; display: none;" class="error-description">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tanggal-pengeluaran">Tanggal Pengeluaran</label>
                                                    <input type="date" class="form-control" id="tanggal-pengeluaran"
                                                        name="tanggal_pengeluaran"
                                                        placeholder="Masukan Tanggal Pengeluaran">
                                                    <div style="color: red; display: none;" class="error-tanggal">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="jumlah">Jumlah</label>
                                                    <input type="text" class="form-control" id="jumlah" name="jumlah"
                                                        placeholder="Masukan Jumlah">
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
                                                <div class="form-group">
                                                    <label for="bukti_pengeluaran">Bukti</label>

                                                    <input type="file" name="bukti_pengeluaran" class="form-control h-100" accept="image/*,.pdf" >
                                                    <small style="color: grey">Klik atau tarik file untuk mengisi</small>
                                                
                                                    <div style="color: red; display: none;" class="error-bukti">
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
                                            <h4 class="modal-title">Ubah Pengeluaran Kas</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            {{-- form update --}}
                                            <form method="POST" id="form-ubah-pengeluaran-kas">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" id="note_number">
                                                <div class="form-group">
                                                    <label for="edit-no-nota">Nomor Nota</label>
                                                    <input type="text" class="form-control" id="edit-no-nota"
                                                        name="nomor_nota" placeholder="Masukan Nomor Nota">
                                                    <div style="color: red; display: none;" class="error-edit-no-nota">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit-acc-type">Tipe Akun</label>
                                                    <select class="form-control" name="acc_type" id="edit-acc-type">
                                                        @foreach($acc_type as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div style="color: red; display: none;" class="error-edit-acc-type">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit-description">Deskripsi</label>
                                                    <input type="text" class="form-control" id="edit-description"
                                                        name="description" placeholder="Masukan Deskripsi">
                                                    <div style="color: red; display: none;"
                                                        class="error-edit-description">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit-tanggal-pengeluaran">Tanggal Pengeluaran</label>
                                                    <input type="date" class="form-control"
                                                        id="edit-tanggal-pengeluaran" name="tanggal_pengeluaran"
                                                        placeholder="Masukan Tanggal Pengeluaran">
                                                    <div style="color: red; display: none;" class="error-edit-tanggal">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit-jumlah">Jumlah</label>
                                                    <input type="text" class="form-control" id="edit-jumlah"
                                                        name="jumlah" placeholder="Masukan Jumlah">
                                                    <div style="color: red; display: none;" class="error-edit-jumlah">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit-keterangan">Keterangan</label>
                                                    {{-- <input type="textarea" class="form-control" id="tanggal-bayar"
                                                    name="tanggal_bayar" placeholder="Masukan Nama Client"> --}}
                                                    <textarea id="edit-keterangan" name="keterangan"
                                                        placeholder="Masukan Ketrangan" cols="50" class="form-control"
                                                        style="display: block"></textarea>
                                                    <div style="color: red; display: none;"
                                                        class="error-edit-keterangan">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="bukti_pengeluaran">Bukti</label>

                                                    <input type="file" name="bukti_pengeluaran" class="form-control h-100" id="edit-bukti" accept="image/*,.pdf" >
                                                    <small style="color: grey">Klik atau tarik file untuk mengisi</small>
                                                
                                                    <div style="color: red; display: none;" class="error-edit-bukti">
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


        $('#btn-cetak').click(function () {
            var date = $('#date').val() ?? ''; 
            var acc_type = $('#acc_type').val() == null ? '' : $('#acc_type').val();
            url = '{{ url("/pengeluaran-kas/cetak") }}?acc_type='+acc_type+'&date='+date;
            window.open(url, "_blank");
        });
        // $('#btn-download').click(function (e) {
        //     e.preventDefault;
        //     var fileUrl =$(this).attr('href');
        //     // Create a new anchor tag
        //     var downloadLink = $("<a>");

        //     // Set the href attribute to the file URL
        //     downloadLink.attr("href", fileUrl);

        //     // Add the download attribute to the anchor tag
        //     downloadLink.attr("download", "");

        //     // Trigger a click event on the anchor tag to start the download
        //     downloadLink[0].click();
        // });
        //script show
        $('.edit-pengeluaran-kas-btn').click(function (e) {
            var nomor_nota = $(this).data('id');
            var token = $('meta[name="csrf-token"]').attr('content');

            e.preventDefault();
            $.ajax({
                url: `/pengeluaran-kas/${nomor_nota}`,
                type: "GET",
                cache: false,
                success: function (response) {

                    //fill data to form
                    // console.log(response);
                    $("input[name='_token']").val(token);
                    $('#edit-no-nota').val(response.data.note_number);
                    $('#edit-acc-type option[value=' + response.data.acc_type + ']').attr(
                        'selected', 'selected');
                    $('#edit-nama-karyawan').val(response.data.employee_name);
                    $('#edit-description').val(response.data.description);
                    $('#edit-tanggal-pengeluaran').val(response.data.outgoing_date);
                    $('#edit-jumlah').val(response.data.total);
                    $('#edit-keterangan').val(response.data.note);
                    $('#note_number').val(response.data.note_number);
                    $('#edit-bkti').val(response.data.file)

                    // $('#get-username').val(response.data.username);
                    $('.error-edit-no-nota').css('display', 'none');
                    $('.error-edit-acc-type').css('display', 'none');
                    $('.error-edit-description').css('display', 'none');
                    $('.error-edit-tanggal').css('display', 'none');
                    $('.error-edit-jumlah').css('display', 'none');
                    $('.error-edit-keterangan').css('display', 'none');
                    $('.error-edit-bukti').css('display', 'none');
                    // $('#content-edit').val(response.data.content);


                    //open modal
                    // $('#modal-edit').modal('show');
                }
            });

        });

        //script update 
        $('#form-ubah-pengeluaran-kas').submit(function (e) {
            e.preventDefault();
            var form_data = new FormData(this);


            var note_number = $('#note_number').val();
            console.log(note_number);
            // console.log(invoice_number);
            Swal.fire({
                title: 'Yakin Ingin Mengubah Pengeluaran Kas?',
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
                            '_method': 'put'
                        },
                        url: `pengeluaran-kas/${note_number}`,
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
                                location.reload();
                                // $('.error-edit-no-invoice').css('display',
                                //     'none');
                                // $('.error-edit-client').css('display',
                                //     'none');
                                // $('.error-edit-tanggal-bayar').css(
                                //     'display', 'none');
                                // $('.error-edit-jumlah').css('display',
                                //     'none');
                                // $('.error-edit-keterangan').css('display',
                                //     'none');
                            });

                        },
                        error: function (error) {
                            Swal.fire({
                                icon: 'error',
                                showCloseButton: true,
                                showCancelButton: false,
                                showConfirmButton: true,
                                confirmButtonText: 'Ok',
                                title: 'Kesalahan!',
                                text: error.responseJSON.message,
                            })
                            $('.error-edit-no-nota').text(error.responseJSON
                                .nomor_nota).css('display', '');
                            $('.error-edit-acc-type').text(error.responseJSON
                                .acc_type).css('display', '');
                            $('.error-edit-description').text(error.responseJSON
                                .description).css('display', '');
                            $('.error-edit-tanggal').text(error.responseJSON
                                .tanggal_pengeluaran).css('display', '');
                            $('.error-edit-jumlah').text(error.responseJSON
                                .jumlah).css('display', '');
                            $('.error-edit-keterangan').text(error.responseJSON
                                .keterangan).css('display', '');
                        },

                    });
                }
            });

        });



        // Script Delete Penerimaan Kas

        $('.delete-btn').click(function (e) {
            e.preventDefault();


            var note_number = $(this).data('id');

            // console.log(note_number);

            var token = $('meta[name="csrf-token"]').attr('content');
            Swal.fire({
                title: 'Yakin Menghapus Pengeluaran Kas?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "pengeluaran-kas/" + note_number,
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


        // script add pengeluaran kas
        $('#form-tambah-pengeluaran-kas').submit(function (e) {
            e.preventDefault();
            var form_data = new FormData(this);

            Swal.fire({
                title: 'Yakin Menambah Pengeluaran Kas?',
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
                        url: "{{ route('pengeluaran-kas.store') }}",
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
                                location.reload()
                            });

                        },
                        error: function (error) {
                            Swal.fire(
                                'Kesalahan!',
                                'Pengeluaran Kas gagal ditambah!',
                                'error',
                            )
                            console.log(error);
                            $('.error-acc-type').text(error.responseJSON
                                .acc_type).css('display', '');
                            $('.error-no-nota').text(error.responseJSON
                                .nomor_nota).css('display', '');
                            $('.error-description').text(error.responseJSON
                                .description).css('display', '');
                            $('.error-tanggal').text(error.responseJSON
                                .tanggal_pengeluaran).css('display', '');
                            $('.error-jumlah').text(error.responseJSON
                                .jumlah).css('display', '');
                            $('.error-keterangan').text(error.responseJSON
                                .keterangan).css('display', '');
                            $('.error-bukti').text(error.responseJSON
                                .bukti_pengeluaran).css('display', '');
                            // $('#error-image').css('display', '');
                        },
                    });

                }
            })



        });
    });

</script>
@endsection
