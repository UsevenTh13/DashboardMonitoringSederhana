<div wire:poll.60s class="space-y-4">

    <!-- Header & Filters -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
        <div class="flex flex-col md:flex-row gap-3 items-start md:items-center justify-between mb-4">
            <h3 class="font-semibold text-slate-800">Daftar Pasien Aktif</h3>
        </div>

        <!-- Filters -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input wire:model.live.debounce.300ms="search" type="text"
                    placeholder="Cari nama, No. RM, diagnosis..."
                    class="w-full pl-9 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all">
            </div>

            <select wire:model.live="filterDpjp"
                class="border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all">
                <option value="">Semua DPJP</option>
                @foreach($dokters as $dokter)
                    <option value="{{ $dokter->id }}">{{ $dokter->name }}</option>
                @endforeach
            </select>

            <select wire:model.live="filterKelas"
                class="border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all">
                <option value="">Semua Kelas BPJS</option>
                <option value="Kelas 1">Kelas 1</option>
                <option value="Kelas 2">Kelas 2</option>
                <option value="Kelas 3">Kelas 3</option>
                <option value="Non-BPJS">Non-BPJS</option>
            </select>

            <button wire:click="$set('search', ''); $set('filterDpjp', ''); $set('filterKelas', '')"
                class="flex items-center gap-2 justify-center border border-slate-200 hover:bg-slate-50 text-slate-600 px-3 py-2.5 rounded-xl text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Reset
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Pasien</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No. RM</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Kelas BPJS</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Diagnosis</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tgl Masuk</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">DPJP</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">LOS</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        @if(Auth::user()->isPerawat())
                        <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($patients as $index => $patient)
                    @php $color = $patient->warning_color; @endphp
                    <tr class="{{ $color['row'] }} hover:opacity-90 transition-opacity">
                        <td class="px-4 py-3 text-sm text-slate-500">{{ $patients->firstItem() + $index }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full {{ $color['dot'] }} flex-shrink-0"></span>
                                <span class="text-sm font-semibold text-slate-800">{{ $patient->nama_pasien }}</span>
                            </div>
                            @if($patient->ruangan)
                                <p class="text-xs text-slate-400 ml-4">{{ $patient->ruangan }}</p>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm font-mono text-slate-600">{{ $patient->no_rm }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs bg-slate-100 text-slate-600 border border-slate-200 px-2 py-0.5 rounded-full font-medium">
                                {{ $patient->kelas_bpjs }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-600 max-w-[180px]">
                            <span class="truncate block" title="{{ $patient->diagnosis }}">{{ $patient->diagnosis }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ $patient->tanggal_masuk->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ $patient->dpjp->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full {{ $color['dot'] }} text-white font-bold text-sm shadow-sm">
                                {{ $patient->los }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold {{ $color['badge'] }}">
                                {{ $color['icon'] }} {{ $color['label'] }}
                            </span>
                        </td>
                        @if(Auth::user()->isPerawat())
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <button wire:click="$dispatch('edit-patient', { id: {{ $patient->id }} })"
                                    class="p-1.5 text-brand-600 hover:bg-brand-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button wire:click="$dispatch('discharge-patient', { id: {{ $patient->id }} })"
                                    class="p-1.5 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Pulangkan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ Auth::user()->isPerawat() ? 10 : 9 }}" class="px-4 py-16 text-center">
                            <svg class="w-16 h-16 mx-auto text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-slate-400 font-medium">Tidak ada pasien ditemukan</p>
                            <p class="text-slate-300 text-sm mt-1">Coba ubah filter pencarian</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($patients->hasPages())
        <div class="px-4 py-3 border-t border-slate-100">
            {{ $patients->links() }}
        </div>
        @endif
    </div>

    <!-- Loading indicator -->
    <div wire:loading class="fixed bottom-4 right-4 bg-brand-600 text-white px-4 py-2 rounded-xl shadow-xl text-sm flex items-center gap-2 z-50">
        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
        Memuat...
    </div>

</div>
