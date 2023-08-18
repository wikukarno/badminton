@extends('layouts.app')

@section('title', 'Perlombaan dan Pertandingan')

@section('content')
    <section class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="header-title">
                                <h3 class="card-title">Data Perlombaan</h3>
                                <a href="javascript:void(0)" class="btn btn-primary" onclick="tambahPerlombaan()"> <i
                                        class="fas fa-plus"></i>&nbsp;
                                    Tambah Perlombaan</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tb_perlombaan" class="table table-hover scroll-horizontal-vertical w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Perlombaan</th>
                                            <th>Pendaftaran Dibuka</th>
                                            <th>Pendaftaran Ditutup</th>
                                            <th>Kategori Perlombaan</th>
                                            <th>Aksi</th>
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="header-title">
                                <h3 class="card-title">Data Pertandingan</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tb_pertandingan" class="table table-hover scroll-horizontal-vertical w-100">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Perlombaan</th>
                                            <th>Kategori Perlombaan</th>
                                            <th>Peserta 1</th>
                                            <th>Peserta 2</th>
                                            <th>Status</th>
                                            <th>Tanggal Jadwal</th>
                                            <th>Skor</th>
                                            <th>Durasi</th>
                                            <th>Aksi</th>
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
    </section>
    @include('pages.admin.perlombaan.modal-perlombaan')
    @include('pages.admin.perlombaan.modal-show-perlombaan')
    @include('pages.admin.pertandingan.modal-pertandingan')
@endsection

@push('after-scripts')
    <script>
        // tambah perlombaan
        function tambahPerlombaan() {
            $('#tambahPerlombaanModal').modal('show');
            $('#form-tambah-perlombaan').trigger('reset');
            $('.modal-title').text('Tambah Perlombaan');
            $('#btnSimpanPerlombaan').html('Simpan');
            $('#id_perlombaan').val('');
        }

        function btnUpdatePerlombaan(id) {
            $('#tambahPerlombaanModal').modal('show');
            $('.modal-title').text('Update Perlombaan');
            $('#id_perlombaan').val(id);

            $.ajax({
                type: 'POST',
                url: "{{ url('/pages/admin/update/perlombaan') }}",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: (res) => {
                    $('#nama_perlombaan').val(res.nama_perlombaan);
                    $('#tanggal_pendaftaran_dibuka').val(moment(res.tanggal_pendaftaran_dibuka).format(
                        'YYYY-MM-DD'));
                    $('#tanggal_pendaftaran_ditutup').val(moment(res.tanggal_pendaftaran_ditutup).format(
                        'YYYY-MM-DD'));
                    $('#tempat_pelaksanaan').val(res.tempat_pelaksanaan);
                    $('#kategori_perlombaan').val(res.kategori_perlombaan);
                    $('#deskripsi_perlombaan').val(res.deskripsi_perlombaan);
                },
            });
        }

        // function btnShowPerlombaan(id) {
        //     $('#showPerlombaanModal').modal('show');
        //     $('.modal-title').text('Detail Perlombaan');
        //     $('#id_perlombaan').val(id);

        //     $.ajax({
        //         type: 'POST',
        //         url: "{{ url('/pages/admin/show/perlombaan') }}",
        //         data: {
        //             id: id,
        //             _token: "{{ csrf_token() }}"
        //         },
        //         dataType: 'json',
        //         success: (res) => {
        //             $('#show_nama_perlombaan').val(res.nama_perlombaan);
        //             $('#show_tanggal_pendaftaran_dibuka').val(moment(res.tanggal_pendaftaran_dibuka).format(
        //                 'YYYY-MM-DD'));
        //             $('#show_tanggal_pendaftaran_ditutup').val(moment(res.tanggal_pendaftaran_ditutup).format(
        //                 'YYYY-MM-DD'));
        //             $('#show_tanggal_pelaksanaan').val(moment(res.tanggal_pelaksanaan).format('YYYY-MM-DD'));
        //             $('#show_tempat_pelaksanaan').val(res.tempat_pelaksanaan);
        //             $('#show_kategori_perlombaan').val(res.kategori_perlombaan);
        //             $('#show_deskripsi_perlombaan').val(res.deskripsi_perlombaan);
        //             $('#show_tanggal').val(moment(res.tanggal).format('YYYY-MM-DD'));
        //         },
        //     });
        // }

        function btnDeletePerlombaan(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('/pages/admin/hapus/perlombaan') }}",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        dataType: 'json',
                        success: (res) => {
                            Swal.fire(
                                'Berhasil!',
                                'Data berhasil dihapus.',
                                'success'
                            )
                            $('#tb_perlombaan').DataTable().ajax.reload();
                        },
                        error: (err) => {
                            Swal.fire(
                                'Gagal!',
                                'Data gagal dihapus.',
                                'error'
                            )
                        }
                    });
                }
            })
        }

        // Fungsi untuk buat jadwal pertandingan secara random
        function btnCreateRandomPertandingan(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Buat jadwal pertandingan secara random!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, buat!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('/pages/admin/create/random/pertandingan') }}",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        dataType: 'json',
                        success: (res) => {
                            if (res.status == true) {
                                Swal.fire(
                                    'Berhasil!',
                                    'Pertandingan random berhasil dibuat.',
                                    'success'
                                )
                                $('#tb_perlombaan').DataTable().ajax.reload();
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    res.message,
                                    'error'
                                )
                            }
                        },
                        error: (err) => {
                            Swal.fire(
                                'Gagal!',
                                err.responseJSON.message,
                                'error'
                            )
                        }
                    });
                }
            })
        }

        $('#form-tambah-perlombaan').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "{{ url('/pages/admin/tambah/perlombaan') }}",
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $(".preloader").fadeIn();
                    $('#btnSimpanPerlombaan').html('<i class="fa fa-spin fa-spinner"></i> Processing');
                    $('#btnSimpanPerlombaan').attr('disabled', true);
                },
                success: function(res) {
                    if (res.status == true) {
                        $('#btnSimpanPerlombaan').attr('disabled', false);
                        $("#tb_perlombaan").DataTable().ajax.reload();
                        $('#tambahPerlombaanModal').modal('hide');
                        Swal.fire(
                            'Berhasil!',
                            res.message,
                            'success'
                        );
                    } else {
                        $('#btnSimpanPerlombaan').attr('disabled', false);
                        $('#btnSimpanPerlombaan').html('Simpan');

                        failedNotifikasi(res.message);
                    }
                },
                error: function(res) {
                    $('#btnSimpanPerlombaan').attr('disabled', false);
                    $('#btnSimpanPerlombaan').html('Simpan');

                    failedNotifikasi(res.responseJSON.message)
                },
                complete: function() {
                    $(".preloader").fadeOut();
                    $('#btnSimpanPerlombaan').attr('disabled', false);
                    $('#btnSimpanPerlombaan').html('Simpan');
                }
            })
        });

        $('#tb_perlombaan').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            dom: 'lBfrtip',
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [{
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
            ordering: [
                [1, 'asc']
            ],
            ajax: {
                url: "{{ route('perlombaan-admin.index') }}",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                {
                    data: 'nama_perlombaan',
                    name: 'nama_perlombaan'
                },
                {
                    data: 'tanggal_pendaftaran_dibuka',
                    name: 'tanggal_pendaftaran_dibuka'
                },
                {
                    data: 'tanggal_pendaftaran_ditutup',
                    name: 'tanggal_pendaftaran_ditutup'
                },
                {
                    data: 'kategori_perlombaan',
                    name: 'kategori_perlombaan'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
        });

        $('#tb_pertandingan').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            dom: 'lBfrtip',
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [{
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
            ordering: [
                [1, 'asc']
            ],
            ajax: {
                url: "{{ route('0.pertandingan.index') }}",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                {
                    data: 'perlombaan.nama_perlombaan',
                    name: 'perlombaan.nama_perlombaan'
                },
                {
                    data: 'perlombaan.kategori_perlombaan',
                    name: 'perlombaan.kategori_perlombaan'
                },
                {
                    data: 'peserta_1',
                    name: 'peserta_1'
                },
                {
                    data: 'peserta_2',
                    name: 'peserta_2'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'tanggal_jadwal',
                    name: 'tanggal_jadwal'
                },
                {
                    data: 'skor_pertandingan',
                    name: 'skor_pertandingan'
                },
                {
                    data: 'durasi',
                    name: 'durasi'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
        });

        // Fungsi untuk menampilkan info jika tombol update skor belum muncul
        function btnInfoPertandingan() {
            Swal.fire({
                title: 'Informasi',
                text: "Tombol update skor akan muncul setelah tanggal jadwal melebihi atau sama dengan hari ini.",
                icon: 'warning',
            })
        }

        // Fungsi untuk menampilkan info jika hasil pertandingan seri
        function btnSeriPertandingan() {
            Swal.fire({
                title: 'Informasi',
                text: "Hasil pertandingan seri dan akan ditanding ulang ke jadwal selanjutnya.",
                icon: 'warning',
            })
        }

        // Fungsi untuk update skor pertandingan
        function btnUpdateSkorPertandingan(id) {
            $('#updateSkorPertandinganModal').modal('show');
            $('#id_pertandingan').val(id);

            $.ajax({
                type: 'POST',
                url: "{{ url('/pages/admin/pertandingan/update/skor') }}",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: (res) => {
                    $('#skor_peserta_1').val(res.skor_peserta_1);
                    $('#skor_peserta_2').val(res.skor_peserta_2);
                },
                error: (xhr) => {
                    console.log(xhr.responseText);
                }
            });
        }

        // Fungsi untuk update status pertandingan menjadi selesai
        function btnUpdateStatusPertandingan(id) {
            Swal.fire({
                title: 'Konfirmasi',
                text: "Apakah Anda yakin ingin mengubah status pertandingan menjadi selesai?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, ubah!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('/pages/admin/pertandingan/update/status') }}",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        dataType: 'json',
                        success: (res) => {
                            Swal.fire(
                                'Berhasil!',
                                res.message,
                                'success'
                            )
                            $('#tb_pertandingan').DataTable().ajax.reload();
                        },
                        error: (err) => {
                            Swal.fire(
                                'Gagal!',
                                'Status pertandingan gagal diubah. ' + err.responseText,
                                'error'
                            )
                        }
                    });
                }
            })
        }

        // Fungsi untuk melihat hasil pertandingan
        function btnLihatHasilPertandingan(id) {
            $.ajax({
                type: 'POST',
                url: "{{ url('/pages/admin/pertandingan/hasil') }}",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: (res) => {
                    var text = "Pemenang pertandingan adalah " + res.peserta +
                        ". <div class='text-center'><b>" + res.pemenang +
                        "</b></div>Skor pertandingan adalah " + res.skor_peserta_1 + " - " + res
                        .skor_peserta_2 + ".";

                    Swal.fire({
                        title: 'Informasi Hasil Pertandingan',
                        html: text,
                        icon: 'warning',
                    })
                },
                error: (xhr) => {
                    console.log(xhr.responseText);
                }
            });
        }

        // Fungsi untuk menyimpan skor pertandingan
        $('#form-update-skor-pertandingan').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "{{ url('/pages/admin/pertandingan/store/skor') }}",
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $(".preloader").fadeIn();
                    $('#btnSimpanUpdateSkorPertandingan').html(
                        '<i class="fa fa-spin fa-spinner"></i> Processing');
                    $('#btnSimpanUpdateSkorPertandingan').attr('disabled', true);
                },
                success: function(res) {
                    if (res.status == true) {
                        $('#btnSimpanUpdateSkorPertandingan').attr('disabled', false);
                        $("#tb_pertandingan").DataTable().ajax.reload();
                        $('#updateSkorPertandinganModal').modal('hide');
                        Swal.fire(
                            'Berhasil!',
                            res.message,
                            'success'
                        );
                    } else {
                        $('#btnSimpanUpdateSkorPertandingan').attr('disabled', false);
                        $('#btnSimpanUpdateSkorPertandingan').html('Simpan');

                        failedNotifikasi(res.message);
                    }
                },
                error: function(res) {
                    $('#btnSimpanUpdateSkorPertandingan').attr('disabled', false);
                    $('#btnSimpanUpdateSkorPertandingan').html('Simpan');

                    failedNotifikasi(res.responseJSON.message)
                },
                complete: function() {
                    $(".preloader").fadeOut();
                    $('#btnSimpanUpdateSkorPertandingan').attr('disabled', false);
                    $('#btnSimpanUpdateSkorPertandingan').html('Simpan');
                }
            })
        });
    </script>
@endpush
