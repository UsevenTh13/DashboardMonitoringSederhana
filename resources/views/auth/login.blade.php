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

                <div>
                    <label for="email" class="block text-sm font-medium text-blue-100 mb-1.5">
                        Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input id="email" name="email" type="email" required autocomplete="email"
                            value="{{ old('email') }}"
                            placeholder="nama@rsarifin.id"
                            class="w-full bg-white/10 border border-white/20 text-white placeholder-blue-300 rounded-xl pl-10 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-white/40 focus:border-white/40 transition-all">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-blue-100 mb-1.5">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full bg-white/10 border border-white/20 text-white placeholder-blue-300 rounded-xl pl-10 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-white/40 focus:border-white/40 transition-all">
                    </div>
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
        </div>

        <!-- Demo credentials -->
        <div class="mt-4 bg-white/5 border border-white/10 rounded-2xl p-4 text-xs text-blue-200">
            <p class="font-semibold text-white mb-2">🔑 Akun Demo:</p>
            <div class="space-y-1">
                <p>👨‍⚕️ Dokter: <span class="font-mono text-white">dokter@rsarifin.id</span> / <span class="font-mono">password123</span></p>
                <p>👩‍⚕️ Perawat: <span class="font-mono text-white">perawat@rsarifin.id</span> / <span class="font-mono">password123</span></p>
            </div>
        </div>
    </div>

</body>
</html>
