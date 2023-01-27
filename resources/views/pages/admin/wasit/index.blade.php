@extends('layouts.app')

@section('title', 'Wasit')

@section('content')
<section class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="header-title">
                            <h3 class="card-title">Data Wasit</h3>
                            <a href="javascript:void(0)" class="btn btn-primary" onclick="tambahWasit()"> <i
                                    class="fas fa-plus"></i>&nbsp;
                                Tambah Wasit</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tb_wasit" class="table table-hover scroll-horizontal-vertical w-100">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Nomor Telepon</th>
                                        <th>Status</th>
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
@include('pages.admin.wasit.modal-wasit')
@endsection

@push('after-scripts')
<script>
    // tambah wasit
    function tambahWasit(){
        $('#tambahWasitModal').modal('show');
        $('#form-tambah-wasit').trigger('reset');
        $('.modal-title').text('Tambah Wasit');
        $('#id_wasit').val('');
    }

    function btnUpdateWasit(id){
        $('#tambahWasitModal').modal('show');
        $('.modal-title').text('Update Wasit');
        $('#id_wasit').val(id);

        $.ajax({
            type:'POST',
            url: "{{ url('/pages/admin/show/wasit') }}",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: (res) => {
                $('#nama').val(res.nama);
                $('#email').val(res.email);
                $('#phone').val(res.phone);
                $('#status').val(res.status);
                $('#alamat').val(res.alamat);
            },
        });
    }

    function btnDeleteWasit(id){
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
                    url: "{{ url('/pages/admin/hapus/wasit') }}",
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
                            $('#tb_wasit').DataTable().ajax.reload();
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

    $('#form-tambah-wasit').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type:"POST",
            url: "{{ url('/pages/admin/tambah/wasit') }}",
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $(".preloader").fadeIn();
                $('#btnSimpanWasit').html('<i class="fa fa-spin fa-spinner"></i> Processing');
                $('#btnSimpanWasit').attr('disabled', true);
            },
            success: function(res){
                $('#btnSimpanWasit').attr('disabled', false);
                $("#tb_wasit").DataTable().ajax.reload();
                $('#tambahWasitModal').modal('hide');
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

    $('#tb_wasit').DataTable({
        processing: true,
        serverSide: true,
        ordering: [[1, 'asc']],
        ajax: {
            url: "{{ route('0.wasit') }}",
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'photo', name: 'photo' },
            { data: 'nama', name: 'nama' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
    });

</script>
@endpush