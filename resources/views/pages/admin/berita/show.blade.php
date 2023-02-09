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
                            <h3 class="card-title">Detail Artikel</h3>
                            <span class="mt-1 ml-lg-3"><b>{{ $item->judul }}</b></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-12 col-lg-12">
                                <figure class="figure">
                                    <img src="{{ Storage::url($item->gambar) }}"
                                        class="figure-img img-fluid rounded w-full" style="height: 300px" alt="...">
                                </figure>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <h3>{{ $item->judul }}</h3>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <p>{!! $item->content !!}</p>
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

@push('after-styles')
<style>
    .thumbnail-image {
        max-height: 100px;
        background-size: cover
    }
</style>