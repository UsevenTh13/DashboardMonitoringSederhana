<div class="grid grid-cols-2 lg:grid-cols-5 gap-4" wire:poll.60s="loadStats">

    <!-- Total Pasien Aktif -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-slate-500">Total Pasien Aktif</span>
        </div>
        <p class="text-3xl font-bold text-slate-800">{{ $totalAktif }}</p>
        <p class="text-xs text-slate-400 mt-1">Sedang dirawat</p>
    </div>

    <!-- Overstay -->
    <div class="bg-white rounded-2xl shadow-sm border {{ $totalOvrstay > 0 ? 'border-red-200' : 'border-slate-200' }} p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 {{ $totalOvrstay > 0 ? 'bg-red-100' : 'bg-slate-100' }} rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 {{ $totalOvrstay > 0 ? 'text-red-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-slate-500">Overstay (≥6 hari)</span>
        </div>
        <p class="text-3xl font-bold {{ $totalOvrstay > 0 ? 'text-red-600' : 'text-slate-800' }}">{{ $totalOvrstay }}</p>
        <p class="text-xs {{ $totalOvrstay > 0 ? 'text-red-400' : 'text-slate-400' }} mt-1">Perlu evaluasi segera</p>
    </div>

    <!-- Warning -->
    <div class="bg-white rounded-2xl shadow-sm border {{ $totalWarning > 0 ? 'border-yellow-200' : 'border-slate-200' }} p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 {{ $totalWarning > 0 ? 'bg-yellow-100' : 'bg-slate-100' }} rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 {{ $totalWarning > 0 ? 'text-yellow-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-slate-500">Mendekati Batas</span>
        </div>
        <p class="text-3xl font-bold {{ $totalWarning > 0 ? 'text-yellow-600' : 'text-slate-800' }}">{{ $totalWarning }}</p>
        <p class="text-xs {{ $totalWarning > 0 ? 'text-yellow-400' : 'text-slate-400' }} mt-1">LOS 4-5 hari</p>
    </div>

    <!-- Rata-rata LOS -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-slate-500">Rata-rata LOS</span>
        </div>
        <p class="text-3xl font-bold text-slate-800">{{ $avgLos }}</p>
        <p class="text-xs text-slate-400 mt-1">Hari (pasien aktif)</p>
    </div>

    <!-- Pulang Bulan Ini -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-slate-500">Pulang Bulan Ini</span>
        </div>
        <p class="text-3xl font-bold text-slate-800">{{ $totalPulangBulanIni }}</p>
        <p class="text-xs text-slate-400 mt-1">Pasien telah pulang</p>
    </div>

</div>
