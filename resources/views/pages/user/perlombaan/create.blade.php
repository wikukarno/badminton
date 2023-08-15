@extends('layouts.app')

@section('title', 'Daftar Perlombaan')

@section('content')
    <section class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="header-title">
                                <h3 class="card-title">Daftar Perlombaan</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="{{ Auth::user()->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="phone">Nomor Telepon</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="{{ Auth::user()->phone }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <input type="text" class="form-control" value="{{ Auth::user()->jenis_kelamin }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="tempat_lahir">Tempat Lahir</label>
                                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                            value="{{ Auth::user()->tempat_lahir }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="tanggal_lahir">Tanggal Lahir</label>
                                        <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                            value="{{ Auth::user()->tanggal_lahir }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="pekerjaan">Pekerjaan</label>
                                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan"
                                            value="{{ Auth::user()->pekerjaan }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="agama">Agama</label>
                                        <input type="text" class="form-control" id="agama" name="agama"
                                            value="{{ Auth::user()->agama }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="kabupaten">Kabupaten</label>
                                        <input type="text" class="form-control" id="kabupaten" name="kabupaten"
                                            value="{{ Auth::user()->kabupaten }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="kecamatan">Kecamatan</label>
                                        <input type="text" class="form-control" id="kecamatan" name="kecamatan"
                                            value="{{ Auth::user()->kecamatan }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="desa">Desa</label>
                                        <input type="text" class="form-control" id="desa" name="desa"
                                            value="{{ Auth::user()->desa }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <input type="text" class="form-control" value="{{ Auth::user()->alamat }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('perlombaan.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="perlombaans_id" id="perlombaans_id"
                                    value="{{ $data->id }}">
                                @if ($data->kategori_perlombaan == 'Double Pria' || $data->kategori_perlombaan == 'Double Wanita')
                                    <div class="row">
                                        <div class="col-12 col-lg-12">
                                            <div class="form-group">
                                                <label for="nama_teman">Nama Teman (Untuk Double)</label>
                                                <input type="text" name="nama_teman" id="nama_teman"
                                                    class="form-control" placeholder="Nama Teman" required>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-12 col-lg-12">
                                        <button class="btn btn-primary float-right" type="submit">Daftar
                                            Sekarang</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('after-scripts')
@endpush
