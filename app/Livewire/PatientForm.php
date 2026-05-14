<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class PatientForm extends Component
{
    // Form fields
    public string $nama_pasien = '';
    public string $no_rm = '';
    public string $kelas_bpjs = '';
    public string $diagnosis = '';
    public string $tanggal_masuk = '';
    public int|string $dpjp_id = '';
    public string $ruangan = '';
    public string $catatan = '';

    // State
    public bool $showModal = false;
    public bool $showDischargeModal = false;
    public ?int $editingId = null;
    public ?int $dischargingId = null;
    public string $tanggal_keluar = '';
    public string $successMessage = '';
    public string $errorMessage = '';

    protected function rules(): array
    {
        $rmRule = $this->editingId
            ? 'required|string|max:50|unique:patients,no_rm,' . $this->editingId
            : 'required|string|max:50|unique:patients,no_rm,NULL,id,status,aktif';

        return [
            'nama_pasien'  => 'required|string|max:255',
            'no_rm'        => $rmRule,
            'kelas_bpjs'   => 'required|in:Kelas 1,Kelas 2,Kelas 3,Non-BPJS',
            'diagnosis'    => 'required|string|max:500',
            'tanggal_masuk'=> 'required|date|before_or_equal:today',
            'dpjp_id'      => 'required|exists:users,id',
            'ruangan'      => 'nullable|string|max:100',
            'catatan'      => 'nullable|string|max:1000',
        ];
    }

    protected $messages = [
        'nama_pasien.required'   => 'Nama pasien wajib diisi.',
        'no_rm.required'         => 'No. Rekam Medis wajib diisi.',
        'no_rm.unique'           => 'No. RM ini sudah digunakan oleh pasien aktif lain.',
        'kelas_bpjs.required'    => 'Kelas BPJS wajib dipilih.',
        'kelas_bpjs.in'          => 'Kelas BPJS tidak valid.',
        'diagnosis.required'     => 'Diagnosis wajib diisi.',
        'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
        'tanggal_masuk.before_or_equal' => 'Tanggal masuk tidak boleh lebih dari hari ini.',
        'dpjp_id.required'       => 'DPJP wajib dipilih.',
        'dpjp_id.exists'         => 'DPJP tidak ditemukan.',
    ];

    #[On('open-create-form')]
    public function openCreate(): void
    {
        $this->reset(['nama_pasien', 'no_rm', 'kelas_bpjs', 'diagnosis', 'tanggal_masuk', 'dpjp_id', 'ruangan', 'catatan', 'editingId', 'errorMessage']);
        $this->tanggal_masuk = now()->format('Y-m-d');
        $this->showModal = true;
    }

    #[On('edit-patient')]
    public function openEdit(int $id): void
    {
        $patient = Patient::findOrFail($id);
        $this->editingId      = $id;
        $this->nama_pasien    = $patient->nama_pasien;
        $this->no_rm          = $patient->no_rm;
        $this->kelas_bpjs     = $patient->kelas_bpjs;
        $this->diagnosis      = $patient->diagnosis;
        $this->tanggal_masuk  = $patient->tanggal_masuk->format('Y-m-d');
        $this->dpjp_id        = $patient->dpjp_id;
        $this->ruangan        = $patient->ruangan ?? '';
        $this->catatan        = $patient->catatan ?? '';
        $this->errorMessage   = '';
        $this->showModal      = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'nama_pasien'  => $this->nama_pasien,
            'no_rm'        => strtoupper(trim($this->no_rm)),
            'kelas_bpjs'   => $this->kelas_bpjs,
            'diagnosis'    => $this->diagnosis,
            'tanggal_masuk'=> $this->tanggal_masuk,
            'dpjp_id'      => $this->dpjp_id,
            'ruangan'      => $this->ruangan ?: null,
            'catatan'      => $this->catatan ?: null,
        ];

        if ($this->editingId) {
            Patient::findOrFail($this->editingId)->update($data);
            $this->successMessage = "Data pasien {$this->nama_pasien} berhasil diperbarui.";
        } else {
            $data['status']     = 'aktif';
            $data['created_by'] = Auth::id();
            Patient::create($data);
            $this->successMessage = "Pasien {$this->nama_pasien} berhasil didaftarkan.";
        }

        $this->closeModal();
        $this->dispatch('patient-updated');
    }

    #[On('discharge-patient')]
    public function openDischarge(int $id): void
    {
        $this->dischargingId = $id;
        $this->tanggal_keluar = now()->format('Y-m-d');
        $this->showDischargeModal = true;
    }

    public function discharge(): void
    {
        $this->validate([
            'tanggal_keluar' => 'required|date|after_or_equal:tanggal_masuk',
        ], [
            'tanggal_keluar.required' => 'Tanggal keluar wajib diisi.',
            'tanggal_keluar.after_or_equal' => 'Tanggal keluar harus setelah tanggal masuk.',
        ]);

        $patient = Patient::findOrFail($this->dischargingId);
        $los = $patient->tanggal_masuk->diffInDays(Carbon::parse($this->tanggal_keluar));

        $patient->update([
            'status'         => 'pulang',
            'tanggal_keluar' => $this->tanggal_keluar,
            'los_final'      => $los,
        ]);

        $this->successMessage = "Pasien {$patient->nama_pasien} berhasil dipulangkan. LOS: {$los} hari.";
        $this->showDischargeModal = false;
        $this->dischargingId = null;
        $this->dispatch('patient-updated');
    }

    public function delete(int $id): void
    {
        $patient = Patient::findOrFail($id);
        $name = $patient->nama_pasien;
        $patient->delete();
        $this->successMessage = "Data pasien {$name} berhasil dihapus.";
        $this->dispatch('patient-updated');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->showDischargeModal = false;
        $this->reset(['nama_pasien', 'no_rm', 'kelas_bpjs', 'diagnosis', 'tanggal_masuk', 'dpjp_id', 'ruangan', 'catatan', 'editingId', 'dischargingId', 'errorMessage']);
    }

    public function render()
    {
        $dokters = User::where('role', 'dokter')->orderBy('name')->get();

        return view('livewire.patient-form', [
            'dokters' => $dokters,
        ]);
    }
}
