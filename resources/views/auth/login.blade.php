<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Login - Hulontalo Qur'an</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Noto+Serif:wght@400;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary-fixed": "#a6f2d1", "surface": "#f9f9ff", "on-tertiary-container": "#a8d0bc",
                        "on-secondary-fixed": "#331200", "tertiary": "#1e4334", "surface-bright": "#f9f9ff",
                        "secondary-container": "#fd8a42", "error": "#ba1a1a", "tertiary-container": "#365a4a",
                        "surface-tint": "#1b6b51", "on-tertiary-fixed": "#002115", "primary-fixed-dim": "#8bd6b6",
                        "on-primary-fixed": "#002116", "inverse-surface": "#2a313d", "on-primary-container": "#8bd6b7",
                        "on-background": "#151c27", "background": "#f9f9ff", "tertiary-fixed-dim": "#a8cfbc",
                        "secondary": "#9b4500", "on-primary": "#ffffff", "surface-container-low": "#f0f3ff",
                        "inverse-primary": "#8bd6b6", "on-secondary-container": "#682c00", "on-surface": "#151c27",
                        "primary-container": "#065f46", "on-tertiary": "#ffffff", "error-container": "#ffdad6",
                        "surface-container-lowest": "#ffffff", "on-surface-variant": "#3f4944", "primary": "#004532",
                        "surface-container-high": "#e2e8f8", "secondary-fixed": "#ffdbca", "on-error-container": "#93000a",
                        "surface-container-highest": "#dce2f3", "on-secondary-fixed-variant": "#763300", "outline": "#6f7973",
                        "on-primary-fixed-variant": "#00513b", "on-secondary": "#ffffff", "on-error": "#ffffff",
                        "tertiary-fixed": "#c3ecd7", "surface-dim": "#d3daea", "surface-container": "#e7eefe",
                        "inverse-on-surface": "#ebf1ff", "outline-variant": "#bec9c2", "surface-variant": "#dce2f3",
                        "secondary-fixed-dim": "#ffb68e", "on-tertiary-fixed-variant": "#294e3f"
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                    spacing: { "sm": "0.5rem", "xl": "2.5rem", "unit": "4px", "gutter": "1.5rem", "container-max": "1200px", "md": "1rem", "lg": "1.5rem", "xs": "0.25rem" },
                    fontFamily: {
                        "label-md": ["Inter"], "caption": ["Inter"], "body-reading-translation": ["Inter"],
                        "headline-lg": ["Inter"], "headline-xl": ["Inter"], "body-reading-arabic": ["Noto Serif"]
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: theme('colors.surface'); }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        
        /* Custom pattern islami yang soft */
        .islamic-pattern {
            background-color: theme('colors.primary');
            background-image: url('https://images.unsplash.com/photo-1584551246679-0daf3d275d0f?q=80&w=2000&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-blend-mode: soft-light;
        }
    </style>
</head>

<body class="min-h-screen flex text-on-background">

    <!-- KIRI: Gambar Motif Islami & Branding -->
    <div class="hidden lg:flex lg:w-1/2 islamic-pattern relative items-center justify-center p-12 overflow-hidden">
        <!-- Overlay Gradient biar teks tetap terbaca -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary/90 to-primary-container/95"></div>
        
        <div class="relative z-10 text-center text-white max-w-lg">
            <span class="material-symbols-outlined text-[80px] mb-6 drop-shadow-lg">auto_stories</span>
            <h1 class="text-4xl font-bold mb-4 font-headline-lg tracking-tight">Qur'an Hulontalo</h1>
            <p class="text-lg opacity-90 font-body-reading-translation leading-relaxed">
                Platform kolaborasi digital untuk pelestarian bahasa Gorontalo melalui terjemahan dan validasi kitab suci Al-Qur'an.
            </p>
        </div>
        
        <!-- Ornamen tambahan di pojok -->
        <div class="absolute -bottom-24 -left-24 w-64 h-64 border-[40px] border-white/5 rounded-full"></div>
        <div class="absolute -top-24 -right-24 w-80 h-80 border-[20px] border-white/5 rounded-full"></div>
    </div>

    <!-- KANAN: Form Login -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 md:p-16 lg:p-24 bg-surface">
        <div class="w-full max-w-md">
            
            <div class="text-left mb-10">
                <!-- Ikon muncul di mobile saja karena di desktop udah ada di gambar -->
                <span class="lg:hidden material-symbols-outlined text-[40px] text-primary mb-4 block">menu_book</span>
                <h2 class="text-3xl font-bold text-on-surface mb-2 font-headline-lg">Selamat Datang</h2>
                <p class="font-body-reading-translation text-sm text-on-surface-variant">Masuk ke akun Anda untuk melanjutkan aktivitas.</p>
            </div>

            <form action="{{ route('login') }}" class="space-y-6" method="POST">
                @csrf
                
                <!-- Email -->
                <div>
                    <label class="block font-label-md text-on-surface mb-2" for="email">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-outline text-xl">mail</span>
                        </div>
                        <input
                            class="block w-full pl-11 pr-4 py-3 border border-outline-variant rounded-xl bg-surface-bright focus:ring-2 focus:ring-primary focus:border-primary font-body-reading-translation text-sm transition-all"
                            id="email" name="email" placeholder="anda@email.com" required="" type="email" />
                    </div>
                    @error('email')
                        <div class="text-error text-xs mt-1.5 font-medium">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block font-label-md text-on-surface mb-2" for="password">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-outline text-xl">lock</span>
                        </div>
                        <input
                            class="block w-full pl-11 pr-4 py-3 border border-outline-variant rounded-xl bg-surface-bright focus:ring-2 focus:ring-primary focus:border-primary font-body-reading-translation text-sm transition-all"
                            id="password" name="password" placeholder="••••••••" required="" type="password" />
                    </div>
                    @error('password')
                        <div class="text-error text-xs mt-1.5 font-medium">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                {{-- <div class="flex items-center justify-between pt-2">
                    <div class="flex items-center">
                        <input class="h-4 w-4 text-primary focus:ring-primary border-outline-variant rounded cursor-pointer"
                            id="remember-me" name="remember-me" type="checkbox" />
                        <label class="ml-2 block font-caption text-sm text-on-surface-variant cursor-pointer" for="remember-me">
                            Ingat saya
                        </label>
                    </div>
                    <div class="font-caption">
                        <a class="text-sm font-semibold text-primary hover:text-primary-container transition-colors" href="#">
                            Lupa sandi?
                        </a>
                    </div>
                </div> --}}

                

                <!-- Submit Button -->
                <div class="pt-4">
                    <button
                        class="w-full flex justify-center items-center gap-2 py-3.5 px-4 rounded-xl shadow-sm font-label-md text-white bg-primary hover:bg-primary-container focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all active:scale-[0.98]"
                        type="submit">
                        Masuk Sekarang
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </button>
                </div>
            </form>

            <p class="text-sm text-on-surface-variant mt-4 text-center">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-primary font-semibold hover:text-primary-container transition-colors">
                        Daftar Sekarang
                    </a>
                </p>

        </div>
    </div>
    
</body>
</html>