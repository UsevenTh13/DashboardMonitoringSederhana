<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Monitoring LOS Pasien Rawat Inap - RS Arifin Achmad Pekanbaru">
    <title>@yield('title', 'Monitoring LOS') | RS Arifin Achmad</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50:  '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                            950: '#172554',
                        }
                    }
                }
            }
        }
    </script>

    @livewireStyles

    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Animations */
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-in { animation: slideIn 0.3s ease-out; }

        @keyframes pulse-slow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }
        .pulse-slow { animation: pulse-slow 2s ease-in-out infinite; }
    </style>
</head>
<body class="h-full bg-slate-100">

<div x-data="{ sidebarOpen: true }" class="flex h-screen overflow-hidden">

    <!-- ===== SIDEBAR ===== -->
    <aside class="w-64 flex-shrink-0 flex flex-col shadow-2xl transition-all duration-300 ease-in-out" 
           :class="sidebarOpen ? 'ml-0' : '-ml-64'"
           style="background: linear-gradient(175deg, #0f2460 0%, #1e3a8a 45%, #162040 100%);">

        <!-- Logo Area -->
        <div class="px-5 pt-6 pb-5 border-b border-white/10">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center shadow-xl flex-shrink-0"
                     style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
                    {{-- Medical Cross / Hospital Icon --}}
                    <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <h1 class="text-white font-bold text-sm leading-tight tracking-wide">Monitoring LOS</h1>
                    <p class="text-blue-300/80 text-[11px] mt-0.5 truncate">RS Arifin Achmad Pekanbaru</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto">
            <p class="text-blue-400/60 text-[9px] font-black uppercase tracking-[0.15em] px-2 mb-3">Menu Utama</p>

            {{-- DASHBOARD --}}
            @php $isDashboard = request()->routeIs('dashboard'); @endphp
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                      {{ $isDashboard ? 'bg-white shadow-lg' : 'hover:bg-white/10' }}">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 transition-all duration-200
                            {{ $isDashboard ? 'bg-brand-600 shadow-md' : 'bg-white/10 group-hover:bg-white/20' }}">
                    <svg class="w-[18px] h-[18px] {{ $isDashboard ? 'text-white' : 'text-blue-200' }}" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                    </svg>
                </div>
                <span class="text-sm font-semibold leading-none {{ $isDashboard ? 'text-brand-700' : 'text-blue-100 group-hover:text-white' }}">
                    Dashboard
                </span>
            </a>

            {{-- MONITORING PASIEN --}}
            @php $isMonitor = request()->routeIs('monitoring'); @endphp
            <a href="{{ route('monitoring') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                      {{ $isMonitor ? 'bg-white shadow-lg' : 'hover:bg-white/10' }}">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 transition-all duration-200
                            {{ $isMonitor ? 'bg-blue-500 shadow-md' : 'bg-white/10 group-hover:bg-white/20' }}">
                    {{-- Clipboard / Patient List icon --}}
                    <svg class="w-[18px] h-[18px] {{ $isMonitor ? 'text-white' : 'text-blue-200' }}" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17 12h-5v5h5v-5zM16 1l-2-2v2H8V1L6 3v2H4c-1.1 0-1.99.9-1.99 2L2 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-2V1zm3 18H4V8h14v11z"/>
                    </svg>
                </div>
                <span class="text-sm font-semibold leading-none {{ $isMonitor ? 'text-brand-700' : 'text-blue-100 group-hover:text-white' }}">
                    Monitoring Pasien
                </span>
            </a>

            {{-- FILTER OVERSTAY --}}
            @php
                $isOverstay = request()->routeIs('overstay');
                $overstayCount = \App\Models\Patient::aktif()->get()->filter(fn($p) => $p->los >= 6)->count();
            @endphp
            <a href="{{ route('overstay') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                      {{ $isOverstay ? 'bg-white shadow-lg' : 'hover:bg-white/10' }}">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 transition-all duration-200
                            {{ $isOverstay ? 'bg-red-500 shadow-md' : ($overstayCount > 0 ? 'bg-red-500/25 group-hover:bg-red-500/40' : 'bg-white/10 group-hover:bg-white/20') }}">
                    {{-- Warning Triangle icon --}}
                    <svg class="w-[18px] h-[18px] {{ $isOverstay ? 'text-white' : ($overstayCount > 0 ? 'text-red-300' : 'text-blue-200') }}" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                    </svg>
                </div>
                <span class="flex-1 text-sm font-semibold leading-none {{ $isOverstay ? 'text-brand-700' : 'text-blue-100 group-hover:text-white' }}">
                    Filter Overstay
                </span>
                @if($overstayCount > 0)
                    <span class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full pulse-slow leading-none min-w-[18px] text-center">
                        {{ $overstayCount }}
                    </span>
                @endif
            </a>

            {{-- RIWAYAT PASIEN --}}
            @php $isHistory = request()->routeIs('history'); @endphp
            <a href="{{ route('history') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                      {{ $isHistory ? 'bg-white shadow-lg' : 'hover:bg-white/10' }}">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 transition-all duration-200
                            {{ $isHistory ? 'bg-purple-600 shadow-md' : 'bg-white/10 group-hover:bg-white/20' }}">
                    {{-- History / Clock icon --}}
                    <svg class="w-[18px] h-[18px] {{ $isHistory ? 'text-white' : 'text-blue-200' }}" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M13 3a9 9 0 0 0-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42A8.954 8.954 0 0 0 13 21a9 9 0 0 0 0-18zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/>
                    </svg>
                </div>
                <span class="text-sm font-semibold leading-none {{ $isHistory ? 'text-brand-700' : 'text-blue-100 group-hover:text-white' }}">
                    Riwayat Pasien
                </span>
            </a>
        </nav>

        <!-- ===== USER INFO ===== -->
        <div class="px-3 pb-4 pt-3 border-t border-white/10 space-y-2">
            <!-- User Card -->
            <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl" style="background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.10);">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow"
                     style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white text-xs font-semibold truncate leading-snug">{{ Auth::user()->name }}</p>
                    <div class="flex items-center gap-1 mt-0.5">
                        @if(Auth::user()->isPerawat())
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 flex-shrink-0"></span>
                            <span class="text-[11px] font-medium text-emerald-300">Perawat</span>
                        @else
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-400 flex-shrink-0"></span>
                            <span class="text-[11px] font-medium text-sky-300">Dokter</span>
                        @endif
                        @if(Auth::user()->spesialisasi)
                            <span class="text-[10px] text-blue-400/70 truncate">· {{ Auth::user()->spesialisasi }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-2.5 px-3 py-2 text-blue-300/80 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 text-xs font-medium group">
                    <div class="w-6 h-6 rounded-lg bg-white/5 group-hover:bg-red-500/30 flex items-center justify-center transition-all flex-shrink-0">
                        <svg class="w-3.5 h-3.5 group-hover:text-red-300 transition-colors" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                        </svg>
                    </div>
                    Keluar dari Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Top Bar -->
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-4">
                <!-- Sidebar Toggle Button -->
                <button @click="sidebarOpen = !sidebarOpen" 
                        class="p-2 -ml-2 rounded-xl text-slate-400 hover:bg-slate-100 hover:text-brand-600 transition-colors focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                </button>
                <div>
                    <h2 class="text-lg font-semibold text-slate-800">@yield('page-title', 'Dashboard')</h2>
                    <p class="text-xs text-slate-500 mt-0.5">@yield('page-subtitle', 'Sistem Monitoring Length of Stay Pasien')</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <!-- Real-time clock -->
                <div class="text-right">
                    <div id="live-time" class="text-sm font-semibold text-slate-700"></div>
                    <div id="live-date" class="text-xs text-slate-500"></div>
                </div>
                <!-- Legend -->
                <div class="hidden lg:flex items-center gap-3 text-xs text-slate-500 bg-slate-50 px-3 py-2 rounded-lg border border-slate-200">
                    <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>Normal ≤3</span>
                    <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-yellow-500"></span>Warning 4-5</span>
                    <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>Overstay ≥6</span>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>
</div>

<script>
    // Live clock
    function updateTime() {
        const now = new Date();
        const timeEl = document.getElementById('live-time');
        const dateEl = document.getElementById('live-date');
        if (timeEl) {
            timeEl.textContent = now.toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit', second: '2-digit'});
        }
        if (dateEl) {
            dateEl.textContent = now.toLocaleDateString('id-ID', {weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'});
        }
    }
    updateTime();
    setInterval(updateTime, 1000);
</script>

@livewireScripts
</body>
</html>
