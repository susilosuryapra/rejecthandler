<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RejectedReport;

class RejectedReportController extends Controller
{
    // Pilihan checkbox yang tersedia
    private array $jenisCacatOptions = [
        'Berlubang',
        'Cacat Jahit',
        'Cacat Warna',
    ];

    private array $keputusanHandlingOptions = [
        'Rework',
        'Dispose',
        'Dipajang untuk training',
        'Dijual murah',
    ];

    public function index()
    {
        $role = auth()->user()->role;
        return view('rejected-reports.index', compact('role'));
    }

    public function create()
    {
        $jenisCacatOptions = $this->jenisCacatOptions;
        $keputusanHandlingOptions = $this->keputusanHandlingOptions;
        return view('rejected-reports.create', compact('jenisCacatOptions', 'keputusanHandlingOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_barang'         => 'required|string',
            'nomor_produksi'       => 'required|string',
            'nomor_batch'          => 'required|string',
            'jumlah_barang'        => 'required|integer|min:1',
            'jenis_cacat'          => 'required|array|min:1',
            'keputusan_handling'   => 'required|array|min:1',
            'catatan'              => 'nullable|string',
        ]);

        $report = RejectedReport::create([
            'tanggal'              => now(),
            'jenis_barang'         => $request->jenis_barang,
            'nomor_produksi'       => $request->nomor_produksi,
            'nomor_batch'          => $request->nomor_batch,
            'jumlah_barang'        => $request->jumlah_barang,
            'jenis_cacat'          => $request->jenis_cacat,
            'keputusan_handling'   => $request->keputusan_handling,
            'catatan'              => $request->catatan,
            'created_by_user_id'   => auth()->user()->user_id,
            'checked_by_qc'        => true, // Supervisor QC otomatis checked saat membuat
        ]);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($report)
            ->log('Membuat report barang reject: ' . $report->nomor_batch);

        return redirect()->route('rejected-reports.index')
            ->with('success', 'Report berhasil dibuat.');
    }

    public function show(string $uuid)
    {
        $report = RejectedReport::where('uuid', $uuid)->firstOrFail();
        $role = auth()->user()->role;
        return view('rejected-reports.show', compact('report', 'role'));
    }

    public function edit(string $uuid)
    {
        $report = RejectedReport::where('uuid', $uuid)->firstOrFail();
        $jenisCacatOptions = $this->jenisCacatOptions;
        $keputusanHandlingOptions = $this->keputusanHandlingOptions;
        return view('rejected-reports.edit', compact('report', 'jenisCacatOptions', 'keputusanHandlingOptions'));
    }

    public function update(Request $request, string $uuid)
    {
        $report = RejectedReport::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'jenis_barang'         => 'required|string',
            'nomor_produksi'       => 'required|string',
            'nomor_batch'          => 'required|string',
            'jumlah_barang'        => 'required|integer|min:1',
            'jenis_cacat'          => 'required|array|min:1',
            'keputusan_handling'   => 'required|array|min:1',
            'catatan'              => 'nullable|string',
        ]);

        $report->update([
            'jenis_barang'         => $request->jenis_barang,
            'nomor_produksi'       => $request->nomor_produksi,
            'nomor_batch'          => $request->nomor_batch,
            'jumlah_barang'        => $request->jumlah_barang,
            'jenis_cacat'          => $request->jenis_cacat,
            'keputusan_handling'   => $request->keputusan_handling,
            'catatan'              => $request->catatan,
        ]);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($report)
            ->log('Mengupdate report barang reject: ' . $report->nomor_batch);

        return redirect()->route('rejected-reports.index')
            ->with('success', 'Report berhasil diupdate.');
    }

    public function destroy(string $uuid)
    {
        $report = RejectedReport::where('uuid', $uuid)->firstOrFail();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($report)
            ->log('Menghapus report barang reject: ' . $report->nomor_batch);

        $report->delete();

        return redirect()->route('rejected-reports.index')
            ->with('success', 'Report berhasil dihapus.');
    }

    public function sign(string $uuid)
    {
        $report = RejectedReport::where('uuid', $uuid)->firstOrFail();
        $role = auth()->user()->role;

        $columnMap = [
            'Supervisor Produksi' => 'checked_by_prod',
            'PPIC'                => 'checked_by_ppic',
            'Merchandiser'        => 'checked_by_merch',
            'Gudang'              => 'checked_by_stor',
            'Akunting'            => 'checked_by_acc',
        ];

        if (!isset($columnMap[$role])) {
            abort(403, 'Role Anda tidak bisa melakukan signing.');
        }

        $column = $columnMap[$role];
        $report->update([$column => true]);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($report)
            ->log('Menyetujui report barang reject: ' . $report->nomor_batch);

        return redirect()->route('rejected-reports.index')
            ->with('success', 'Report berhasil di-sign.');
    }
}
