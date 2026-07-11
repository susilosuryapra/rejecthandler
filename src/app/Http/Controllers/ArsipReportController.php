<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RejectedReport;
use Barryvdh\DomPDF\Facade\Pdf;

class ArsipReportController extends Controller
{
    public function index()
    {
        return view('arsip-reports.index');
    }

    public function show(string $uuid)
    {
        $report = RejectedReport::where('uuid', $uuid)
            ->where('checked_by_qc', true)
            ->where('checked_by_prod', true)
            ->where('checked_by_ppic', true)
            ->where('checked_by_merch', true)
            ->where('checked_by_stor', true)
            ->where('checked_by_acc', true)
            ->firstOrFail();

        return view('arsip-reports.show', compact('report'));
    }

    public function download(string $uuid)
    {
        $report = RejectedReport::where('uuid', $uuid)
            ->where('checked_by_qc', true)
            ->where('checked_by_prod', true)
            ->where('checked_by_ppic', true)
            ->where('checked_by_merch', true)
            ->where('checked_by_stor', true)
            ->where('checked_by_acc', true)
            ->firstOrFail();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($report)
            ->log('Mendownload report barang reject: ' . $report->nomor_batch);

        $pdf = Pdf::loadView('arsip-reports.pdf', compact('report'));

        return $pdf->download('report-' . $report->nomor_batch . '.pdf');
    }
}
