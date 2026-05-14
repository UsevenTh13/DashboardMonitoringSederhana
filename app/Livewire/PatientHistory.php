<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;

class PatientHistory extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterDpjp = '';
    public string $filterKelas = '';
    public string $filterBulan = '';
    public string $filterTahun = '';

    protected $paginationTheme = 'tailwind';

    public function mount(): void
    {
        $this->filterBulan = Carbon::now()->month;
        $this->filterTahun = Carbon::now()->year;
    }

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingFilterDpjp(): void { $this->resetPage(); }
    public function updatingFilterKelas(): void { $this->resetPage(); }
    public function updatingFilterBulan(): void { $this->resetPage(); }
    public function updatingFilterTahun(): void { $this->resetPage(); }

    public function render()
    {
        $query = Patient::pulang()
            ->with(['dpjp', 'inputBy'])
            ->when($this->search, function ($q) {
                $q->where(function ($q2) {
                    $q2->where('nama_pasien', 'like', "%{$this->search}%")
                       ->orWhere('no_rm', 'like', "%{$this->search}%")
                       ->orWhere('diagnosis', 'like', "%{$this->search}%");
                });
            })
            ->when($this->filterDpjp, fn($q) => $q->where('dpjp_id', $this->filterDpjp))
            ->when($this->filterKelas, fn($q) => $q->where('kelas_bpjs', $this->filterKelas))
            ->when($this->filterBulan, fn($q) => $q->whereMonth('tanggal_keluar', $this->filterBulan))
            ->when($this->filterTahun, fn($q) => $q->whereYear('tanggal_keluar', $this->filterTahun))
            ->orderBy('tanggal_keluar', 'desc');

        $patients = $query->paginate(15);

        // Statistik dari hasil filter (tanpa pagination)
        $allFiltered = $query->get();
        $avgLos = $allFiltered->avg('los_final') ?? 0;
        $totalOvrstay = $allFiltered->filter(fn($p) => $p->los_final >= 6)->count();

        $dokters = User::where('role', 'dokter')->orderBy('name')->get();

        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        return view('livewire.patient-history', [
            'patients'    => $patients,
            'dokters'     => $dokters,
            'avgLos'      => round($avgLos, 1),
            'totalOvrstay'=> $totalOvrstay,
            'bulanList'   => $bulanList,
        ]);
    }
}
