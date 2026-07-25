<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Report Barang Reject - {{ $report->nomor_batch }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            width: 30%;
        }

        .tracker {
            margin-top: 20px;
        }

        .tracker table th {
            text-align: center;
        }

        .tracker table td {
            text-align: center;
        }

        .check {
            color: #000;
            font-weight: bold;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <h2>Report Barang Reject</h2>
    <h4 style="text-align:center">{{ $report->nomor_batch }}</h4>

    <table>
        <tr>
            <th>Tanggal</th>
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
            <td>{{ implode(', ', $report->jenis_cacat) }}</td>
        </tr>
        <tr>
            <th>Keputusan Handling</th>
            <td>{{ implode(', ', $report->keputusan_handling) }}</td>
        </tr>
        <tr>
            <th>Catatan</th>
            <td>{!! nl2br(e($report->catatan ?? '-')) !!}</td>
        </tr>
    </table>

    <div class="tracker">
        <h4>Tracker Signing</h4>
        <table>
            <tr>
                <th>SPV QC</th>
                <th>SPV PROD</th>
                <th>PPIC</th>
                <th>Merchandiser</th>
                <th>Gudang</th>
                <th>Accountant</th>
            </tr>
            <tr>
                <td class="check">{{ $report->checked_by_qc ? '✓' : '-' }}</td>
                <td class="check">{{ $report->checked_by_prod ? '✓' : '-' }}</td>
                <td class="check">{{ $report->checked_by_ppic ? '✓' : '-' }}</td>
                <td class="check">{{ $report->checked_by_merch ? '✓' : '-' }}</td>
                <td class="check">{{ $report->checked_by_stor ? '✓' : '-' }}</td>
                <td class="check">{{ $report->checked_by_acc ? '✓' : '-' }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
