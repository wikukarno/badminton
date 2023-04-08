@extends('layouts.components')

@section('title', 'Berita')

@section('content')
<div class="container" style="padding-top: 100px">
    <div class="row">
        <div class="col-12 col-lg-12">
            <h3><b>Berita</b></h3>
            <div class="row mt-5">
                @foreach ($items as $item)
                    <div class="col-12 col-lg-4">
                        <figure class="figure">
                            <img src="{{ Storage::url($item->gambar) }}" class="figure-img img-fluid rounded" alt="...">
                                <h1>{{ $item->judul }}</h1>
                                <div class="post-content">
                                    {!! $item->content !!}
                                </div>
                        </figure>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('after-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // make post content max length 100
        $(document).ready(function() {
            $('.post-content').each(function() {
                var content = $(this).text();
                if (content.length > 200) {
                    content = content.substring(0, 200);
                    $(this).text(content + '...');
                }

                

                // make link selengkapnya
                $(this).append('<a href="{{ route('detail-berita', $item->slug) }}">Selengkapnya</a>');
            });
        });
    </script>
@endpush
