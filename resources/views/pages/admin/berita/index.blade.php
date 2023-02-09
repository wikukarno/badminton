@extends('layouts.app')

@section('title', 'Berita')

@section('content')
<section class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="header-title">
                            <h3 class="card-title">Daftar Berita</h3>
                            <a href="{{ route('berita.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>
                                Tambah Berita</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tb_berita" class="table table-hover scroll-horizontal-vertical w-100">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Judul</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Tanggal Diperbarui</th>
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
    $('#tb_berita').DataTable({
        processing: true,
        serverSide: true,
        ordering: [[1, 'asc']],
        ajax: {
            url: "{{ route('berita.index') }}",
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'judul', name: 'judul' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
    });
</script>
@endpush