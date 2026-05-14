<div wire:poll.60s class="space-y-4">

    <!-- Alert Banner -->
    <div class="bg-red-50 border border-red-200 rounded-2xl p-4 flex items-start gap-3">
        <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-red-800 text-sm">Pasien Overstay Terdeteksi</p>
            <p class="text-red-600 text-xs mt-0.5">
                Daftar di bawah menampilkan pasien aktif dengan LOS ≥ 6 hari yang melebihi standar rawat inap RS.
                Segera koordinasikan rencana pemulangan dengan DPJP.
            </p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input wire:model.live.debounce.300ms="search" type="text"
                    placeholder="Cari nama atau No. RM..."
                    class="w-full pl-9 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-400/30 focus:border-red-400 transition-all">
            </div>

            <select wire:model.live="filterDpjp"
                class="border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-red-400/30 focus:border-red-400 transition-all">
                <option value="">Semua DPJP</option>
                @foreach($dokters as $dokter)
                    <option value="{{ $dokter->id }}">{{ $dokter->name }}</option>
                @endforeach
            </select>

            <select wire:model.live="filterKelas"
                class="border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-red-400/30 focus:border-red-400 transition-all">
                <option value="">Semua Kelas BPJS</option>
                <option value="Kelas 1">Kelas 1</option>
                <option value="Kelas 2">Kelas 2</option>
                <option value="Kelas 3">Kelas 3</option>
                <option value="Non-BPJS">Non-BPJS</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-5 py-3 bg-red-50 border-b border-red-100 flex items-center justify-between">
            <span class="text-sm font-semibold text-red-800">
                {{ count($patients) }} Pasien Overstay Ditemukan
            </span>
            <span class="text-xs text-red-600">Auto-refresh setiap 60 detik</span>
        </div>
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">DPJP</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">LOS (Hari)</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Kelebihan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($patients as $index => $patient)
                    <tr class="bg-red-50 hover:bg-red-100 transition-colors">
                        <td class="px-4 py-3 text-sm text-slate-500">{{ $index + 1 }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-red-500 flex-shrink-0 pulse-slow"></span>
                                <span class="text-sm font-bold text-slate-800">{{ $patient->nama_pasien }}</span>
                            </div>
                            @if($patient->ruangan)
                                <p class="text-xs text-slate-400 ml-4">{{ $patient->ruangan }}</p>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm font-mono text-slate-600">{{ $patient->no_rm }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs bg-slate-100 border border-slate-200 text-slate-600 px-2 py-0.5 rounded-full">{{ $patient->kelas_bpjs }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-600 max-w-[160px]">
                            <span class="truncate block" title="{{ $patient->diagnosis }}">{{ $patient->diagnosis }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ $patient->tanggal_masuk->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ $patient->dpjp->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-red-500 text-white font-bold text-lg shadow-sm">
                                {{ $patient->los }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="text-sm font-bold text-red-700 bg-red-100 border border-red-200 px-2.5 py-1 rounded-full">
                                +{{ $patient->los - 5 }} hari
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-16 text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-slate-500 font-semibold">Tidak ada pasien overstay saat ini</p>
                            <p class="text-slate-400 text-sm mt-1">Semua pasien aktif masih dalam batas LOS standar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
