@extends('layouts.app')

@section('title')
Detail Verifikasi Pengguna
@endsection

@section('content')
<section class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="header-title d-lg-flex">
                            <h3 class="card-title">Detail Verifikasi pengguna</h3>
                            {{-- <span class="mt-1 ml-lg-3"><b>{{ $item->name }}</b></span> --}}
                        </div>
                    </div>
                    <div class="card-body">
                            <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                            <div class="text-center">
                                @if ($users->photo != null)

                                <img src="{{ Storage::url($users->photo) }}"
                                    class="figure-img img-fluid rounded-circle thumbnail-image" alt="foto profile"
                                    id="foto-profile" />

                                @else

                                <img class="profile-user-img img-fluid img-circle thumbnail-image"
                                    src="{{ asset('assets/images/user.png') }}" alt="User profile picture" />
                                @endif
                            </div>
                        <h3 class="profile-username text-center">{{ $users->name }}</h3>
                        <p class="text-center">
                            @if ($users->role == 0)
                                Admin
                                @else
                                Peserta
                            @endif
                        </p>

                        <section class="section-profile-content">
                                <input type="hidden" name="id_profile" id="id_profile">
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="phone">Nomor Telepon</label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                value="{{ $users->phone ?? '' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <input type="text" class="form-control" value="{{ $users->jenis_kelamin ?? '' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="tempat_lahir">Tempat Lahir</label>
                                            <input type="text" class="form-control" id="tempat_lahir"
                                                name="tempat_lahir"
                                                value="{{ $users->tempat_lahir ?? '' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="tanggal_lahir">Tanggal Lahir</label>
                                            <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                                value="{{ $users->tanggal_lahir ?? '' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="pekerjaan">Pekerjaan</label>
                                            <input type="text" class="form-control" id="pekerjaan" name="pekerjaan"
                                                value="{{ $users->pekerjaan ?? '' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="kecamatan">Kecamatan</label>
                                            <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ $users->kecamatan ?? '' }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="kelurahan">Kelurahan</label>
                                            <input type="text" class="form-control" id="kelurahan" name="kelurahan"
                                                value="{{ $users->desa ?? '' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="agama">Agama</label>
                                            <input type="text" class="form-control" id="agama" name="agama" value="{{ $users->agama ?? '' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-12">
                                        <div class="form-group">
                                            <label for="address">Alamat</label>
                                            <input type="text" class="form-control"
                                                value="{{ $users->alamat ?? '' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <figure class="figure">
                                            <img src="{{ Storage::url($users->ktp ?? '') }}"
                                                class="figure-img w-100 img-fluid rounded" alt="KTP">
                                        </figure>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <figure class="figure">
                                            <img src="{{ Storage::url($users->kk ?? '') }}"
                                                class="figure-img w-100 img-fluid rounded" alt="KK">
                                        </figure>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-12">
                                        <a href="{{ route('0.verifikasi') }}"
                                            class="btn btn-danger btn-block mb-3">kembali</a>
                                    </div>
                                </div>
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('after-scripts')
@endpush

@push('after-styles')
<style>
    .thumbnail-image {
        max-height: 100px;
        background-size: cover
    }
</style>