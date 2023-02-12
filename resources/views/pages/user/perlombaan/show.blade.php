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
                            <h3 class="card-title">Detail Perlombaan</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <ul>
                                    <li>
                                        <h5>Nama Perlombaan</h5>
                                        <p>{{ $data->nama_perlombaan }}</p>
                                    </li>
                                    <li>
                                        <h5>Tanggal Pendaftaran Dibuka</h5>
                                        <p>{{ $data->tanggal_pendaftaran_dibuka }}</p>
                                    </li>
                                    <li>
                                        <h5>Tanggal Pendaftaran Ditutup</h5>
                                        <p>{{ $data->tanggal_pendaftaran_ditutup }}</p>
                                    </li>
                                    <li>
                                        <h5>Tanggal Perlombaan</h5>
                                        <p>{{ $data->tanggal_pelaksanaan }}</p>
                                    </li>
                                    <li>
                                        <h5>Tempat Perlombaan</h5>
                                        <p>{{ $data->tempat_pelaksanaan }}</p>
                                    </li>
                                    <li>
                                        <h5>Kategori Perlombaan</h5>
                                        <p>{{ $data->kategori_perlombaan }}</p>
                                    </li>
                                    <li>
                                        <h5>Deskripsi Perlombaan</h5>
                                        <p>{{ $data->deskripsi_perlombaan }}</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <a href="{{ route('perlombaan.index') }}" class="btn btn-secondary btn-block">Kembali</a>
                            </div>
                            <div class="col-12 col-lg-6">
                                <a href="{{ route('1.daftar', $data->id) }}" class="btn btn-primary btn-block">Daftar Sekarang</a>
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
@endpush