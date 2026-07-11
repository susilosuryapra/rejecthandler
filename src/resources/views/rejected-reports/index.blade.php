@extends('adminlte::page')
@section('plugins.Datatables', true)

@section('title', 'Rejected Report')

@section('content_header')
    <h1>Rejected Report</h1>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            @if($role == 'Admin' || $role == 'Supervisor QC')
                <a href="{{ route('rejected-reports.create') }}" class="btn btn-primary float-right">
                    <i class="fas fa-plus"></i> Create
                </a>
            @endif
        </div>
        <div class="card-body">
            <table id="reports-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Barang</th>
                        <th>Nomor Produksi</th>
                        <th>Nomor Batch</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $reports = \App\Models\RejectedReport::all()->filter(function($report) use ($role) {
                            return match($role) {
                                'Admin', 'Supervisor QC' => !($report->checked_by_qc && $report->checked_by_prod && $report->checked_by_ppic && $report->checked_by_merch && $report->checked_by_stor && $report->checked_by_acc),
                                'Supervisor Produksi' => $report->checked_by_qc && !$report->checked_by_prod,
                                'PPIC' => $report->checked_by_qc && $report->checked_by_prod && !$report->checked_by_ppic,
                                'Merchandiser' => $report->checked_by_qc && $report->checked_by_prod && $report->checked_by_ppic && !$report->checked_by_merch,
                                'Gudang' => $report->checked_by_qc && $report->checked_by_prod && $report->checked_by_ppic && $report->checked_by_merch && !$report->checked_by_stor,
                                'Akunting' => $report->checked_by_qc && $report->checked_by_prod && $report->checked_by_ppic && $report->checked_by_merch && $report->checked_by_stor && !$report->checked_by_acc,
                                default => false,
                            };
                        });
                    @endphp

                    @foreach($reports as $index => $report)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $report->jenis_barang }}</td>
                        <td>{{ $report->nomor_produksi }}</td>
                        <td>{{ $report->nomor_batch }}</td>
                        <td>
                            <a href="{{ route('rejected-reports.show', $report->uuid) }}"
                               class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Details
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#reports-table').DataTable();
    });
</script>
@endsection