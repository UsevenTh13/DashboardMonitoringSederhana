<div class="space-y-4">

    <!-- Statistik Ringkasan -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
            <p class="text-xs text-slate-500 font-medium">Total Riwayat</p>
            <p class="text-2xl font-bold text-slate-800 mt-1">{{ $patients->total() }}</p>
            <p class="text-xs text-slate-400 mt-0.5">Pasien</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
            <p class="text-xs text-slate-500 font-medium">Rata-rata LOS</p>
            <p class="text-2xl font-bold text-purple-700 mt-1">{{ $avgLos }}</p>
            <p class="text-xs text-slate-400 mt-0.5">Hari</p>
        </div>
        <div class="bg-white rounded-2xl border {{ $totalOvrstay > 0 ? 'border-red-200' : 'border-slate-200' }} shadow-sm p-4">
            <p class="text-xs text-slate-500 font-medium">Overstay</p>
            <p class="text-2xl font-bold {{ $totalOvrstay > 0 ? 'text-red-600' : 'text-slate-800' }} mt-1">{{ $totalOvrstay }}</p>
            <p class="text-xs text-slate-400 mt-0.5">Kasus</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
            <p class="text-xs text-slate-500 font-medium">Bulan</p>
            <p class="text-lg font-bold text-slate-800 mt-1">
                {{ $bulanList[$filterBulan] ?? 'Semua' }}
            </p>
            <p class="text-xs text-slate-400 mt-0.5">{{ $filterTahun }}</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
        <p class="text-sm font-semibold text-slate-700 mb-3">Filter Riwayat</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div class="relative lg:col-span-2">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input wire:model.live.debounce.300ms="search" type="text"
                    placeholder="Cari nama, No. RM, diagnosis..."
                    class="w-full pl-9 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all">
            </div>

            <select wire:model.live="filterBulan"
                class="border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all">
                <option value="">Semua Bulan</option>
                @foreach($bulanList as $num => $nama)
                    <option value="{{ $num }}">{{ $nama }}</option>
                @endforeach
            </select>

            <select wire:model.live="filterDpjp"
                class="border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all">
                <option value="">Semua DPJP</option>
                @foreach($dokters as $dokter)
                    <option value="{{ $dokter->id }}">{{ $dokter->name }}</option>
                @endforeach
            </select>

            <select wire:model.live="filterKelas"
                class="border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-400/30 focus:border-brand-400 transition-all">
                <option value="">Semua Kelas</option>
                <option value="Kelas 1">Kelas 1</option>
                <option value="Kelas 2">Kelas 2</option>
                <option value="Kelas 3">Kelas 3</option>
                <option value="Non-BPJS">Non-BPJS</option>
            </select>
        </div>
    </div>

    <!-- Table Riwayat -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Pasien</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No. RM</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Kelas BPJS</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Diagnosis</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tgl Masuk</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tgl Keluar</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">DPJP</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">LOS</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Status LOS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($patients as $index => $patient)
                    @php
                        $isOvr = $patient->los_final >= 6;
                        $isWrn = $patient->los_final >= 4 && $patient->los_final < 6;
                    @endphp
                    <tr class="{{ $isOvr ? 'bg-red-50' : ($isWrn ? 'bg-yellow-50' : 'bg-green-50') }} hover:opacity-90 transition-opacity">
                        <td class="px-4 py-3 text-sm text-slate-500">{{ $patients->firstItem() + $index }}</td>
                        <td class="px-4 py-3 text-sm font-semibold text-slate-800">{{ $patient->nama_pasien }}</td>
                        <td class="px-4 py-3 text-sm font-mono text-slate-600">{{ $patient->no_rm }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs bg-slate-100 border border-slate-200 text-slate-600 px-2 py-0.5 rounded-full">{{ $patient->kelas_bpjs }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-600 max-w-[160px]">
                            <span class="truncate block" title="{{ $patient->diagnosis }}">{{ $patient->diagnosis }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ $patient->tanggal_masuk->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ $patient->tanggal_keluar?->format('d/m/Y') ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ $patient->dpjp->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center justify-center w-9 h-9 rounded-full
                                {{ $isOvr ? 'bg-red-500' : ($isWrn ? 'bg-yellow-500' : 'bg-green-500') }}
                                text-white font-bold text-sm">
                                {{ $patient->los_final }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($isOvr)
                                <span class="text-xs font-semibold bg-red-100 border border-red-200 text-red-700 px-2.5 py-1 rounded-full">🔴 Overstay</span>
                            @elseif($isWrn)
                                <span class="text-xs font-semibold bg-yellow-100 border border-yellow-200 text-yellow-700 px-2.5 py-1 rounded-full">🟡 Mendekati</span>
                            @else
                                <span class="text-xs font-semibold bg-green-100 border border-green-200 text-green-700 px-2.5 py-1 rounded-full">🟢 Normal</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-4 py-16 text-center">
                            <svg class="w-16 h-16 mx-auto text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-slate-400 font-medium">Belum ada riwayat pasien</p>
                            <p class="text-slate-300 text-sm mt-1">Data akan muncul setelah pasien dipulangkan</p>
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
</div>
