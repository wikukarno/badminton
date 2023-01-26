@extends('layouts.app')

@section('title', 'Perlombaan')

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
                                        <th>Nama</th>
                                        <th>Tanggal</th>
                                        <th>Kuota</th>
                                        <th>Tempat</th>
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
@endsection

@push('after-scripts')
<script>
    // tambah perlombaan
    function tambahPerlombaan(){
        $('#tambahPerlombaanModal').modal('show');
        $('#form-tambah-perlombaan').trigger('reset');
        $('.modal-title').text('Tambah Perlombaan');
        $('#id_perlombaan').val('');
    }

    function btnUpdatePerlombaan(id){
        $('#tambahPerlombaanModal').modal('show');
        $('.modal-title').text('Update Perlombaan');
        $('#id_perlombaan').val(id);

        $.ajax({
            type:'POST',
            url: "{{ url('/pages/admin/show/perlombaan') }}",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: (res) => {
                $('#nama').val(res.nama);
                $('#tanggal').val(moment(res.tanggal).format('YYYY-MM-DD'));
                $('#kuota').val(res.kuota);
                $('#tempat').val(res.tempat);
                $('#status').val(res.status);
                $('#deskripsi').val(res.deskripsi);
            },
        });
    }

    function btnDeletePerlombaan(id){
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
                    type:'POST',
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

    $('#form-tambah-perlombaan').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type:"POST",
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
            success: function(res){
                $('#btnSimpanPerlombaan').attr('disabled', false);
                $("#tb_perlombaan").DataTable().ajax.reload();
                $('#tambahPerlombaanModal').modal('hide');
                Swal.fire(
                    'Berhasil!',
                    'Data berhasil dihapus.',
                    'success'
                );
            },
            complete: function(){
                $(".preloader").fadeOut();
            }
        })
    });

    $('#tb_perlombaan').DataTable({
        processing: true,
        serverSide: true,
        ordering: [[1, 'asc']],
        ajax: {
            url: "{{ route('0.perlombaan') }}",
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'nama', name: 'nama' },
            { data: 'tanggal', name: 'tanggal' },
            { data: 'kuota', name: 'kuota' },
            { data: 'tempat', name: 'tempat' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
    });

</script>
@endpush