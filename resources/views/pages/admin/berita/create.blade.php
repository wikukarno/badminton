@extends('layouts.app')

@section('title')
Tambah Berita
@endsection

@section('content')
<section class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="header-title d-lg-flex">
                            <h3 class="card-title">Tambah Berita</h3>
                            {{-- <span class="mt-1 ml-lg-3"><b>{{ $item->name }}</b></span> --}}
                        </div>
                    </div>
                    <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="judul">Judul</label>
                                        <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="gambar">Thumbnail / Gambar</label>
                                        <input type="file" class="form-control" id="gambar" name="gambar" placeholder="Gambar">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="content">Konten</label>
                                        <textarea class="form-control ckeditor" id="content" name="content" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('berita.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('after-scripts')
{{-- Ckeditor --}}
<script src="https://cdn.ckeditor.com/ckeditor5/28.0.0/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create( document.querySelector( '.ckeditor' ) )
        .then( editor => {
                console.log( editor );
        } )
        .catch( error => {
                console.error( error );
        } );
</script>
@endpush

@push('after-styles')
<style>
    .thumbnail-image {
        max-height: 100px;
        background-size: cover
    }
</style>