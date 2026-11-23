<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Daftar Akun - Hulontalo Qur'an</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Noto+Serif:wght@400;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    
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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex text-on-background">

    <div class="hidden lg:flex lg:w-1/2 islamic-pattern relative items-center justify-center p-12 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-primary/90 to-primary-container/95"></div>
        
        <div class="relative z-10 text-center text-white max-w-lg">
            <span class="material-symbols-outlined text-[80px] mb-6 drop-shadow-lg">auto_stories</span>
            <h1 class="text-4xl font-bold mb-4 font-headline-lg tracking-tight">Qur'an Hulontalo</h1>
            <p class="text-lg opacity-90 font-body-reading-translation leading-relaxed">
                Platform kolaborasi digital untuk pelestarian bahasa Gorontalo melalui terjemahan dan validasi kitab suci Al-Qur'an.
            </p>
        </div>
        
        <div class="absolute -bottom-24 -left-24 w-64 h-64 border-[40px] border-white/5 rounded-full"></div>
        <div class="absolute -top-24 -right-24 w-80 h-80 border-[20px] border-white/5 rounded-full"></div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 md:p-16 lg:p-24 bg-surface">
        <div class="w-full max-w-md">
            
            <div class="text-left mb-10">
                <span class="lg:hidden material-symbols-outlined text-[40px] text-primary mb-4 block">person_add</span>
                <h2 class="text-3xl font-bold text-on-surface mb-2 font-headline-lg">Buat Akun Baru</h2>
                <p class="font-body-reading-translation text-sm text-on-surface-variant">Bergabunglah untuk mulai berdiskusi dan berkontribusi.</p>
            </div>

            <form action="{{ route('register') }}" class="space-y-5" method="POST">
                @csrf
                
                <div>
                    <label class="block font-label-md text-on-surface mb-2" for="name">
                        Nama Lengkap
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-outline text-xl">person</span>
                        </div>
                        <input
                            class="block w-full pl-11 pr-4 py-3 border border-outline-variant rounded-xl bg-surface-bright focus:ring-2 focus:ring-primary focus:border-primary font-body-reading-translation text-sm transition-all"
                            id="name" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap Anda" required autofocus autocomplete="name" type="text" />
                    </div>
                    @error('name')
                        <div class="text-error text-xs mt-1.5 font-medium">{{ $message }}</div>
                    @enderror
                </div>

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
                            id="email" name="email" value="{{ old('email') }}" placeholder="anda@email.com" required autocomplete="username" type="email" />
                    </div>
                    @error('email')
                        <div class="text-error text-xs mt-1.5 font-medium">{{ $message }}</div>
                    @enderror
                </div>

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
                            id="password" name="password" placeholder="••••••••" required autocomplete="new-password" type="password" />
                    </div>
                    @error('password')
                        <div class="text-error text-xs mt-1.5 font-medium">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="block font-label-md text-on-surface mb-2" for="password_confirmation">
                        Konfirmasi Kata Sandi
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-outline text-xl">verified_user</span>
                        </div>
                        <input
                            class="block w-full pl-11 pr-4 py-3 border border-outline-variant rounded-xl bg-surface-bright focus:ring-2 focus:ring-primary focus:border-primary font-body-reading-translation text-sm transition-all"
                            id="password_confirmation" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password" type="password" />
                    </div>
                    @error('password_confirmation')
                        <div class="text-error text-xs mt-1.5 font-medium">{{ $message }}</div>
                    @enderror
                </div>

                <div class="pt-4">
                    <button
                        class="w-full flex justify-center items-center gap-2 py-3.5 px-4 rounded-xl shadow-sm font-label-md text-white bg-primary hover:bg-primary-container focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all active:scale-[0.98]"
                        type="submit">
                        Daftar Sekarang
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </button>
                </div>
            </form>

            <p class="text-sm text-on-surface-variant mt-5 text-center">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-primary font-semibold hover:text-primary-container transition-colors">
                    Masuk Sekarang
                </a>
            </p>

        </div>
    </div>
    
</body>
</html>