<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RejectedReport;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->role;

        // Hitung dokumen menunggu ditangani
        // (report yang visible untuk user ini di Rejected Report Index)
        $menunggu = $this->countMenunggu($role);

        // Hitung dokumen ditangani bulan ini
        // (report yang selesai disign semua, bulan ini)
        $ditangani = RejectedReport::where('checked_by_qc', true)
            ->where('checked_by_prod', true)
            ->where('checked_by_ppic', true)
            ->where('checked_by_merch', true)
            ->where('checked_by_stor', true)
            ->where('checked_by_acc', true)
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->count();

        return view('dashboard', compact('menunggu', 'ditangani'));
    }

    private function countMenunggu(string $role): int
    {
        return match($role) {
            'Admin', 'Supervisor QC' => RejectedReport::where(function($q) {
                $q->where('checked_by_qc', false)
                  ->orWhere(function($q2) {
                      $q2->where('checked_by_qc', true)
                         ->where('checked_by_prod', false)
                         ->where('checked_by_ppic', false)
                         ->where('checked_by_merch', false)
                         ->where('checked_by_stor', false)
                         ->where('checked_by_acc', false);
                  });
            })->count(),
            'Supervisor Produksi' => RejectedReport::where('checked_by_qc', true)
                ->where('checked_by_prod', false)->count(),
            'PPIC' => RejectedReport::where('checked_by_qc', true)
                ->where('checked_by_prod', true)
                ->where('checked_by_ppic', false)->count(),
            'Merchandiser' => RejectedReport::where('checked_by_qc', true)
                ->where('checked_by_prod', true)
                ->where('checked_by_ppic', true)
                ->where('checked_by_merch', false)->count(),
            'Gudang' => RejectedReport::where('checked_by_qc', true)
                ->where('checked_by_prod', true)
                ->where('checked_by_ppic', true)
                ->where('checked_by_merch', true)
                ->where('checked_by_stor', false)->count(),
            'Akunting' => RejectedReport::where('checked_by_qc', true)
                ->where('checked_by_prod', true)
                ->where('checked_by_ppic', true)
                ->where('checked_by_merch', true)
                ->where('checked_by_stor', true)
                ->where('checked_by_acc', false)->count(),
            default => 0,
        };
    }
}
