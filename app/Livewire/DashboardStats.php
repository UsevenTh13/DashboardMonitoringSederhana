<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Patient;
use Carbon\Carbon;

class DashboardStats extends Component
{
    public int $totalAktif = 0;
    public int $totalOvrstay = 0;
    public int $totalWarning = 0;
    public float $avgLos = 0;
    public int $totalPulangBulanIni = 0;

    public function mount(): void
    {
        $this->loadStats();
    }

    public function loadStats(): void
    {
        $aktifPatients = Patient::aktif()->with('dpjp')->get();

        $this->totalAktif = $aktifPatients->count();

        $this->totalOvrstay = $aktifPatients->filter(function ($p) {
            return $p->warning_status === 'overstay';
        })->count();

        $this->totalWarning = $aktifPatients->filter(function ($p) {
            return $p->warning_status === 'warning';
        })->count();

        $this->avgLos = $aktifPatients->count() > 0
            ? round($aktifPatients->avg(fn($p) => $p->los), 1)
            : 0;

        $this->totalPulangBulanIni = Patient::pulang()
            ->whereYear('tanggal_keluar', Carbon::now()->year)
            ->whereMonth('tanggal_keluar', Carbon::now()->month)
            ->count();
    }

    public function render()
    {
        return view('livewire.dashboard-stats');
    }
}
