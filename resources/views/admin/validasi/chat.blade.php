{{-- resources/views/admin/validasi/chat.blade.php --}}

@extends('layouts.app')

@section('content')
    <style>
        /* Scrollbar minimalis tapi tetap terlihat jelas */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f9fafb;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    <main class="flex-1 ml-64 flex bg-gray-50 h-screen overflow-hidden">
        {{-- ==========================================
         KOLOM KIRI: KONTEKS (Lebih Bersih & Rapi)
         ========================================== --}}
        <aside class="w-[35%] bg-white border-r border-gray-200 flex flex-col h-full z-10">
            <div class="p-8 overflow-y-auto custom-scrollbar flex-1">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-xl font-bold text-gray-800">Konteks Usulan</h2>
                    <span
                        class="text-xs px-3 py-1 bg-gray-100 text-gray-600 rounded-md font-medium flex items-center gap-1 border border-gray-200">
                        <span class="material-symbols-outlined text-[14px]">schedule</span>
                        <span id="countdownTimer">Memuat...</span>
                    </span>
                </div>

                {{-- Kartu Ayat --}}
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-gray-800 font-bold text-lg">QS. {{ $usulan->ayat->surah->nama_latin ?? '?' }}
                            ({{ $usulan->ayat->no_surah ?? '?' }}:{{ $usulan->ayat->nomor_ayat ?? '?' }})</span>
                    </div>
                    <p class="arabic-font text-right text-3xl leading-relaxed mb-6 text-gray-900" dir="rtl">
                        {{ $usulan->ayat->arab ?? '--' }}</p>

                    <div class="border-l-4 border-gray-300 pl-4 py-1">
                        <p class="text-xs text-gray-500 mb-1 uppercase tracking-wider font-semibold">Terjemahan Saat Ini</p>
                        <p class="text-base text-gray-800">{{ $usulan->ayat->teks_gorontalo ?? 'Belum ada terjemahan' }}</p>
                    </div>
                </div>

                <hr class="border-gray-200 mb-8">

                {{-- Usulan Baru --}}
                <div class="mb-8">
                    <p class="text-xs text-emerald-600 mb-2 uppercase tracking-wider font-bold">Usulan Diksi Baru</p>
                    <p class="text-gray-900 font-medium text-lg mb-3">"{{ $usulan->usulan_teks }}"</p>
                    <p class="text-sm text-gray-500">Oleh: <span
                            class="font-medium text-gray-700">{{ $usulan->nama_pengusul }}</span></p>
                </div>

                <hr class="border-gray-200 mb-8">

                {{-- Tim Validator --}}
                <div>
                    <p class="text-xs text-gray-500 mb-4 uppercase tracking-wider font-semibold">Panel Ahli
                        ({{ $usulan->assignments->count() }}/3)</p>
                    <div class="space-y-3">
                        @foreach ($usulan->assignments as $assign)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-white text-gray-600 flex items-center justify-center font-bold border border-gray-200">
                                        {{ strtoupper(substr($assign->user->name ?? 'P', 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $assign->user->name ?? 'Pakar' }}</p>
                                        <p class="text-xs text-gray-500">Validator</p>
                                    </div>
                                </div>
                                @php
                                    $hasVoted = $usulan->votes->where('user_id', $assign->user_id)->first();
                                @endphp
                                @if ($hasVoted)
                                    <span
                                        class="text-xs font-semibold {{ $hasVoted->keputusan == 'setuju' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-red-50 text-red-700 border border-red-200' }} px-3 py-1 rounded-md">
                                        {{ $hasVoted->keputusan == 'setuju' ? 'Setuju' : 'Tolak' }}
                                    </span>
                                @else
                                    <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </aside>

        {{-- ==========================================
         KOLOM KANAN: CHAT & FORM
         ========================================== --}}
        <section class="w-[65%] flex flex-col h-full bg-white relative">

            {{-- Header --}}
            <header class="px-8 py-5 border-b border-gray-200 shrink-0 flex justify-between items-center bg-white">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Ruang Diskusi</h2>
                    <p class="text-sm text-gray-500 mt-1">Validasi QS.
                        {{ $usulan->ayat->no_surah ?? '' }}:{{ $usulan->ayat->nomor_ayat ?? '' }}</p>
                </div>

                @if (
                    !$votingComplete &&
                        !in_array($usulan->status, ['diterima', 'ditolak']) &&
                        !$isExpired &&
                        $usulan->assignments->count() >= 3)
                    <button id="triggerVoteBtn"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-lg font-medium flex items-center gap-2 transition-colors">
                        <span class="material-symbols-outlined text-[20px]">how_to_vote</span> Mulai Voting
                    </button>
                @endif
            </header>

            @if (in_array($usulan->status, ['diterima', 'ditolak']) && empty($usulan->alasan_revisi))
                {{-- 
                =================================================
                MODE FORM FINAL (DITERIMA / DITOLAK)
                ================================================= 
            --}}
                <div class="flex-1 overflow-y-auto custom-scrollbar bg-gray-50 p-8">
                    <div class="max-w-3xl mx-auto">

                        {{-- Alert Status --}}
                        <div
                            class="bg-white border {{ $usulan->status == 'diterima' ? 'border-emerald-200' : 'border-red-200' }} p-5 rounded-lg mb-6 flex items-start gap-4 shadow-sm">
                            <span
                                class="material-symbols-outlined {{ $usulan->status == 'diterima' ? 'text-emerald-600' : 'text-red-500' }} text-3xl">
                                {{ $usulan->status == 'diterima' ? 'check_circle' : 'cancel' }}
                            </span>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Usulan {{ ucfirst($usulan->status) }} Oleh
                                    Panelis</h3>
                                <p class="text-gray-600 text-sm mt-1">
                                    {{ $usulan->status == 'diterima'
                                        ? 'Silakan susun draf terjemahan final untuk diteruskan ke meja Redaksi.'
                                        : 'Silakan berikan alasan penolakan yang jelas untuk diteruskan ke meja Redaksi.' }}
                                </p>
                            </div>
                        </div>

                        {{-- Form Finalisasi --}}
                        <div class="bg-white rounded-lg border border-gray-200 p-8 shadow-sm">
                            <form action="{{ route('admin.validasi.chat.submit-final', $usulan->id) }}" method="POST"
                                class="space-y-8">
                                @csrf
                                @method('PUT')

                                {{-- Field 1: Draf Terjemahan (Hanya Muncul Jika DITERIMA) --}}
                                @if ($usulan->status == 'diterima')
                                    <div>
                                        <label class="block text-base font-bold text-gray-800 mb-1">
                                            Draf Terjemahan Final <span class="text-red-500">*</span>
                                        </label>
                                        <p class="text-sm text-gray-500 mb-3">Teks resmi bahasa Gorontalo yang akan
                                            ditayangkan.</p>
                                        <textarea name="teks_rekomendasi" rows="4"
                                            class="w-full p-4 text-base text-gray-800 border border-gray-300 rounded-lg focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none"
                                            required></textarea>
                                    </div>
                                    <hr class="border-gray-100">
                                @endif

                                {{-- Field 2: Alasan Perubahan / Penolakan (Muncul di Keduanya) --}}
                                <div>
                                    <label class="block text-base font-bold text-gray-800 mb-1">
                                        {{ $usulan->status == 'diterima' ? 'Alasan Perubahan' : 'Alasan Penolakan' }} <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <p class="text-sm text-gray-500 mb-3">
                                        {{ $usulan->status == 'diterima'
                                            ? 'Penjelasan singkat untuk publik mengapa teks ini dipakai.'
                                            : 'Penjelasan mengapa usulan ini tidak memenuhi standar (Akan dilihat oleh Editor).' }}
                                    </p>
                                    <textarea name="alasan_revisi" rows="3"
                                        class="w-full p-4 text-base text-gray-800 border border-gray-300 rounded-lg focus:ring-1 focus:ring-{{ $usulan->status == 'diterima' ? 'emerald' : 'red' }}-500 focus:border-{{ $usulan->status == 'diterima' ? 'emerald' : 'red' }}-500 outline-none"
                                        required></textarea>
                                </div>

                                {{-- Field 3: Pesan Internal --}}
                                <hr class="border-gray-100">
                                <div>
                                    <label class="block text-base font-bold text-gray-800 mb-1">
                                        Pesan Internal untuk Editor <span
                                            class="text-gray-400 font-normal">(Opsional)</span>
                                    </label>
                                    <p class="text-sm text-gray-500 mb-3">Catatan formatting atau instruksi khusus untuk
                                        Editor.</p>
                                    <textarea name="catatan_pakar" rows="2"
                                        class="w-full p-4 text-base text-gray-800 border border-gray-300 rounded-lg focus:ring-1 focus:ring-{{ $usulan->status == 'diterima' ? 'emerald' : 'red' }}-500 focus:border-{{ $usulan->status == 'diterima' ? 'emerald' : 'red' }}-500 outline-none"></textarea>
                                </div>

                                <div class="pt-4">
                                    <button type="submit"
                                        class="w-full {{ $usulan->status == 'diterima' ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-red-600 hover:bg-red-700' }} text-white font-bold py-4 rounded-lg text-lg transition-colors flex items-center justify-center gap-2">
                                        <span
                                            class="material-symbols-outlined">{{ $usulan->status == 'diterima' ? 'send' : 'assignment_return' }}</span>
                                        Kirim Laporan ke Redaksi
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Toggle Riwayat --}}
                        <div class="mt-8 mb-12">
                            <button type="button"
                                onclick="document.getElementById('riwayatChatContainer').classList.toggle('hidden')"
                                class="text-emerald-600 font-medium flex items-center gap-2 hover:text-emerald-700 transition">
                                <span class="material-symbols-outlined text-[20px]">history</span> Tampilkan Riwayat Diskusi
                            </button>
                            <div id="riwayatChatContainer"
                                class="hidden mt-4 bg-white p-6 rounded-lg border border-gray-200 max-h-[400px] overflow-y-auto custom-scrollbar">
                                <div class="space-y-4">
                                    @foreach ($usulan->chats as $chat)
                                        @if (!$chat->is_system_message)
                                            <div
                                                class="max-w-[80%] {{ $chat->user_id == auth()->id() ? 'ml-auto text-right' : '' }}">
                                                <p class="text-xs text-gray-500 mb-1 font-medium">{{ $chat->user->name }}
                                                </p>
                                                <div
                                                    class="{{ $chat->user_id == auth()->id() ? 'bg-emerald-50 text-emerald-900' : 'bg-gray-50 text-gray-800' }} p-4 rounded-lg inline-block text-left border border-gray-100">
                                                    <p class="text-base">{{ $chat->pesan }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- 
                =================================================
                MODE CHAT BIASA (MINIMALIS)
                ================================================= 
            --}}

                <div id="chatMessages" class="flex-1 overflow-y-auto custom-scrollbar p-8 space-y-6 bg-gray-50">
                    @foreach ($usulan->chats as $chat)
                        @if ($chat->is_system_message)
                            <div class="w-full flex justify-center py-4">
                                <div
                                    class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm max-w-md w-full text-center">
                                    <span class="material-symbols-outlined text-emerald-600 text-3xl mb-2">ballot</span>
                                    <h4 class="text-lg font-bold text-gray-800 mb-2">Sesi Voting</h4>
                                    <p class="text-base text-gray-600 mb-5">{{ $chat->pesan }}</p>

                                    @if (str_contains($chat->pesan, 'Sesi pemungutan suara telah dimulai') &&
                                            !$userVote &&
                                            !$votingComplete &&
                                            !in_array($usulan->status, ['diterima', 'ditolak']) &&
                                            !$isExpired)
                                        <div class="flex gap-3">
                                            <button onclick="castVote('setuju')"
                                                class="flex-1 bg-emerald-600 text-white py-2.5 rounded-lg font-bold hover:bg-emerald-700 transition">Setuju</button>
                                            <button onclick="castVote('tolak')"
                                                class="flex-1 bg-red-600 text-white py-2.5 rounded-lg font-bold hover:bg-red-700 transition">Tolak</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div id="msg-{{ $chat->id }}"
                                class="max-w-[80%] {{ $chat->user_id == auth()->id() ? 'self-end ml-auto text-right' : 'mr-auto' }}">
                                @if ($chat->user_id != auth()->id())
                                    <p class="text-sm text-gray-500 ml-1 mb-1 font-medium">{{ $chat->user->name }}</p>
                                @endif
                                <div
                                    class="{{ $chat->user_id == auth()->id() ? 'bg-emerald-600 text-white rounded-l-xl rounded-tr-xl' : 'bg-white border border-gray-200 rounded-r-xl rounded-tl-xl' }} px-5 py-3 shadow-sm inline-block text-left">
                                    <p class="text-base leading-relaxed">{{ $chat->pesan }}</p>
                                </div>
                                <p
                                    class="text-xs text-gray-400 mt-1 {{ $chat->user_id == auth()->id() ? 'mr-1' : 'ml-1' }}">
                                    {{ $chat->created_at->format('H:i') }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>

                @if (!$votingComplete && !in_array($usulan->status, ['diterima', 'ditolak']) && !$isExpired)
                    <div class="px-8 py-5 bg-white border-t border-gray-200 shrink-0">
                        <div class="flex items-end gap-3">
                            <textarea id="chatInput" rows="1"
                                class="flex-1 bg-gray-50 border border-gray-300 rounded-lg py-3 px-4 text-base focus:ring-1 focus:ring-emerald-500 focus:bg-white outline-none resize-none max-h-32 custom-scrollbar transition-colors"
                                placeholder="Ketik pesan diskusi..."></textarea>
                            <button id="sendMsgBtn"
                                class="bg-emerald-600 text-white h-[50px] w-[50px] rounded-lg flex items-center justify-center hover:bg-emerald-700 transition-colors shrink-0">
                                <span class="material-symbols-outlined">send</span>
                            </button>
                        </div>
                    </div>
                @else
                    <div class="p-4 bg-gray-50 border-t border-gray-200 text-center shrink-0">
                        <p class="text-sm font-medium text-gray-500 flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">lock</span>
                            @if (in_array($usulan->status, ['diterima', 'ditolak']))
                                Diskusi ditutup. Keputusan telah ditetapkan.
                            @elseif($isExpired)
                                Waktu diskusi telah berakhir.
                            @else
                                Voting selesai. Menunggu proses.
                            @endif
                        </p>
                    </div>
                @endif
            @endif
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Data dari server
        const currentUserId = {{ auth()->id() }};
        const usulanId = {{ $usulan->id }};
        const deadline = '{{ $usulan->batas_waktu_diskusi ?? '' }}';
        let lastMessageId = {{ $usulan->chats->count() > 0 ? $usulan->chats->last()->id : 0 }};
        let pollingInterval = null;
        let isVotingComplete = {{ $votingComplete ? 'true' : 'false' }};
        let isExpired = {{ $isExpired ? 'true' : 'false' }};
        let userVoted = {{ $userVote ? 'true' : 'false' }};

        function updateCountdown() {
            const el = document.getElementById('countdownTimer');
            if (!el) return;

            if (!deadline) {
                el.innerText = 'Tidak ada batas waktu';
                return;
            }
            const distance = new Date(deadline).getTime() - new Date().getTime();
            if (distance < 0) {
                el.innerHTML = 'Waktu Habis';
                if (!isExpired) location.reload();
                return;
            }
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (86400000)) / 3600000);
            const minutes = Math.floor((distance % 3600000) / 60000);
            el.innerHTML = `${days} hari ${hours} jam ${minutes} menit`;
        }
        if (deadline) {
            updateCountdown();
            setInterval(updateCountdown, 60000);
        } else {
            const el = document.getElementById('countdownTimer');
            if (el) el.innerHTML = 'Tanpa batas waktu';
        }

        const chatContainer = document.getElementById('chatMessages');

        function scrollToBottom() {
            if (chatContainer) {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
        }
        setTimeout(scrollToBottom, 100);

        const tx = document.getElementById('chatInput');
        if (tx) {
            tx.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        }

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(
                /'/g, '&#39;');
        }

        document.getElementById('sendMsgBtn')?.addEventListener('click', async () => {
            const input = document.getElementById('chatInput');
            const pesan = input.value.trim();
            if (!pesan) return;

            try {
                const response = await fetch(`/admin/validasi/chat/${usulanId}/send`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        pesan
                    })
                });
                const result = await response.json();
                if (result.success) {
                    input.value = '';
                    input.style.height = 'auto';
                    appendMessage(result.data);
                    if (result.data.id > lastMessageId) {
                        lastMessageId = result.data.id;
                    }
                } else {
                    Swal.fire('Error', result.error || 'Gagal mengirim pesan', 'error');
                }
            } catch (e) {
                Swal.fire('Error', 'Terjadi kesalahan jaringan', 'error');
            }
        });

        function appendMessage(msg) {
            if (!chatContainer || document.getElementById(`msg-${msg.id}`)) return;

            let isSelf = false;
            if (msg.is_self !== undefined) {
                isSelf = msg.is_self;
            } else if (msg.user_id !== undefined) {
                isSelf = parseInt(msg.user_id) === parseInt(currentUserId);
            }

            const div = document.createElement('div');
            div.id = `msg-${msg.id}`;
            div.className = `max-w-[80%] ${isSelf ? 'self-end ml-auto text-right' : 'mr-auto'}`;

            div.innerHTML = `
            ${!isSelf ? `<p class="text-sm text-gray-500 ml-1 mb-1 font-medium">${escapeHtml(msg.user_name || 'Pakar')}</p>` : ''}
            <div class="${isSelf ? 'bg-emerald-600 text-white rounded-l-xl rounded-tr-xl' : 'bg-white border border-gray-200 rounded-r-xl rounded-tl-xl'} px-5 py-3 shadow-sm inline-block text-left">
                <p class="text-base leading-relaxed">${escapeHtml(msg.pesan)}</p>
            </div>
            <p class="text-xs text-gray-400 mt-1 ${isSelf ? 'mr-1' : 'ml-1'}">${msg.created_at || 'baru saja'}</p>
        `;

            chatContainer.appendChild(div);
            scrollToBottom();
        }

        function addSystemMessage(msg) {
            // CEK DULU: Kalau pesan ini udah ada di layar, jangan dirender lagi!
            if (!chatContainer || document.getElementById(`msg-${msg.id}`)) return;

            const div = document.createElement('div');
            div.id = `msg-${msg.id}`; // KASIH ID BIAR BISA DILACAK
            div.className = 'w-full flex justify-center py-4';

            div.innerHTML = `
            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm max-w-md w-full text-center">
                <span class="material-symbols-outlined text-emerald-600 text-3xl mb-2">ballot</span>
                <h4 class="text-lg font-bold text-gray-800 mb-2">Sesi Voting</h4>
                <p class="text-base text-gray-600 mb-5">${escapeHtml(msg.pesan)}</p>
                ${msg.pesan.includes('Sesi pemungutan suara telah dimulai') && !userVoted && !isVotingComplete && !isExpired ? `
                        <div class="flex gap-3">
                            <button onclick="castVote('setuju')" class="flex-1 bg-emerald-600 text-white py-2.5 rounded-lg font-bold hover:bg-emerald-700 transition">Setuju</button>
                            <button onclick="castVote('tolak')" class="flex-1 bg-red-600 text-white py-2.5 rounded-lg font-bold hover:bg-red-700 transition">Tolak</button>
                        </div>
                    ` : ''}
            </div>
        `;
            chatContainer.appendChild(div);
            scrollToBottom();
        }

        document.getElementById('triggerVoteBtn')?.addEventListener('click', async () => {
            const confirm = await Swal.fire({
                title: 'Mulai Pemungutan Suara?',
                text: 'Panelis akan diminta memilih Setuju atau Tolak.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#dc2626',
                confirmButtonText: 'Ya, Mulai Voting',
                cancelButtonText: 'Batal'
            });
            if (!confirm.isConfirmed) return;

            Swal.fire({
                title: 'Memproses...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            try {
                const res = await fetch(`/admin/validasi/chat/${usulanId}/trigger-voting`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const result = await res.json();

                if (result.success) {
                    Swal.fire('Berhasil!', 'Sesi voting telah dimulai.', 'success');

                    // Panggil fungsinya
                    addSystemMessage(result.data);

                    // KUNCI PERBAIKAN: Update lastMessageId biar Polling nggak ngambil ulang data ini!
                    if (result.data && result.data.id > lastMessageId) {
                        lastMessageId = result.data.id;
                    }

                    document.getElementById('triggerVoteBtn')?.remove();
                } else {
                    Swal.fire('Gagal', result.error || 'Tidak dapat memulai voting', 'error');
                }
            } catch (e) {
                Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
            }
        });

        window.castVote = async (keputusan) => {
            const confirm = await Swal.fire({
                title: `Konfirmasi Pilihan`,
                text: `Anda memilih untuk ${keputusan === 'setuju' ? 'MENYETUJUI' : 'MENOLAK'} usulan ini.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: keputusan === 'setuju' ? '#059669' : '#dc2626',
                confirmButtonText: 'Konfirmasi'
            });
            if (!confirm.isConfirmed) return;

            Swal.fire({
                title: 'Menyimpan Suara...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
            try {
                const res = await fetch(`/admin/validasi/chat/${usulanId}/vote`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        keputusan
                    })
                });
                const result = await res.json();

                if (result.success) {
                    if (result.voting_complete) {
                        Swal.fire({
                            title: result.result.final_decision === 'diterima' ? 'Mufakat Tercapai' :
                                'Usulan Ditolak',
                            text: result.result.final_decision === 'diterima' ?
                                'Menyiapkan formulir finalisasi...' : 'Mayoritas menolak usulan ini.',
                            icon: result.result.final_decision === 'diterima' ? 'success' : 'info',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    } else {
                        Swal.fire('Tersimpan', 'Menunggu panelis lain.', 'success').then(() => location.reload());
                    }
                } else {
                    Swal.fire('Gagal', result.error || 'Tidak dapat menyimpan suara', 'error');
                }
            } catch (e) {
                Swal.fire('Error', 'Terjadi kesalahan jaringan', 'error');
            }
        };

        function startPolling() {
            if (isVotingComplete || isExpired ||
                {{ in_array($usulan->status, ['diterima', 'ditolak']) ? 'true' : 'false' }}) return;

            if (pollingInterval) clearInterval(pollingInterval);
            pollingInterval = setInterval(async () => {
                try {
                    const res = await fetch(
                        `/admin/validasi/chat/${usulanId}/messages?last_id=${lastMessageId}`);
                    const result = await res.json();
                    if (result.messages && result.messages.length) {
                        result.messages.forEach(msg => {
                            if (msg.is_system_message) addSystemMessage(msg);
                            else appendMessage(msg);
                        });
                        lastMessageId = result.last_id;
                    }
                } catch (e) {
                    console.error(e);
                }
            }, 3000);
        }
        startPolling();
    </script>
@endsection
