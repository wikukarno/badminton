@extends('layouts.app')

@section('title', 'Pengurus')

@section('content')
<section class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="header-title">
                            <h3 class="card-title">Data Pengurus</h3>
                            <a href="{{ route('pengurus.create') }}" class="btn btn-primary"> <i class="fas fa-plus"></i>&nbsp;
                                Tambah Pengurus</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tb_pengurus" class="table table-hover scroll-horizontal-vertical w-100">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Email</th>
                                        <th>Nama</th>
                                        <th>Nomor HP</th>
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
@endsection

@push('after-scripts')
<script>
    // hapus pengurus
    function hapusPengurus(id){
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus data!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type:'POST',
                    url: "{{ url('/pages/admin/pengurus/hapus') }}",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}",
                    },
                    success:function(data){
                        Swal.fire(
                            'Terhapus!',
                            'Data pengurus berhasil dihapus.',
                            'success'
                        )
                        $('#tb_pengurus').DataTable().ajax.reload();
                    },
                    error:function(data){
                        Swal.fire(
                            'Gagal!',
                            'Data pengurus gagal dihapus.',
                            'error'
                        )
                    }
                });
            }
        })
    }
    $('#tb_pengurus').DataTable({
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
            url: "{{ route('pengurus.index') }}",
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'email', name: 'email' },
            { data: 'name', name: 'name' },
            { data: 'phone', name: 'phone' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
    });
</script>
@endpush