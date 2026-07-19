@php
    $user = Auth::user();
    $role = $user->role;
    $isAdminOrPakar = in_array($role, ['teologi', 'linguistik', 'admin']);
    $isEditor = $role === 'editor';
    $isNormalUser = !($isAdminOrPakar || $isEditor);
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Profil - Qur'an Gorontalo</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
    </style>
</head>

<body
    class="text-slate-900 antialiased {{ !$isNormalUser ? 'flex h-screen overflow-hidden' : 'flex flex-col min-h-screen' }}">

    {{-- SIDEBAR UNTUK ADMIN / PAKAR --}}
    @if ($isAdminOrPakar)
        @include('partials.sidebar')
    @endif

    {{-- SIDEBAR KHUSUS UNTUK EDITOR --}}
    @if ($isEditor)
        @include('partials.sidebar_editor')
    @endif

    {{-- KONTEN UTAMA --}}
    <div class="flex-1 w-full {{ !$isNormalUser ? 'overflow-y-auto bg-slate-50' : 'bg-slate-50' }}">

        {{-- NAVBAR UNTUK USER BIASA --}}
        @if ($isNormalUser)
            @include('partials.navbar')
        @endif

        <main class="max-w-6xl mx-auto px-4 py-8 md:py-12 sm:px-6 lg:px-8 pb-20">

            <div class="mb-6">
                <a href="{{ route('profile.show', Auth::id()) }}"
                    class="inline-flex items-center gap-1.5 text-emerald-700 hover:text-emerald-800 font-semibold text-sm transition-colors bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg w-fit active:scale-95">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Kembali ke Profil Anda
                </a>
            </div>

            <div class="mb-8 flex items-center gap-3">
                <span class="material-symbols-outlined text-4xl text-emerald-700">manage_accounts</span>
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 leading-tight">Pengaturan Profil</h2>
                    <p class="text-slate-500 text-sm mt-1">Kelola informasi data diri dan keamanan akun Anda.</p>
                </div>
            </div>

            <div class="space-y-6">

                <div
                    class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-10 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-3 bg-emerald-600"></div>

                    <header class="mb-6 mt-2 border-b border-slate-100 pb-4">
                        <h2 class="text-xl font-bold text-slate-900">Kartu Identitas Publik</h2>
                        <p class="mt-1 text-sm text-slate-500">Informasi ini akan terlihat oleh warga lain di forum
                            diskusi.</p>
                    </header>

                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div class="flex flex-col md:flex-row gap-8 md:gap-10">

                            <div class="shrink-0 flex flex-col items-center md:items-start gap-4">

                                <div class="relative group cursor-pointer"
                                    onclick="document.getElementById('avatarInput').click()">

                                    <img id="avatarPreview"
                                        src="{{ $user->avatar ? asset('storage/' . $user->avatar) : '' }}"
                                        alt="Avatar"
                                        class="w-28 h-28 md:w-32 md:h-32 rounded-full object-cover border-4 border-emerald-50 shadow-md {{ $user->avatar ? '' : 'hidden' }}">

                                    <div id="avatarInitials"
                                        class="w-28 h-28 md:w-32 md:h-32 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-5xl border-4 border-emerald-50 shadow-md {{ $user->avatar ? 'hidden' : '' }}">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>

                                    <div
                                        class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="material-symbols-outlined text-white text-3xl">photo_camera</span>
                                    </div>
                                </div>

                                <div class="w-full text-center md:text-left">
                                    <label class="block text-xs font-bold text-slate-500 mb-1">Ganti Foto</label>
                                    <input type="file" id="avatarInput" name="avatar" accept="image/*"
                                        onchange="previewImage(this)"
                                        class="w-full text-xs text-slate-500 file:mr-0 file:w-full file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                                    @error('avatar')
                                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                    @enderror

                                    @if ($user->avatar)
                                        <div
                                            class="mt-3 flex items-center justify-center md:justify-start gap-2 bg-red-50 px-3 py-2 rounded-lg border border-red-100 w-fit">
                                            <input type="checkbox" id="remove_avatar" name="remove_avatar"
                                                value="1"
                                                class="rounded border-red-300 text-red-600 focus:ring-red-500 cursor-pointer">
                                            <label for="remove_avatar"
                                                class="text-xs font-bold text-red-700 cursor-pointer hover:text-red-800 transition-colors">
                                                Hapus Foto Saat Ini
                                            </label>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="flex-1 w-full min-w-0 space-y-5">

                                <div>
                                    <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama
                                        Lengkap Tampilan</label>
                                    <input type="text" id="name" name="name"
                                        value="{{ old('name', $user->name) }}"
                                        class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-3 border font-medium text-slate-900"
                                        required>
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Alamat
                                        Email Terdaftar</label>
                                    <input type="email" id="email" name="email"
                                        value="{{ old('email', $user->email) }}"
                                        class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-3 border text-slate-600 bg-slate-50"
                                        required>
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="bio" class="block text-sm font-bold text-slate-700 mb-2">Bio
                                        Singkat</label>
                                    <textarea id="bio" name="bio" rows="4"
                                        placeholder="Tuliskan sedikit tentang diri Anda, asal daerah, atau minat dalam mempelajari Al-Qur'an..."
                                        class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-3 border text-sm text-slate-700">{{ old('bio', $user->bio) }}</textarea>
                                    <p class="text-xs text-slate-400 mt-1">Maksimal 500 karakter. Kosongkan jika tidak
                                        ingin ditampilkan.</p>
                                    @error('bio')
                                        <p class="text-red-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center gap-4 pt-4">
                                    <button type="submit"
                                        class="bg-emerald-700 text-white px-8 py-3 rounded-xl font-bold hover:bg-emerald-800 transition-colors shadow-sm active:scale-95 text-sm flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px]">save</span>
                                        Simpan Identitas
                                    </button>

                                    @if (session('status') === 'profile-updated')
                                        <div
                                            class="flex items-center gap-1.5 text-sm font-bold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-lg">
                                            <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                            Berhasil disimpan
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                <div class="p-6 md:p-8 bg-white shadow-sm rounded-2xl border border-slate-200">
                    <div class="max-w-xl">
                        <header class="mb-6">
                            <h2 class="text-lg font-bold text-slate-900">Ubah Kata Sandi</h2>
                            <p class="mt-1 text-sm text-slate-500">Pastikan akun Anda menggunakan kata sandi acak yang
                                panjang agar tetap aman.</p>
                        </header>

                        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                            @csrf
                            @method('put')

                            <div>
                                <label for="current_password" class="block text-sm font-bold text-slate-700 mb-2">Kata
                                    Sandi Saat Ini</label>
                                <input type="password" id="current_password" name="current_password"
                                    class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-3 border"
                                    autocomplete="current-password">
                                @error('current_password', 'updatePassword')
                                    <p class="text-red-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-bold text-slate-700 mb-2">Kata Sandi
                                    Baru</label>
                                <input type="password" id="password" name="password"
                                    class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-3 border"
                                    autocomplete="new-password">
                                @error('password', 'updatePassword')
                                    <p class="text-red-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation"
                                    class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Kata Sandi
                                    Baru</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm p-3 border"
                                    autocomplete="new-password">
                                @error('password_confirmation', 'updatePassword')
                                    <p class="text-red-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit"
                                    class="bg-slate-800 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-slate-900 transition-colors shadow-sm active:scale-95 text-sm">
                                    Perbarui Sandi
                                </button>

                                @if (session('status') === 'password-updated')
                                    <p class="text-sm font-medium text-emerald-600">Sandi diperbarui.</p>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                {{-- <div class="p-6 md:p-8 bg-white shadow-sm rounded-2xl border border-red-100">
                    <div class="max-w-xl">
                        <header class="mb-6">
                            <h2 class="text-lg font-bold text-red-600">Hapus Akun</h2>
                            <p class="mt-1 text-sm text-slate-500">Setelah akun Anda dihapus, semua data dan sumber
                                daya di dalamnya akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
                        </header>

                        <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                            @csrf
                            @method('delete')

                            <div>
                                <label for="password_delete"
                                    class="block text-sm font-bold text-slate-700 mb-2">Masukkan Kata Sandi untuk
                                    Konfirmasi</label>
                                <input type="password" id="password_delete" name="password"
                                    placeholder="Kata Sandi Anda"
                                    class="w-full sm:w-2/3 rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500 shadow-sm p-3 border">
                                @error('password', 'userDeletion')
                                    <p class="text-red-500 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="pt-2">
                                <button type="submit"
                                    class="bg-red-100 text-red-700 px-6 py-2.5 rounded-xl font-bold hover:bg-red-200 transition-colors shadow-sm active:scale-95 text-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus akun secara permanen?');">
                                    Hapus Akun Secara Permanen
                                </button>
                            </div>
                        </form>
                    </div>
                </div> --}}

            </div>
        </main>
    </div>

</body>

</html>
