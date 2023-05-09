@extends('layouts.app')

@section('title')
Update Profile {{ Auth::user()->name }}
@endsection

@section('content')
<section class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Update Akun Saya</h3>
                    </div>
                    <div class="card-body">
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
                        <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
                        <p class="text-center">
                            @if (Auth::user()->role == '0')
                            Admin
                            @else
                            User
                            @endif
                        </p>

                        <section class="section-profile-content">
                            <form action="{{ route('akun.update', $user->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="phone">Nomor Telepon</label>
                                            <input type="number" class="form-control" id="phone" name="phone"
                                                value="{{ $user->phone ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                                <option value="Laki-laki" @if (Auth::user()->jenis_kelamin == 'Laki-laki')
                                                    selected @endif>Laki-laki</option>
                                                <option value="Perempuan" @if (Auth::user()->jenis_kelamin == 'Perempuan')
                                                    selected @endif>Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="tempat_lahir">Tempat Lahir</label>
                                            <input type="text" class="form-control" id="tempat_lahir"
                                                name="tempat_lahir" value="{{ $user->tempat_lahir ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="tanggal_lahir">Tanggal Lahir</label>
                                            <input type="date" class="form-control" id="tanggal_lahir"
                                                name="tanggal_lahir" value="{{ $user->tanggal_lahir ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="pekerjaan">Pekerjaan</label>
                                            <input type="text" class="form-control" id="pekerjaan" name="pekerjaan"
                                                value="{{ $user->pekerjaan ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="agama">Agama</label>
                                            <select class="form-control" id="agama" name="agama">
                                                <option value="Islam" @if (Auth::user()->agama == 'Islam') selected
                                                    @endif>Islam</option>
                                                <option value="Kristen" @if (Auth::user()->agama == 'Kristen') selected
                                                    @endif>Kristen</option>
                                                <option value="Katholik" @if (Auth::user()->agama == 'Katholik')
                                                    selected
                                                    @endif>Katholik</option>
                                                <option value="Hindu" @if (Auth::user()->agama == 'Hindu') selected
                                                    @endif>Hindu</option>
                                                <option value="Budha" @if (Auth::user()->agama == 'Budha') selected
                                                    @endif>Budha</option>
                                                <option value="Konghucu" @if (Auth::user()->agama == 'Konghucu')
                                                    selected
                                                    @endif>Konghucu</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-4">
                                        <div class="form-group">
                                            <label for="kabupaten">Kabupaten</label>
                                            <select class="form-control" id="kabupaten" name="kabupaten">
                                                <option value="Bengkalis" @if (Auth::user()->kabupaten == 'Bengkalis') selected @endif>
                                                    Bengkalis
                                                </option>
                                                <option value="Indragiri Hilir" @if (Auth::user()->kabupaten == 'Indragiri Hilir') selected @endif>
                                                    Indragiri Hilir
                                                </option>
                                                <option value="Indragiri Hulu" @if (Auth::user()->kabupaten == 'Indragiri Hulu') selected @endif>
                                                    Indragiri Hulu
                                                </option>
                                                <option value="Kampar" @if (Auth::user()->kabupaten == 'Kampar') selected @endif>
                                                    Kampar
                                                </option>
                                                <option value="Kepulauan Meranti" @if (Auth::user()->kabupaten == 'Kepulauan Meranti') selected @endif>
                                                    Kepulauan Meranti
                                                </option>
                                                <option value="Kuantan Singingi" @if (Auth::user()->kabupaten == 'Kuantan Singingi') selected @endif>
                                                    Kuantan Singingi
                                                </option>
                                                <option value="Pelalawan" @if (Auth::user()->kabupaten == 'Pelalawan') selected @endif>
                                                    Pelalawan
                                                </option>
                                                <option value="Rokan Hilir" @if (Auth::user()->kabupaten == 'Rokan Hilir') selected @endif>
                                                    Rokan Hilir
                                                </option>
                                                <option value="Rokan Hulu" @if (Auth::user()->kabupaten == 'Rokan Hulu') selected @endif>
                                                    Rokan Hulu
                                                </option>
                                                <option value="Siak" @if (Auth::user()->kabupaten == 'Siak') selected @endif>
                                                    Siak
                                                </option>
                                                <option value="Dumai" @if (Auth::user()->kabupaten == 'Dumai') selected @endif>
                                                    Dumai
                                                </option>
                                                <option value="Pekanbaru" @if (Auth::user()->kabupaten == 'Pekanbaru') selected @endif>
                                                    Pekanbaru
                                                </option>
                                            </select>
                                                
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="form-group">
                                            <label for="kecamatan">Kecamatan</label>
                                            <input type="text" class="form-control" id="kecamatan" name="kecamatan"
                                                value="{{ $user->kecamatan ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="form-group">
                                            <label for="desa">Desa</label>
                                            <input type="text" class="form-control" id="desa" name="desa"
                                                value="{{ $user->desa ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="ktp">Foto KTP / Pelajar</label>
                                            <input type="file" class="form-control" id="ktp" name="ktp">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="kk">Foto KK</label>
                                            <input type="file" class="form-control" id="kk" name="kk">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-lg-12">
                                        <div class="form-group">
                                            <label for="photo">Foto Profile</label>
                                            <input type="file" class="form-control" id="photo" name="photo">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-lg-12">
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" class="form-control" value="{{ $user->alamat ?? '' }}"
                                                name="alamat">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <a href="{{ route('akun.index') }}"
                                            class="btn btn-danger btn-block mb-3">Batal</a>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <button class="btn btn-success btn-block">Update Sekarang</button>
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
    //
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