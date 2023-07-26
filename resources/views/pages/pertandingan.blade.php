@extends('layouts.components')

@section('title', 'Jadwal Pertandingan')

@section('content')
<div class="container" style="padding-top: 100px">
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-black"><b>Jadwal Pertandingan</b></h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tb_pertandingan" class="table table-hover scroll-horizontal-vertical w-100">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Peserta 1</th>
                                    <th>Peserta 2</th>
                                    <th>Tanggal Pertandingan</th>
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
@endsection

@push('after-scripts')
<script>
    $('#tb_pertandingan').DataTable({
        processing: true,
        serverSide: true,
        ordering: [[1, 'asc']],
        ajax: {
            url: "{{ url('/pertandingan') }}",
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'pesertas_id_1', name: 'pesertas_id_1' },
            { data: 'pesertas_id_2', name: 'pesertas_id_2' },
            { data: 'tanggal_jadwal', name: 'tanggal_jadwal' },
        ],
    });
</script>
@endpush