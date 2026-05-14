<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Patient;
use App\Models\User;

class OverstayFilter extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterDpjp = '';
    public string $filterKelas = '';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingFilterDpjp(): void { $this->resetPage(); }
    public function updatingFilterKelas(): void { $this->resetPage(); }

    public function render()
    {
        // Ambil semua pasien aktif lalu filter yang overstay (LOS >= 6)
        $allAktif = Patient::aktif()
            ->with(['dpjp'])
            ->when($this->search, function ($q) {
                $q->where(function ($q2) {
                    $q2->where('nama_pasien', 'like', "%{$this->search}%")
                       ->orWhere('no_rm', 'like', "%{$this->search}%");
                });
            })
            ->when($this->filterDpjp, fn($q) => $q->where('dpjp_id', $this->filterDpjp))
            ->when($this->filterKelas, fn($q) => $q->where('kelas_bpjs', $this->filterKelas))
            ->orderBy('tanggal_masuk', 'asc')
            ->get();

        // Filter overstay (LOS >= 6) via collection
        $overstayPatients = $allAktif->filter(fn($p) => $p->los >= 6)->values();

        $dokters = User::where('role', 'dokter')->orderBy('name')->get();

        return view('livewire.overstay-filter', [
            'patients' => $overstayPatients,
            'dokters'  => $dokters,
        ]);
    }
}
