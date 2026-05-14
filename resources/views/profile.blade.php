@extends('layouts.app')

@section('title', 'Profil')
@section('page-title', 'Profil Pengguna')
@section('page-subtitle', 'Informasi akun Anda')

@section('content')
<div class="max-w-2xl animate-slide-in">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-gradient-to-r from-brand-700 to-brand-900 p-8 text-center">
            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto shadow-xl mb-4">
                <span class="text-3xl font-bold text-brand-700">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </span>
            </div>
            <h2 class="text-xl font-bold text-white">{{ Auth::user()->name }}</h2>
            <p class="text-brand-200 text-sm mt-1 capitalize">{{ Auth::user()->role }}</p>
        </div>

        <div class="p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 bg-slate-50 rounded-xl">
                    <p class="text-xs text-slate-500 font-medium">Email</p>
                    <p class="text-sm font-semibold text-slate-800 mt-1">{{ Auth::user()->email }}</p>
                </div>
                <div class="p-4 bg-slate-50 rounded-xl">
                    <p class="text-xs text-slate-500 font-medium">Role</p>
                    <p class="text-sm font-semibold text-slate-800 mt-1 capitalize">{{ Auth::user()->role }}</p>
                </div>
                @if(Auth::user()->no_hp)
                <div class="p-4 bg-slate-50 rounded-xl">
                    <p class="text-xs text-slate-500 font-medium">No. HP</p>
                    <p class="text-sm font-semibold text-slate-800 mt-1">{{ Auth::user()->no_hp }}</p>
                </div>
                @endif
                @if(Auth::user()->spesialisasi)
                <div class="p-4 bg-slate-50 rounded-xl">
                    <p class="text-xs text-slate-500 font-medium">Spesialisasi</p>
                    <p class="text-sm font-semibold text-slate-800 mt-1">{{ Auth::user()->spesialisasi }}</p>
                </div>
                @endif
            </div>

            <form method="POST" action="{{ route('logout') }}" class="pt-4 border-t border-slate-100">
                @csrf
                <button type="submit"
                    class="flex items-center gap-2 text-red-600 hover:text-red-800 text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar dari Sistem
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
