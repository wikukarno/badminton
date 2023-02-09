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
                        <div class="header-title">
                            {{-- <h3 class="card-title">Menu Profile</h3>
                            <a href="javascript:void(0)" class="btn btn-primary"
                                onclick="ubahProfile({{ Auth::user()->id }})">Ubah Profile</a> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading">Perhatian!</h4>
                            <p>Fitur ini sedang dalam tahap pengembangan.</p>
                            <hr />
                            <p class="mb-0">Mohon maaf atas ketidaknyamanannya.</p>
                        </div>
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