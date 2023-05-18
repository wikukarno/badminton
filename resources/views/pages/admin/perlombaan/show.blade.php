@extends('layouts.app')

@section('title', 'Detail Perlombaan')

@section('content')
<section class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="header-title">
                            <h3 class="card-title">Detail Perlombaan</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label for="nama">Nama Perlombaan</label>
                                    <input type="text" name="nama_perlombaan" id="show_nama_perlombaan"
                                        class="form-control" value="{{ $data->nama_perlombaan }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal Pendaftaran Dibuka</label>
                                    <input type="text" name="tanggal_pendaftaran_dibuka"
                                        id="show_tanggal_pendaftaran_dibuka" class="form-control"
                                        value="{{ \Carbon\Carbon::parse($data->tanggal_pendaftaran_dibuka)->isoFormat('D MMMM Y') }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal Pendaftaran Ditutup</label>
                                    <input type="text" name="tanggal_pendaftaran_ditutup"
                                        id="show_tanggal_pendaftaran_ditutup" class="form-control"
                                        value="{{ \Carbon\Carbon::parse($data->tanggal_pendaftaran_ditutup)->isoFormat('D MMMM Y') }}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal Perlombaan</label>
                                    <input type="text" name="tanggal_pelaksanaan"
                                        value="{{ \Carbon\Carbon::parse($data->tanggal_pelaksanaan)->isoFormat('D MMMM Y') }}"
                                        id="show_tanggal_pelaksanaan" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6 mb-3">
                                <label for="tempat">Tempat Perlombaan</label>
                                <input type="text" name="tempat_pelaksanaan" id="show_tempat_pelaksanaan"
                                    class="form-control" value="{{ $data->tempat_pelaksanaan }}" readonly>
                            </div>
                            <div class="col-12 col-lg-6 mb-3">
                                <label for="kategori_perlombaan">Kategori Perlombaan</label>
                                <input type="text" class="form-control" name="kategori_perlombaan"
                                    id="show_kategori_perlombaan" value="{{ $data->kategori_perlombaan }}" readonly>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 col-lg-12">
                                <label for="deskripsi_perlombaan">Deskripsi Perlombaan</label>
                                <textarea name="deskripsi_perlombaan" id="show_deskripsi_perlombaan"
                                    class="form-control" readonly>
                                    {{ $data->deskripsi_perlombaan }}
                                </textarea>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="container">
                                <div class="header-title">
                                    <h3>Daftar Peserta</h3>
                                </div>
                            </div>
                            <div class="col-12 col-lg-12">
                                <table id="tb_peserta" class="table table-hover scroll-horizontal-vertical w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Profile</th>
                                            <th>Email</th>
                                            <th>Nama</th>
                                            <th>Nomor HP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('after-scripts')
    <script>
        $('#tb_peserta').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'lBfrtip',
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        buttons: [
            {
            extend: 'copy',
            text: 'Copy',
            className: 'btn btn-primary',
            exportOptions: {
            columns: [1, 2, 3, 4]
            }
            },
            {
            extend: 'csv',
            text: 'CSV',
            className: 'btn btn-primary',
            exportOptions: {
            columns: [1, 2, 3, 4]
            }
            },
            {
            extend: 'excel',
            text: 'Excel',
            className: 'btn btn-primary',
            exportOptions: {
            columns: [1, 2, 3, 4]
            }
            },
            {
            extend: 'pdf',
            text: 'PDF',
            className: 'btn btn-primary',
            exportOptions: {
            columns: [1, 2, 3, 4]
            }
            },
            {
            extend: 'print',
            text: 'Print',
            className: 'btn btn-primary',
            exportOptions: {
            columns: [1, 2, 3, 4]
            }
            }
        ],
        ordering: [[1, 'asc']],
        ajax: {
            url: "{{ route('0.show.perlombaan', $data->id) }}",
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'photo', name: 'photo' },
            { data: 'user.email', name: 'user.email' },
            { data: 'user.name', name: 'user.name' },
            { data: 'user.phone', name: 'user.phone' },
        ],
    });
    </script>

@endpush