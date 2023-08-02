@extends('layouts.app')

@section('title', 'Pertandingan')

@section('content')
    <section class="main-content">
        <div class="container-fluid">
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
                                            <th>Skor Peserta 1</th>
                                            <th>Skor Peserta 2</th>
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

    @include('pages.admin.pertandingan.modal-pertandingan')
@endsection

@push('after-scripts')
    <script>
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
                    data: 'skor_peserta_1',
                    name: 'skor_peserta_1'
                },
                {
                    data: 'skor_peserta_2',
                    name: 'skor_peserta_2'
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
