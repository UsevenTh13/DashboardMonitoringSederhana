<div class="space-y-6">

    <!-- Success / Error Messages -->
    @if($successMessage)
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-2 text-sm animate-slide-in">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ $successMessage }}
        <button wire:click="$set('successMessage', '')" class="ml-auto text-green-600 hover:text-green-800">×</button>
    </div>
    @endif

    @error('delete')
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center gap-2 text-sm animate-slide-in">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ $message }}
        <button wire:click="$set('errors', null)" class="ml-auto text-red-600 hover:text-red-800">×</button>
    </div>
    @enderror

    <!-- Header & Controls -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
        <div class="flex flex-col md:flex-row gap-4 items-start md:items-center justify-between mb-5">
            <div>
                <h3 class="font-bold text-slate-800 text-lg">Daftar Pengguna Sistem</h3>
                <p class="text-sm text-slate-500 mt-1">Kelola akun dokter dan perawat.</p>
            </div>
            <button wire:click="$dispatch('open-create-user')"
                class="flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-sm active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Pengguna
            </button>
        </div>

        <!-- Filters -->
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input wire:model.live.debounce.300ms="search" type="text"
                    placeholder="Cari nama, email, atau spesialisasi..."
                    class="w-full pl-9 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all">
            </div>
            <select wire:model.live="filterRole"
                class="border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all w-full sm:w-48">
                <option value="">Semua Role</option>
                <option value="dokter">Dokter</option>
                <option value="perawat">Perawat</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200">
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pengguna</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kontak</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Role</th>
                        <th class="px-5 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-sm flex-shrink-0
                                    @if($user->role === 'admin') bg-gradient-to-br from-purple-500 to-purple-700
                                    @elseif($user->role === 'dokter') bg-gradient-to-br from-sky-400 to-blue-600
                                    @else bg-gradient-to-br from-emerald-400 to-green-600 @endif">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800 text-sm">{{ $user->name }}</p>
                                    @if($user->spesialisasi && $user->role === 'dokter')
                                        <p class="text-xs text-slate-500">{{ $user->spesialisasi }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-sm text-slate-700">{{ $user->email }}</p>
                            @if($user->no_hp)
                                <p class="text-xs text-slate-500 mt-0.5">{{ $user->no_hp }}</p>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            @if($user->role === 'admin')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span> Admin
                                </span>
                            @elseif($user->role === 'dokter')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-100 text-sky-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span> Dokter
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Perawat
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button wire:click="$dispatch('edit-user', { id: {{ $user->id }} })"
                                    class="p-2 text-brand-600 hover:bg-brand-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button wire:click="$dispatch('delete-user', { id: {{ $user->id }} })"
                                    onclick="confirm('Apakah Anda yakin ingin menghapus akun ini?') || event.stopImmediatePropagation()"
                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-12 text-center">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-100 mb-3">
                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <p class="text-slate-500 font-medium">Tidak ada pengguna ditemukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
        <div class="px-5 py-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
        @endif
    </div>

    <!-- MODAL: Form User -->
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4"
         x-data="{ role: @entangle('role') }"
         x-on:keydown.escape.window="$wire.closeModal()">
        
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" wire:click="closeModal"></div>
        
        <!-- Modal Panel -->
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-xl max-h-[90vh] overflow-y-auto animate-slide-in">
            <div class="flex items-center justify-between p-6 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">
                        {{ $editingId ? 'Edit Data Pengguna' : 'Tambah Pengguna Baru' }}
                    </h3>
                    <p class="text-sm text-slate-500 mt-0.5">Isi informasi akun pengguna dengan benar.</p>
                </div>
                <button wire:click="closeModal" class="p-2 hover:bg-slate-100 rounded-xl transition-colors">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form wire:submit="save" class="p-6 space-y-5">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Nama -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input wire:model="name" type="text" placeholder="Masukkan nama lengkap"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all @error('name') border-red-400 @enderror">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                        <input wire:model="email" type="email" placeholder="contoh@rsarifin.id"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all @error('email') border-red-400 @enderror">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- No HP -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">No. HP / WhatsApp</label>
                        <input wire:model="no_hp" type="text" placeholder="08..."
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all @error('no_hp') border-red-400 @enderror">
                        @error('no_hp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Role <span class="text-red-500">*</span></label>
                        <select wire:model.live="role" 
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all @error('role') border-red-400 @enderror">
                            <option value="">-- Pilih Role --</option>
                            <option value="dokter">Dokter</option>
                            <option value="perawat">Perawat</option>
                        </select>
                        @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Spesialisasi (Hanya Dokter) -->
                    <div x-show="role === 'dokter'" class="transition-all duration-300">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Spesialisasi <span class="text-red-500">*</span></label>
                        <input wire:model="spesialisasi" type="text" placeholder="Contoh: Penyakit Dalam"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all @error('spesialisasi') border-red-400 @enderror">
                        @error('spesialisasi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Password -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Password @if(!$editingId) <span class="text-red-500">*</span> @endif
                        </label>
                        <input wire:model="password" type="password" placeholder="{{ $editingId ? 'Kosongkan jika tidak ingin mengubah password' : 'Buat password baru' }}"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all @error('password') border-red-400 @enderror">
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        @if($editingId)
                            <p class="text-xs text-slate-500 mt-1.5">Biarkan kosong jika Anda tidak ingin mengganti password pengguna ini.</p>
                        @endif
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center gap-3 pt-3 border-t border-slate-100">
                    <button type="submit"
                        class="flex-1 bg-brand-600 hover:bg-brand-700 text-white py-2.5 px-6 rounded-xl font-semibold text-sm transition-all active:scale-95 shadow-sm">
                        <span wire:loading.remove wire:target="save">
                            {{ $editingId ? '💾 Simpan Perubahan' : '✅ Tambah Pengguna' }}
                        </span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                    <button type="button" wire:click="closeModal"
                        class="px-6 py-2.5 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl font-medium text-sm transition-all">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
