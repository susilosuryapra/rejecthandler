<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Report Barang Reject - {{ $report->nomor_batch }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; }
        th { background-color: #f2f2f2; width: 30%; }
        .tracker { margin-top: 20px; }
        .tracker table th { text-align: center; }
        .tracker table td { text-align: center; }
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
            <td>{{ $report->catatan ?? '-' }}</td>
        </tr>
    </table>

    <div class="tracker">
        <h4>Tracker Signing</h4>
        <table>
            <tr>
                <th>SPV QC</th>
                <th>SPV PROD</th>
                <th>PPIC</th>
                <th>Merch</th>
                <th>Gudang</th>
                <th>Account</th>
            </tr>
            <tr>
                <td>✓</td>
                <td>✓</td>
                <td>✓</td>
                <td>✓</td>
                <td>✓</td>
                <td>✓</td>
            </tr>
        </table>
    </div>
</body>
</html>