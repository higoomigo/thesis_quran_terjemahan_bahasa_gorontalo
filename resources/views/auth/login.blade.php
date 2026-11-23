<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Login - Hulontalo Qur'an</title>
    
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

            <div class="grid grid-cols-2 text-center text-sm text-on-surface-variant">
                <form action="{{ route('login') }}" method="POST" class="col-span-1 p-2 m-2 bg-emerald-600 hover:bg-emerald-700 border border-emerald-700 rounded-xl" >
                    @csrf
                    <input type="text" value="mansur.linguis1@gorontalo.com" readonly hidden name="email">
                    <input type="text" value="password" readonly hidden name="password">
                    <button type="submit" class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm text-slate-100 ">person</span>
                        <p class="text-sm text-slate-100 ">Mansur Linguistik</p>
                    </button>
                </form>
                <form action="{{ route('login') }}" method="POST" class="col-span-1 p-2 m-2 bg-emerald-600 hover:bg-emerald-700 border border-emerald-700 rounded-xl" >
                    @csrf
                    <input type="text" value="yusuf.teologi1@gorontalo.com" readonly hidden name="email">
                    <input type="text" value="password" readonly hidden name="password">
                    <button type="submit" class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm text-slate-100 ">person</span>
                        <p class="text-sm text-slate-100 ">Yusuf Teologi</p>
                    </button>
                </form>
                <form action="{{ route('login') }}" method="POST" class="col-span-1 p-2 m-2 bg-emerald-600 hover:bg-emerald-700 border border-emerald-700 rounded-xl" >
                    @csrf
                    <input type="text" value="ahmad.teologi2@gorontalo.com" readonly hidden name="email">
                    <input type="text" value="password" readonly hidden name="password">
                    <button type="submit" class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm text-slate-100 ">person</span>
                        <p class="text-sm text-slate-100 ">Ahmad Teologi</p>
                    </button>
                </form>
                <form action="{{ route('login') }}" method="POST" class="col-span-1 p-2 m-2 bg-emerald-600 hover:bg-emerald-700 border border-emerald-700 rounded-xl" >
                    @csrf
                    <input type="text" value="tim_editor@gorontalo.com" readonly hidden name="email">
                    <input type="text" value="password" readonly hidden name="password">
                    <button type="submit" class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm text-slate-100 ">person</span>
                        <p class="text-sm text-slate-100 ">Tim Editor</p>
                    </button>
                </form>
                <form action="{{ route('login') }}" method="POST" class="col-span-1 p-2 m-2 bg-emerald-600 hover:bg-emerald-700 border border-emerald-700 rounded-xl" >
                    @csrf
                    <input type="text" value="admin@quranhulontalo.com" readonly hidden name="email">
                    <input type="text" value="password" readonly hidden name="password">
                    <button type="submit" class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm text-slate-100 ">person</span>
                        <p class="text-sm text-slate-100 ">Admin</p>
                    </button>
                </form> 
                <form action="{{ route('login') }}" method="POST" class="col-span-1 p-2 m-2 bg-emerald-600 hover:bg-emerald-700 border border-emerald-700 rounded-xl" >
                    @csrf
                    <input type="text" value="s_bouti@ung.ac.id" readonly hidden name="email">
                    <input type="text" value="password" readonly hidden name="password">
                    <button type="submit" class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm text-slate-100 ">person</span>
                        <p class="text-sm text-slate-100 ">Prof. Suleman Bouti</p>
                    </button>
                </form>
        </div>
    </div>
    
</body>
</html>