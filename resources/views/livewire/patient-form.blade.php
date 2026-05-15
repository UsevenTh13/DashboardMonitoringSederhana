<div>

    <!-- Success Message -->
    @if($successMessage)
    <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-2 text-sm animate-slide-in">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ $successMessage }}
        <button wire:click="$set('successMessage', '')" class="ml-auto text-green-600 hover:text-green-800">×</button>
    </div>
    @endif

    <!-- Tombol Tambah Pasien -->
    <div class="flex justify-end mb-4">
        <button wire:click="openCreate" id="btn-tambah-pasien"
            class="flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-sm hover:shadow-md active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Pasien Baru
        </button>
    </div>

    <!-- MODAL: Form Pasien -->
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4"
         x-data
         x-on:keydown.escape.window="$wire.closeModal()">

        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" wire:click="closeModal"></div>

        <!-- Modal Panel -->
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto animate-slide-in">

            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">
                        {{ $editingId ? 'Edit Data Pasien' : 'Daftarkan Pasien Baru' }}
                    </h3>
                    <p class="text-sm text-slate-500 mt-0.5">Lengkapi formulir data pasien rawat inap</p>
                </div>
                <button wire:click="closeModal" class="p-2 hover:bg-slate-100 rounded-xl transition-colors">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <form wire:submit="save" class="p-6 space-y-5">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <!-- Nama Pasien -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Nama Pasien <span class="text-red-500">*</span>
                        </label>
                        <input wire:model="nama_pasien" type="text" id="input-nama-pasien"
                            placeholder="Nama lengkap pasien..."
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all @error('nama_pasien') border-red-400 @enderror">
                        @error('nama_pasien')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No Rekam Medis -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">No. Rekam Medis <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="no_rm" 
                            inputmode="numeric" maxlength="8" pattern="[0-9]*"
                            placeholder="Contoh: 12345678"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all
                            @error('no_rm') border-red-400 bg-red-50 @enderror">
                        @error('no_rm') <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Kelas BPJS -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Kelas BPJS <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="kelas_bpjs" id="select-kelas-bpjs"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all @error('kelas_bpjs') border-red-400 @enderror">
                            <option value="">-- Pilih Kelas --</option>
                            <option value="Kelas 1">Kelas 1</option>
                            <option value="Kelas 2">Kelas 2</option>
                            <option value="Kelas 3">Kelas 3</option>
                            <option value="Non-BPJS">Non-BPJS</option>
                        </select>
                        @error('kelas_bpjs')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Diagnosis -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Diagnosis <span class="text-red-500">*</span>
                        </label>
                        <textarea wire:model="diagnosis" id="input-diagnosis" rows="2"
                            placeholder="Masukkan diagnosis utama pasien..."
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all resize-none @error('diagnosis') border-red-400 @enderror"></textarea>
                        @error('diagnosis')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Masuk -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Tanggal Masuk <span class="text-red-500">*</span>
                        </label>
                        <input wire:model="tanggal_masuk" type="date" id="input-tanggal-masuk"
                            max="{{ now()->format('Y-m-d') }}"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all @error('tanggal_masuk') border-red-400 @enderror">
                        @error('tanggal_masuk')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- DPJP -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            DPJP <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="dpjp_id" id="select-dpjp"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all @error('dpjp_id') border-red-400 @enderror">
                            <option value="">-- Pilih Dokter --</option>
                            @foreach($dokters as $dokter)
                                <option value="{{ $dokter->id }}">{{ $dokter->name }}
                                    @if($dokter->spesialisasi)
                                        ({{ $dokter->spesialisasi }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('dpjp_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ruangan -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Ruangan / Kamar</label>
                        <input wire:model="ruangan" type="text" id="input-ruangan"
                            placeholder="Contoh: Mawar 1A"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all">
                    </div>

                    <!-- Catatan -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Catatan</label>
                        <input wire:model="catatan" type="text" id="input-catatan"
                            placeholder="Catatan tambahan..."
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all">
                    </div>

                </div>

                <!-- Form Actions -->
                <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
                    <button type="submit" id="btn-simpan-pasien"
                        class="flex-1 bg-brand-600 hover:bg-brand-700 text-white py-2.5 px-6 rounded-xl font-semibold text-sm transition-all active:scale-95">
                        <span wire:loading.remove wire:target="save">
                            {{ $editingId ? '💾 Simpan Perubahan' : '✅ Daftarkan Pasien' }}
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

    <!-- MODAL: Pasien Pulang -->
    @if($showDischargeModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" wire:click="closeModal"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md animate-slide-in">
            <div class="p-6 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-800">Proses Pemulangan Pasien</h3>
                <p class="text-sm text-slate-500 mt-0.5">Masukkan tanggal pasien dinyatakan pulang</p>
            </div>
            <div class="p-6">
                <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-xl text-sm text-blue-700">
                    ℹ️ LOS pasien akan dihitung otomatis dari tanggal masuk hingga tanggal keluar.
                </div>
                <form wire:submit="discharge" class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Tanggal Keluar <span class="text-red-500">*</span>
                        </label>
                        <input wire:model="tanggal_keluar" type="date" id="input-tanggal-keluar"
                            max="{{ now()->format('Y-m-d') }}"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all">
                        @error('tanggal_keluar')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" id="btn-konfirmasi-pulang"
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2.5 rounded-xl font-semibold text-sm transition-all">
                            ✅ Konfirmasi Pulang
                        </button>
                        <button type="button" wire:click="closeModal"
                            class="px-5 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-sm transition-all">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

</div>
