<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login - Sistem Monitoring LOS RS Arifin Achmad Pekanbaru">
    <title>Login | Monitoring LOS - RS Arifin Achmad</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- AlpineJS for password toggle -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .float-anim { animation: float 4s ease-in-out infinite; }
    </style>
</head>
<body class="h-full bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 flex items-center justify-center p-4">

    <!-- Background decoration -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-600/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md">

        <!-- Card -->
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl shadow-2xl p-8">

            <!-- Header -->
            <div class="text-center mb-8">
                <div class="float-anim inline-flex items-center justify-center w-16 h-16 bg-white rounded-2xl shadow-xl mb-4">
                    <svg class="w-9 h-9 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Monitoring LOS</h1>
                <p class="text-blue-200 text-sm mt-1">RS Arifin Achmad Pekanbaru</p>
                <div class="mt-3 inline-flex items-center gap-1.5 bg-white/10 border border-white/20 rounded-full px-3 py-1">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    <span class="text-blue-100 text-xs">Sistem Aktif</span>
                </div>
            </div>

            <!-- Error Alert -->
            @if ($errors->any())
                <div class="mb-4 bg-red-500/20 border border-red-400/40 rounded-xl px-4 py-3">
                    <p class="text-red-200 text-sm">{{ $errors->first() }}</p>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf

                <!-- USERNAME FIELD -->
                <div>
                    <label for="username" class="block text-sm font-semibold text-white/90 mb-2">Username</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-white/40 group-focus-within:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input type="text" id="username" name="username" required value="{{ old('username') }}"
                            class="w-full bg-white/10 border @error('username') border-red-400/50 focus:border-red-400 @else border-white/20 focus:border-white/40 @enderror rounded-xl py-3 pl-11 pr-4 text-white placeholder-white/40 focus:outline-none focus:ring-0 transition-all backdrop-blur-sm"
                            placeholder="Masukkan username Anda">
                    </div>
                    @error('username')
                        <p class="mt-2 text-sm text-red-200">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PASSWORD FIELD -->
                <div x-data="{ show: false }">
                    <label for="password" class="block text-sm font-semibold text-white/90 mb-2">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-white/40 group-focus-within:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input :type="show ? 'text' : 'password'" id="password" name="password" required
                            class="w-full bg-white/10 border @error('password') border-red-400/50 focus:border-red-400 @else border-white/20 focus:border-white/40 @enderror rounded-xl py-3 pl-11 pr-12 text-white placeholder-white/40 focus:outline-none focus:ring-0 transition-all backdrop-blur-sm"
                            placeholder="••••••••">
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-white/40 hover:text-white transition-colors focus:outline-none">
                            <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-200">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" id="remember"
                            class="w-4 h-4 rounded border-white/30 bg-white/10 text-blue-400 focus:ring-blue-400/40">
                        <span class="text-blue-200 text-sm">Ingat saya</span>
                    </label>
                </div>

                <button type="submit" id="login-btn"
                    class="w-full bg-white text-blue-800 font-semibold py-3 px-6 rounded-xl hover:bg-blue-50 active:scale-95 transition-all duration-200 shadow-lg text-sm mt-2">
                    Masuk ke Sistem
                </button>
            </form>

            <!-- Footer info -->
            <div class="mt-6 border-t border-white/10 pt-4 text-center">
                <p class="text-blue-300 text-xs">Hubungi administrator jika mengalami kendala login</p>
            </div>
            <div class="mt-6 flex flex-col items-center text-xs text-white/40">
                <p>Informasi Akun (Demo)</p>
                <div class="mt-2 text-left bg-white/5 px-4 py-3 rounded-lg border border-white/10 w-full max-w-sm">
                    <p class="mb-1"><strong class="text-white/80">Admin:</strong> admin / admin</p>
                    <p class="mb-1"><strong class="text-white/80">Perawat:</strong> DAHLIASURGIKAL / DAHLIASURGIKAL</p>
                    <p><strong class="text-white/80">Dokter:</strong> drahmadfauzi / password123</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
