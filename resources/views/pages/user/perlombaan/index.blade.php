@extends('layouts.app')

@section('title', 'Perlombaan')

@section('content')


@if ($data == null)
<section class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Maaf!</strong> Data perlombaan belum tersedia.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@elseif ($data->tanggal_pendaftaran_ditutup < date('Y-m-d'))
<section class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Maaf!</strong> Pendaftaran perlombaan ini telah ditutup.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</section>   
@elseif ($user->status_account == 'pending')
<section class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Maaf!</strong> akun anda sedang dalam proses verifikasi.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@elseif ($user->status_account == 'ditolak')
<section class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Maaf!</strong> akun anda ditolak. Karena <span>{{ $user->alasan_penolakan }}</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- @elseif ($peserta != null)
<section class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Selamat!</strong> Anda telah terdaftar pada perlombaan ini.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}
@else
<section class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="header-title">
                            <h3 class="card-title">Daftar Perlombaan</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tb_perlombaan_user" class="table table-hover scroll-horizontal-vertical w-100">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Perlombaan</th>
                                        <th>Tanggal Pelaksanaan</th>
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
    </div>
</section>
@endif


@include('pages.admin.perlombaan.modal-perlombaan')
@include('pages.admin.perlombaan.modal-show-perlombaan')
@endsection

@push('after-scripts')
<script>
    function btnShowPerlombaan(id){
        $('#showPerlombaanModal').modal('show');
        $('.modal-title').text('Detail Perlombaan');
        $('#id_perlombaan').val(id);

        $.ajax({
            type:'POST',
            url: "{{ url('/pages/user/show/perlombaan') }}",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: (res) => {
                $('#show_nama_perlombaan').val(res.nama_perlombaan);
                $('#show_tanggal_pendaftaran_dibuka').val(moment(res.tanggal_pendaftaran_dibuka).format('YYYY-MM-DD'));
                $('#show_tanggal_pendaftaran_ditutup').val(moment(res.tanggal_pendaftaran_ditutup).format('YYYY-MM-DD'));
                $('#show_tanggal_pelaksanaan').val(moment(res.tanggal_pelaksanaan).format('YYYY-MM-DD'));
                $('#show_tempat_pelaksanaan').val(res.tempat_pelaksanaan);
                $('#show_kategori_perlombaan').val(res.kategori_perlombaan);
                $('#show_deskripsi_perlombaan').val(res.deskripsi_perlombaan);
                $('#show_tanggal').val(moment(res.tanggal).format('YYYY-MM-DD'));
            },
        });
    }

    $('#form-daftar-perlombaan').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type:"POST",
            url: "{{ url('/pages/admin/daftar/perlombaan') }}",
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
            success: function(res){
                $('#btnSimpanPerlombaan').attr('disabled', false);
                $("#tb_perlombaan_user").DataTable().ajax.reload();
                $('#tambahPerlombaanModal').modal('hide');
                Swal.fire(
                    'Berhasil!',
                    res.message,
                    'success'
                );
            },
            complete: function(){
                $(".preloader").fadeOut();
            }
        })
    });

    $('#tb_perlombaan_user').DataTable({
        processing: true,
        serverSide: true,
        ordering: [[1, 'asc']],
        ajax: {
            url: "{{ route('perlombaan.index') }}",
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'nama_perlombaan', name: 'nama_perlombaan' },
            { data: 'tanggal_pelaksanaan', name: 'tanggal_pelaksanaan' },
            { data: 'tanggal_pendaftaran_ditutup', name: 'tanggal_pendaftaran_ditutup' },
            { data: 'kategori_perlombaan', name: 'kategori_perlombaan' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
    });

</script>
@endpush