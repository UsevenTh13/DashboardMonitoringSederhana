<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Patient;
use App\Models\User;

class PatientMonitor extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterDpjp = '';
    public string $filterKelas = '';

    protected $paginationTheme = 'tailwind';

    protected $listeners = ['patient-updated' => '$refresh'];

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingFilterDpjp(): void { $this->resetPage(); }
    public function updatingFilterKelas(): void { $this->resetPage(); }

    public function render()
    {
        $query = Patient::aktif()
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
            ->orderBy('tanggal_masuk', 'asc');

        $patients = $query->paginate(15);
        $dokters = User::where('role', 'dokter')->orderBy('name')->get();

        return view('livewire.patient-monitor', [
            'patients' => $patients,
            'dokters'  => $dokters,
        ]);
    }
}
