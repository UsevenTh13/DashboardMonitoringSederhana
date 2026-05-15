<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class UserManagement extends Component
{
    use WithPagination;

    // Form fields
    public string $name = '';
    public string $username = '';
    public string $password = '';
    public string $role = '';
    public string $no_hp = '';
    public string $spesialisasi = '';

    // State
    public bool $showModal = false;
    public ?int $editingId = null;
    public string $search = '';
    public string $filterRole = '';
    public string $successMessage = '';

    protected function rules(): array
    {
        $usernameRule = $this->editingId
            ? 'required|string|unique:users,username,' . $this->editingId
            : 'required|string|unique:users,username';

        $passwordRule = $this->editingId ? 'nullable|min:6' : 'required|min:6';

        return [
            'name'         => 'required|string|max:255',
            'username'     => $usernameRule,
            'password'     => $passwordRule,
            'role'         => 'required|in:dokter,perawat',
            'no_hp'        => 'nullable|string|max:20',
            'spesialisasi' => 'nullable|string|max:100',
        ];
    }

    protected $messages = [
        'name.required'     => 'Nama wajib diisi.',
        'username.required' => 'Username wajib diisi.',
        'username.unique'   => 'Username sudah digunakan.',
        'password.required' => 'Password wajib diisi untuk pengguna baru.',
        'password.min'      => 'Password minimal 6 karakter.',
        'role.required'     => 'Role wajib dipilih.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterRole()
    {
        $this->resetPage();
    }

    #[On('open-create-user')]
    public function openCreate(): void
    {
        $this->reset(['name', 'username', 'password', 'role', 'no_hp', 'spesialisasi', 'editingId']);
        $this->showModal = true;
    }

    #[On('edit-user')]
    public function openEdit(int $id): void
    {
        $user = User::findOrFail($id);
        $this->editingId    = $id;
        $this->name         = $user->name;
        $this->username     = $user->username;
        $this->role         = $user->role;
        $this->no_hp        = $user->no_hp ?? '';
        $this->spesialisasi = $user->spesialisasi ?? '';
        // Kosongkan password saat edit, hanya diisi jika ingin diubah
        $this->password     = '';
        
        $this->showModal    = true;
    }

    public function save(): void
    {
        $this->validate();

        // Validasi spesialisasi khusus dokter
        if ($this->role === 'dokter' && empty($this->spesialisasi)) {
            $this->addError('spesialisasi', 'Spesialisasi wajib diisi untuk role Dokter.');
            return;
        }
        
        // Bersihkan spesialisasi jika bukan dokter
        if ($this->role !== 'dokter') {
            $this->spesialisasi = '';
        }

        $data = [
            'name'         => $this->name,
            'username'     => $this->username,
            'role'         => $this->role,
            'no_hp'        => $this->no_hp ?: null,
            'spesialisasi' => $this->spesialisasi ?: null,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->editingId) {
            User::findOrFail($this->editingId)->update($data);
            $this->successMessage = "Data pengguna {$this->name} berhasil diperbarui.";
        } else {
            User::create($data);
            $this->successMessage = "Pengguna {$this->name} berhasil ditambahkan.";
        }

        $this->closeModal();
    }

    #[On('delete-user')]
    public function delete(int $id): void
    {
        $user = User::findOrFail($id);
        
        // Cegah admin menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            $this->addError('delete', 'Anda tidak dapat menghapus akun Anda sendiri.');
            return;
        }

        $name = $user->name;
        $user->delete();
        $this->successMessage = "Akun pengguna {$name} berhasil dihapus.";
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['name', 'username', 'password', 'role', 'no_hp', 'spesialisasi', 'editingId']);
    }

    public function render()
    {
        $query = User::query()->where('role', '!=', 'admin');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('username', 'like', '%' . $this->search . '%')
                  ->orWhere('spesialisasi', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterRole) {
            $query->where('role', $this->filterRole);
        }

        $users = $query->orderBy('name')->paginate(10);

        return view('livewire.user-management', [
            'users' => $users,
        ]);
    }
}
