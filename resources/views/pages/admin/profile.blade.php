@extends('layouts.app')

@section('title')
Profile {{ Auth::user()->name }}
@endsection

@section('content')
<section class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Akun Saya</h3>
                    </div>
                    <div class="card-body">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                            <div class="text-center">
                                @if (Auth::user()->photo != null)

                                <img src="{{ Storage::url(Auth::user()->photo) }}"
                                    class="figure-img img-fluid rounded-circle thumbnail-image" alt="foto profile"
                                    id="foto-profile" />

                                @else

                                <img class="profile-user-img img-fluid img-circle thumbnail-image"
                                    src="{{ asset('assets/images/user.png') }}" alt="User profile picture" />
                                @endif
                            </div>
                        </form>
                        <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
                        <p class="text-center">
                            @if (Auth::user()->role == '0')
                                Admin
                                @else
                                User
                            @endif
                        </p>

                        <section class="section-profile-content">
                            <form action="#" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id_profile" id="id_profile">
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="phone">Nomor Telepon</label>
                                            <input type="text" class="form-control" id="phone" name="phone" value="{{ Auth::user()->phone ?? '' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <input type="text" class="form-control" value="{{ Auth::user()->jenis_kelamin ?? '' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="tempat_lahir">Tempat Lahir</label>
                                            <input type="text" class="form-control" id="tempat_lahir"
                                                name="tempat_lahir"
                                                value="{{ Auth::user()->tempat_lahir ?? '' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="tanggal_lahir">Tanggal Lahir</label>
                                            <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                                value="{{ Auth::user()->tanggal_lahir ?? '' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="pekerjaan">Pekerjaan</label>
                                            <input type="text" class="form-control" id="pekerjaan" name="pekerjaan"
                                                value="{{ Auth::user()->pekerjaan ?? '' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="agama">Agama</label>
                                            <input type="text" class="form-control" id="agama" name="agama" value="{{ Auth::user()->agama ?? '' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-4">
                                        <div class="form-group">
                                            <label for="kabupaten">Kabupaten</label>
                                            <input type="text" class="form-control" id="kabupaten" name="kabupaten"
                                                value="{{ Auth::user()->kabupaten ?? '' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="form-group">
                                            <label for="kecamatan">Kecamatan</label>
                                            <input type="text" class="form-control" id="kecamatan" name="kecamatan"
                                                value="{{ Auth::user()->kecamatan ?? '' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="form-group">
                                            <label for="desa">Desa</label>
                                            <input type="text" class="form-control" id="desa" name="desa"
                                                value="{{ Auth::user()->desa ?? '' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-12">
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" class="form-control"
                                                value="{{ Auth::user()->alamat ?? '' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <a href="{{ route('0.dashboard') }}"
                                            class="btn btn-danger btn-block mb-3">Kembali</a>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <a href="{{ route('akun-admin.edit', Auth::user()->id) }}"
                                            class="btn btn-success btn-block mb-3">Update Akun</a>
                                    </div>
                                </div>
                            </form>
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('after-scripts')
<script>
    function updateImage() {
        document.getElementById('update-image-user').click();
    }
    function addImage() {
        document.getElementById('add-image-user').click();
    }
</script>
@endpush

@push('after-styles')
<style>
    .thumbnail-image {
        max-height: 100px;
        background-size: cover
    }
</style>
@endpush