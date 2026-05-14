@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan monitoring LOS pasien rawat inap hari ini')

@section('content')
<div class="space-y-6 animate-slide-in">

    <!-- Stats Cards -->
    <livewire:dashboard-stats />

    <!-- Two Column Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Pasien Overstay Alert -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-slate-800">Peringatan Overstay</h3>
                </div>
                <a href="{{ route('overstay') }}" class="text-xs text-brand-600 font-medium hover:underline">Lihat semua →</a>
            </div>

            @php
                $overstayList = \App\Models\Patient::aktif()->with('dpjp')->get()
                    ->filter(fn($p) => $p->los >= 6)
                    ->sortByDesc(fn($p) => $p->los)
                    ->take(5);
            @endphp

            @if($overstayList->isEmpty())
                <div class="text-center py-8 text-slate-400">
                    <svg class="w-12 h-12 mx-auto mb-2 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm font-medium text-green-600">Tidak ada pasien overstay saat ini</p>
                </div>
            @else
                <div class="space-y-2">
                    @foreach($overstayList as $patient)
                    <div class="flex items-center justify-between p-3 bg-red-50 border border-red-100 rounded-xl hover:bg-red-100 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                {{ $patient->los }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-800">{{ $patient->nama_pasien }}</p>
                                <p class="text-xs text-slate-500">{{ $patient->no_rm }} · {{ $patient->dpjp->name ?? '-' }}</p>
                            </div>
                        </div>
                        <span class="text-xs font-semibold text-red-700 bg-red-100 border border-red-200 px-2 py-0.5 rounded-full">
                            {{ $patient->los }} hari
                        </span>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Pasien Warning -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-slate-800">Mendekati Batas (4-5 Hari)</h3>
                </div>
                <a href="{{ route('monitoring') }}" class="text-xs text-brand-600 font-medium hover:underline">Lihat semua →</a>
            </div>

            @php
                $warningList = \App\Models\Patient::aktif()->with('dpjp')->get()
                    ->filter(fn($p) => $p->los >= 4 && $p->los < 6)
                    ->sortByDesc(fn($p) => $p->los)
                    ->take(5);
            @endphp

            @if($warningList->isEmpty())
                <div class="text-center py-8 text-slate-400">
                    <svg class="w-12 h-12 mx-auto mb-2 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <p class="text-sm">Tidak ada pasien dalam zona peringatan</p>
                </div>
            @else
                <div class="space-y-2">
                    @foreach($warningList as $patient)
                    <div class="flex items-center justify-between p-3 bg-yellow-50 border border-yellow-100 rounded-xl hover:bg-yellow-100 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                {{ $patient->los }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-800">{{ $patient->nama_pasien }}</p>
                                <p class="text-xs text-slate-500">{{ $patient->no_rm }} · {{ $patient->dpjp->name ?? '-' }}</p>
                            </div>
                        </div>
                        <span class="text-xs font-semibold text-yellow-700 bg-yellow-100 border border-yellow-200 px-2 py-0.5 rounded-full">
                            {{ $patient->los }} hari
                        </span>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Panduan Warna LOS -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h3 class="font-semibold text-slate-800 mb-4">Panduan Early Warning LOS</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex items-start gap-4 p-4 bg-green-50 border border-green-200 rounded-xl">
                <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-green-800">Normal (≤ 3 Hari)</p>
                    <p class="text-sm text-green-600 mt-1">Pasien dalam kondisi perawatan standar, LOS masih dalam batas aman.</p>
                </div>
            </div>
            <div class="flex items-start gap-4 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                <div class="w-10 h-10 bg-yellow-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-yellow-800">Perhatian (4-5 Hari)</p>
                    <p class="text-sm text-yellow-600 mt-1">Mendekati batas standar. DPJP perlu mengevaluasi rencana pemulangan.</p>
                </div>
            </div>
            <div class="flex items-start gap-4 p-4 bg-red-50 border border-red-200 rounded-xl">
                <div class="w-10 h-10 bg-red-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-red-800">Overstay (≥ 6 Hari)</p>
                    <p class="text-sm text-red-600 mt-1">Melampaui standar LOS rumah sakit. Evaluasi segera diperlukan.</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
