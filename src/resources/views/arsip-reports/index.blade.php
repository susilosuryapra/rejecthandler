@extends('adminlte::page')
@section('plugins.Datatables', true)

@section('title', 'Arsip Report')

@section('content_header')
    <h1>Arsip Report</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="arsip-table" class="table table-bordered table-striped">
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
                        $reports = \App\Models\RejectedReport::where('checked_by_qc', true)
                            ->where('checked_by_prod', true)
                            ->where('checked_by_ppic', true)
                            ->where('checked_by_merch', true)
                            ->where('checked_by_stor', true)
                            ->where('checked_by_acc', true)
                            ->get();
                    @endphp
                    @foreach($reports as $index => $report)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $report->jenis_barang }}</td>
                        <td>{{ $report->nomor_produksi }}</td>
                        <td>{{ $report->nomor_batch }}</td>
                        <td>
                            <a href="{{ route('arsip-reports.show', $report->uuid) }}"
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
        $('#arsip-table').DataTable();
    });
</script>
@endsection