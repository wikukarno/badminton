@extends('layouts.components')

@section('title', 'Detail Berita')

@section('content')
<div class="container" style="padding-top: 100px">
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="d-flex justify-content-between">
                <h3><b>Berita</b></h3>
                <a href="{{ route('berita') }}" class="text-white">Kembali</a>
            </div>
            <div class="row">
                <div class="col-12 col-lg-12">
                    <figure class="figure">
                        <img src="{{ Storage::url($item->gambar) }}" class="figure-img img-fluid rounded w-100" alt="...">
                            <h1 class="mt-3">{{ $item->judul }}</h1>
                            <div class="post-content mt-3">
                                {!! $item->content !!}
                            </div>
                    </figure>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
