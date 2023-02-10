@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-medal"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Perlombaan</h4>
                        </div>
                        <div class="card-body">
                            {{ $perlombaan }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
@endsection