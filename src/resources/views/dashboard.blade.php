@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $menunggu }}</h3>
                    <p>Dokumen Menunggu Ditangani</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="{{ route('rejected-reports.index') }}" class="small-box-footer">
                    Lihat Report <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $ditangani }}</h3>
                    <p>Dokumen Ditangani Bulan Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="{{ route('arsip-reports.index') }}" class="small-box-footer">
                    Lihat Arsip <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
@endsection