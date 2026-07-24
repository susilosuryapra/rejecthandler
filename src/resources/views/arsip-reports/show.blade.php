@extends('adminlte::page')

@section('title', 'Detail Arsip Report')

@section('content_header')
    <h1>Detail Arsip Report</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Tanggal</th>
                    <td>{{ $report->tanggal->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Jenis Barang</th>
                    <td>{{ $report->jenis_barang }}</td>
                </tr>
                <tr>
                    <th>Nomor Produksi</th>
                    <td>{{ $report->nomor_produksi }}</td>
                </tr>
                <tr>
                    <th>Nomor Batch</th>
                    <td>{{ $report->nomor_batch }}</td>
                </tr>
                <tr>
                    <th>Jumlah Barang</th>
                    <td>{{ $report->jumlah_barang }}</td>
                </tr>
                <tr>
                    <th>Jenis Cacat</th>
                    <td>
                        @foreach($report->jenis_cacat as $cacat)
                            <span class="badge badge-danger">{{ $cacat }}</span>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Keputusan Handling</th>
                    <td>
                        @foreach($report->keputusan_handling as $handling)
                            <span class="badge badge-info">{{ $handling }}</span>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Catatan</th>
                    <td>{!! nl2br(e($report->catatan)) ?? '-' !!}</td>
                </tr>
            </table>

            {{-- Tracker signing --}}
            <div class="mt-4">
                <h5>Tracker</h5>
                <div class="d-flex">
                    @php
                        $signers = [
                            'SPV QC'   => $report->checked_by_qc,
                            'SPV PROD' => $report->checked_by_prod,
                            'PPIC'     => $report->checked_by_ppic,
                            'Merch'    => $report->checked_by_merch,
                            'Gudang'   => $report->checked_by_stor,
                            'Account'  => $report->checked_by_acc,
                        ];
                    @endphp
                    @foreach($signers as $label => $signed)
                        <div class="text-center mr-4">
                            <div>{{ $label }}</div>
                            <div>
                                <i class="fas fa-check text-success fa-2x"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('arsip-reports.download', $report->uuid) }}"
                   class="btn btn-success">
                    <i class="fas fa-download"></i> Download PDF
                </a>
                <a href="{{ route('arsip-reports.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </div>
    </div>
@endsection