@extends('adminlte::page')

@section('title', 'Detail Report')

@section('content_header')
    <h1>Detail Report Barang Reject</h1>
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
                        @foreach ($report->jenis_cacat as $cacat)
                            <span class="badge badge-danger">{{ $cacat }}</span>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Keputusan Handling</th>
                    <td>
                        @foreach ($report->keputusan_handling as $handling)
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
                <div class="table-responsive">
                    <table class="table table-bordered table-sm text-center">
                        <thead>
                            <tr>
                                <th>SPV Quality Control</th>
                                <th>SPV Production</th>
                                <th>PPIC</th>
                                <th>Merchandiser</th>
                                <th>Gudang</th>
                                <th>Accounting</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @php
                                    $signers = [
                                        'SPV QC' => $report->checked_by_qc,
                                        'SPV PROD' => $report->checked_by_prod,
                                        'PPIC' => $report->checked_by_ppic,
                                        'Merch' => $report->checked_by_merch,
                                        'Gudang' => $report->checked_by_stor,
                                        'Account' => $report->checked_by_acc,
                                    ];
                                @endphp
                                @foreach ($signers as $label => $signed)
                                    <td>
                                        @if ($signed)
                                            <i class="fas fa-check text-success fa-2x"></i>
                                        @else
                                            <i class="fas fa-times text-danger fa-2x"></i>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                @if ($role == 'Admin' || $role == 'Supervisor QC')
                    <a href="{{ route('rejected-reports.edit', $report->uuid) }}" class="btn btn-warning btn-edit">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endif

                @php
                    $canSign = match ($role) {
                        'Supervisor Produksi' => $report->checked_by_qc && !$report->checked_by_prod,
                        'PPIC' => $report->checked_by_qc && $report->checked_by_prod && !$report->checked_by_ppic,
                        'Merchandiser' => $report->checked_by_qc &&
                            $report->checked_by_prod &&
                            $report->checked_by_ppic &&
                            !$report->checked_by_merch,
                        'Gudang' => $report->checked_by_qc &&
                            $report->checked_by_prod &&
                            $report->checked_by_ppic &&
                            $report->checked_by_merch &&
                            !$report->checked_by_stor,
                        'Akunting' => $report->checked_by_qc &&
                            $report->checked_by_prod &&
                            $report->checked_by_ppic &&
                            $report->checked_by_merch &&
                            $report->checked_by_stor &&
                            !$report->checked_by_acc,
                        default => false,
                    };
                @endphp

                @if ($canSign)
                    <form method="POST" action="{{ route('rejected-reports.sign', $report->uuid) }}" style="display:inline"
                        id="form-sign">
                        @csrf
                        <button type="button" class="btn btn-success btn-sign">
                            <i class="fas fa-signature"></i> Sign
                        </button>
                    </form>
                @endif

                <a href="{{ route('rejected-reports.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </div>
    </div>
@endsection

@section('plugins.Sweetalert2', true)

@section('js')
    <script>
        window.addEventListener('load', function() {
            history.replaceState(null, null, "{{ route('rejected-reports.index') }}");
        });

        // Alert untuk Sign
        $('.btn-sign').click(function() {
            Swal.fire({
                title: 'Konfirmasi Sign',
                text: 'Yakin ingin men-sign report ini?',
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Sign!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    $('#form-sign').submit();
                }
            });
        });

        // Alert untuk Edit
        $('.btn-edit').click(function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            Swal.fire({
                title: 'Konfirmasi Edit',
                text: 'Yakin ingin mengedit report ini?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Edit!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    window.location.href = url;
                }
            });
        });
    </script>
@endsection
