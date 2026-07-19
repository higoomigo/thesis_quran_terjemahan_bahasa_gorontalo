{{-- resources/views/admin/validasi/chat.blade.php --}}

{{-- @dd($usulan, $isExpired, $userVote, $voteCounts, $votingComplete) --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Ruang Diskusi - {{ $usulan->ayat->surah->nama_latin ?? 'Surah' }}:{{ $usulan->ayat->nomor_ayat ?? '' }} | Sakinah Validator</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;family=Noto+Serif:ital,wght@0,400;0,700;1,400&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Minimal custom – hanya untuk scrollbar hidden */
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        /* Pesan sistem card tidak perlu custom tambahan */
    </style>
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex">

    {{-- Sidebar --}}
    @include('partials.sidebar')

    {{-- Main Content --}}
    <main class="flex-1 ml-64 flex flex-col h-screen">
        {{-- Top Nav Bar --}}
        <header class="flex justify-between items-center px-6 h-16 bg-white shadow-sm border-b border-gray-200 sticky top-0 z-20">
            <div class="flex items-center gap-4">
                <div class="bg-gray-50 px-3 py-1.5 rounded-full border border-gray-200 flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600 text-lg">search</span>
                    <input type="text" placeholder="Cari pesan..." class="bg-transparent border-none focus:ring-0 text-sm w-64" id="searchChat">
                </div>
            </div>
            <div class="flex items-center gap-4">
                <span class="material-symbols-outlined text-gray-500 cursor-pointer hover:text-emerald-600">notifications</span>
                <span class="material-symbols-outlined text-gray-500 cursor-pointer hover:text-emerald-600">help</span>
                <div class="flex items-center gap-2 cursor-pointer">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 border-2 border-emerald-700 flex items-center justify-center text-emerald-800 font-bold text-xs">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                    </div>
                    <span class="font-bold text-emerald-800 text-sm">{{ Auth::user()->name ?? 'Validator' }}</span>
                </div>
            </div>
        </header>

        {{-- Two Column Layout --}}
        <div class="flex-1 flex overflow-hidden">
            {{-- Left Column: Context Panel --}}
            <aside class="w-[35%] overflow-y-auto p-6 border-r border-gray-200 hide-scrollbar bg-white">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-emerald-800">Konteks Usulan</h2>
                    <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full font-bold flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">schedule</span>
                        <span id="countdownTimer">Memuat...</span>
                    </span>
                </div>

                {{-- Kartu Ayat --}}
                <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 mb-6">
                    <div class="flex justify-between items-center mb-3 border-b border-gray-200 pb-2">
                        <span class="text-emerald-800 font-bold">Surah {{ $usulan->ayat->surah->nama_latin ?? '?' }} ({{ $usulan->ayat->no_surah ?? '?' }}:{{ $usulan->ayat->nomor_ayat ?? '?' }})</span>
                        <span class="text-gray-500 text-xs">Mushaf Standar</span>
                    </div>
                    <p class="arabic-font text-right text-3xl leading-loose mb-4" dir="rtl">{{ $usulan->ayat->arab ?? '--' }}</p>
                    <div class="bg-gray-100 p-3 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1 font-bold uppercase tracking-wider">Terjemahan Saat Ini</p>
                        <p class="text-sm italic text-gray-700">{{ $usulan->ayat->teks_gorontalo ?? 'Belum ada terjemahan' }}</p>
                    </div>
                </div>

                {{-- Usulan Baru --}}
                <div class="bg-emerald-50/30 p-5 rounded-xl border border-emerald-200 mb-6">
                    <div class="flex items-center gap-2 mb-3 text-emerald-700">
                        <span class="material-symbols-outlined">edit_note</span>
                        <h3 class="font-bold">Usulan Diksi Baru</h3>
                    </div>
                    <p class="text-emerald-800 font-semibold text-base mb-3 italic">"{{ $usulan->usulan_teks }}"</p>
                    <div class="flex items-center gap-4 text-xs text-gray-500 border-t border-emerald-200 pt-3">
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">person</span>
                            <span>{{ $usulan->nama_pengusul }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">verified</span>
                            <span>Linguistik OK</span>
                        </div>
                    </div>
                </div>

                {{-- Tim Validator --}}
                <div>
                    <h3 class="text-gray-500 font-bold uppercase text-xs tracking-wider mb-3">Panel Ahli ({{ $usulan->assignments->count() }}/3)</h3>
                    <div class="space-y-2">
                        @foreach($usulan->assignments as $assign)
                        <div class="flex items-center justify-between p-2 bg-white rounded-lg border border-gray-200">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-700 flex items-center justify-center font-bold text-xs">
                                    {{ strtoupper(substr($assign->user->name ?? 'P', 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-sm">{{ $assign->user->name ?? 'Pakar' }}</p>
                                    <p class="text-[10px] text-gray-500">Validator</p>
                                </div>
                            </div>
                            @php
                                $hasVoted = $usulan->votes->where('user_id', $assign->user_id)->first();
                            @endphp
                            @if($hasVoted)
                                <span class="text-xs {{ $hasVoted->keputusan == 'setuju' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} px-2 py-0.5 rounded-full">
                                    {{ $hasVoted->keputusan == 'setuju' ? 'Setuju' : 'Tolak' }}
                                </span>
                            @else
                                <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </aside>

            {{-- Right Column: Chat Room --}}
            <section class="flex-1 flex flex-col bg-gray-50">
                {{-- Chat Header --}}
                <div class="p-5 flex justify-between items-center bg-white border-b border-gray-200">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Ruang Diskusi Panelis</h2>
                        <p class="text-xs text-gray-500">Validasi diksi pada QS. {{ $usulan->ayat->no_surah ?? '' }}:{{ $usulan->ayat->nomor_ayat ?? '' }}</p>
                    </div>
                    @if(!$votingComplete && !in_array($usulan->status, ['diterima','ditolak']) && !$isExpired && $usulan->assignments->count() >= 3)
                        <button id="triggerVoteBtn" 
                                class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-xl font-bold flex items-center gap-2 transition shadow-md">
                            <span class="material-symbols-outlined">how_to_vote</span>
                            Mulai Pemungutan Suara
                        </button>
                    @endif
                </div>

                {{-- Chat Messages Area --}}
                <div id="chatMessages" class="flex-1 overflow-y-auto p-5 space-y-4 flex flex-col hide-scrollbar">
                    @foreach($usulan->chats as $chat)
                        @if($chat->is_system_message)
                            {{-- System message / Voting card --}}
                            <div class="w-full flex justify-center py-2">
                                <div class="bg-white border-2 border-emerald-200 rounded-2xl p-5 shadow-lg max-w-md w-full text-center relative">
                                    <span class="material-symbols-outlined text-emerald-600 text-3xl mb-2">ballot</span>
                                    <h4 class="text-lg font-bold text-emerald-800 mb-1">Pemungutan Suara</h4>
                                    <p class="text-sm text-gray-600 mb-3">{{ $chat->pesan }}</p>
                                    @if(str_contains($chat->pesan, 'Sesi pemungutan suara telah dimulai') && !$userVote && !$votingComplete && !in_array($usulan->status, ['diterima','ditolak']) && !$isExpired)
                                        <div class="flex gap-3 mt-3">
                                            <button onclick="castVote('setuju')" class="flex-1 bg-green-600 text-white py-2 rounded-lg font-bold flex items-center justify-center gap-2 hover:bg-green-700">Setuju</button>
                                            <button onclick="castVote('tolak')" class="flex-1 bg-red-600 text-white py-2 rounded-lg font-bold flex items-center justify-center gap-2 hover:bg-red-700">Tolak</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            {{-- Regular message bubble --}}
                            <div id="msg-{{ $chat->id }}" class="max-w-[80%] {{ $chat->user_id == auth()->id() ? 'self-end text-right' : '' }}">
                                @if($chat->user_id != auth()->id())
                                    <p class="text-xs text-gray-500 ml-2 mb-1 font-bold">{{ $chat->user->name }}</p>
                                @endif
                                <div class="{{ $chat->user_id == auth()->id() ? 'bg-emerald-600 text-white rounded-2xl rounded-tr-none' : 'bg-white border border-gray-200 rounded-2xl rounded-tl-none' }} p-3 shadow-sm">
                                    <p class="text-sm">{{ $chat->pesan }}</p>
                                </div>
                                <p class="text-[10px] text-gray-400 mt-1 {{ $chat->user_id == auth()->id() ? 'mr-2' : 'ml-2' }}">{{ $chat->created_at->format('H:i') }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Chat Input --}}
                @if(!$votingComplete && !in_array($usulan->status, ['diterima','ditolak']) && !$isExpired)
                <div class="p-4 bg-white border-t border-gray-200">
                    <div class="flex items-end gap-3 bg-gray-50 rounded-2xl p-2 border border-gray-200 focus-within:border-emerald-500">
                        <textarea id="chatInput" rows="1" class="flex-1 bg-transparent border-none focus:ring-0 text-sm resize-none py-2 max-h-32 hide-scrollbar" placeholder="Tulis pesan diskusi..."></textarea>
                        <button id="sendMsgBtn" class="bg-emerald-600 text-white p-2 rounded-xl shadow hover:bg-emerald-700 transition">
                            <span class="material-symbols-outlined">send</span>
                        </button>
                    </div>
                </div>
                @else
                <div class="p-4 bg-white border-t border-gray-200 text-center text-sm text-gray-500">
                    @if(in_array($usulan->status, ['diterima','ditolak']))
                        Diskusi telah selesai. Keputusan final sudah ditetapkan.
                    @elseif($isExpired)
                        Waktu diskusi sudah habis.
                    @else
                        Voting telah selesai. Menunggu keputusan final.
                    @endif
                </div>
                @endif
            </section>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Data dari server
        const currentUserId = {{ auth()->id() }};
        // const usulanId = {{ $usulan->id }};
        const deadline = '{{ $usulan->batas_waktu_diskusi ?? "" }}';
        let lastMessageId = {{ $usulan->chats->count() > 0 ? $usulan->chats->last()->id : 0 }};
        const usulanId = {{ $usulan->id }};
        // const deadline = '{{ $usulan->batas_waktu_diskusi }}';
        // let lastMessageId = {{ $usulan->chats->last()->id ?? 0 }};
        let pollingInterval = null;
        let isVotingComplete = {{ $votingComplete ? 'true' : 'false' }};
        let isExpired = {{ $isExpired ? 'true' : 'false' }};
        let userVoted = {{ $userVote ? 'true' : 'false' }};

        // Countdown Timer
        function updateCountdown() {
            if (!deadline) {
                document.getElementById('countdownTimer').innerText = 'Tidak ada batas';
                return;
            }
            const deadlineDate = new Date(deadline).getTime();
            const now = new Date().getTime();
            const distance = deadlineDate - now;
            if (distance < 0) {
                document.getElementById('countdownTimer').innerHTML = 'Waktu Habis';
                if (!isExpired) location.reload();
                return;
            }
            const days = Math.floor(distance / (1000*60*60*24));
            const hours = Math.floor((distance % (86400000)) / 3600000);
            const minutes = Math.floor((distance % 3600000) / 60000);
            document.getElementById('countdownTimer').innerHTML = `${days} hari ${hours} jam ${minutes} menit`;
        }
        if (deadline) {
            updateCountdown();
            setInterval(updateCountdown, 60000);
        } else {
            document.getElementById('countdownTimer').innerHTML = 'Tanpa batas';
        }

        // Scroll chat to bottom
        const chatContainer = document.getElementById('chatMessages');
        function scrollToBottom() {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
        scrollToBottom();

        // Auto resize textarea
        const tx = document.getElementById('chatInput');
        if (tx) {
            tx.style.height = 'auto';
            tx.style.height = tx.scrollHeight + 'px';
            tx.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
        }

        // Send message
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
                    body: JSON.stringify({ pesan })
                });
                const result = await response.json();
                if (result.success) {
                    input.value = '';
                    input.style.height = 'auto';
                    
                    // Render ke layar secara instan
                    appendMessage(result.data);
                    
                    // FIX 3: Update lastMessageId ke ID terbaru yang barusan kita kirim
                    // Supaya saat polling berjalan, server tahu kita sudah memegang pesan ini
                    if (result.data.id > lastMessageId) {
                        lastMessageId = result.data.id;
                    }
                } else {
                    Swal.fire('Error', result.error || 'Gagal mengirim', 'error');
                }
            } catch(e) {
                Swal.fire('Error', 'Terjadi kesalahan jaringan', 'error');
            }
        });

        // GANTI fungsi appendMessage dengan versi yang lebih aman
        function appendMessage(msg) {
            // Cegah duplikasi
            if (document.getElementById(`msg-${msg.id}`)) return;

            // Tentukan apakah pesan ini dari diri sendiri
            // Prioritas: gunakan is_self jika ada, atau bandingkan user_id
            let isSelf = false;
            if (msg.is_self !== undefined) {
                isSelf = msg.is_self;
            } else if (msg.user_id !== undefined) {
                isSelf = parseInt(msg.user_id) === parseInt(currentUserId);
            } else {
                // Fallback: jika tidak ada informasi, asumsikan pesan dari user lain
                isSelf = false;
            }

            // DEBUG: tulis ke console untuk memastikan nilai
            console.log('appendMessage - msg:', msg);
            console.log('currentUserId:', currentUserId);
            console.log('isSelf:', isSelf);

            const div = document.createElement('div');
            div.id = `msg-${msg.id}`;
            div.className = `max-w-[80%] ${isSelf ? 'self-end text-right' : ''} message-fade-in`;
            
            div.innerHTML = `
                ${!isSelf ? `<p class="text-xs text-gray-500 ml-2 mb-1 font-bold">${escapeHtml(msg.user_name || 'Pakar')}</p>` : ''}
                <div class="${isSelf ? 'bg-emerald-600 text-white rounded-2xl rounded-tr-none' : 'bg-white border border-gray-200 rounded-2xl rounded-tl-none'} p-3 shadow-sm text-left">
                    <p class="text-sm">${escapeHtml(msg.pesan)}</p>
                </div>
                <p class="text-[10px] text-gray-400 mt-1 ${isSelf ? 'mr-2' : 'ml-2'}">${msg.created_at || 'baru saja'}</p>
            `;
            
            chatContainer.appendChild(div);
            scrollToBottom();
        }

        function addSystemMessage(msg) {
            const div = document.createElement('div');
            div.className = 'w-full flex justify-center py-2 message-fade-in';
            div.innerHTML = `
                <div class="bg-white border-2 border-emerald-200 rounded-2xl p-5 shadow-lg max-w-md w-full text-center relative">
                    <span class="material-symbols-outlined text-emerald-600 text-3xl mb-2">ballot</span>
                    <h4 class="text-lg font-bold text-emerald-800 mb-1">Pemungutan Suara</h4>
                    <p class="text-sm text-gray-600 mb-3">${escapeHtml(msg.pesan)}</p>
                    ${msg.pesan.includes('Sesi pemungutan suara telah dimulai') && !userVoted && !isVotingComplete && !isExpired ? `
                        <div class="flex gap-3 mt-3">
                            <button onclick="castVote('setuju')" class="flex-1 bg-green-600 text-white py-2 rounded-lg font-bold flex items-center justify-center gap-2 hover:bg-green-700">Setuju</button>
                            <button onclick="castVote('tolak')" class="flex-1 bg-red-600 text-white py-2 rounded-lg font-bold flex items-center justify-center gap-2 hover:bg-red-700">Tolak</button>
                        </div>
                    ` : ''}
                </div>
            `;
            chatContainer.appendChild(div);
            scrollToBottom();
        }

        // Trigger voting
        document.getElementById('triggerVoteBtn')?.addEventListener('click', async () => {
            const confirm = await Swal.fire({
                title: 'Mulai Pemungutan Suara?',
                text: 'Semua pakar akan diminta memilih setuju atau tolak.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#dc2626',
                confirmButtonText: 'Ya, mulai!'
            });
            if (!confirm.isConfirmed) return;

            Swal.fire({ title: 'Memproses...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
            try {
                const res = await fetch(`/admin/validasi/chat/${usulanId}/trigger-voting`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                });
                const result = await res.json();
                if (result.success) {
                    Swal.fire('Berhasil!', 'Sesi voting dimulai', 'success');
                    addSystemMessage(result.data);
                    document.getElementById('triggerVoteBtn')?.remove();
                } else {
                    Swal.fire('Gagal', result.error || 'Tidak dapat memulai voting', 'error');
                }
            } catch(e) {
                Swal.fire('Error', 'Terjadi kesalahan', 'error');
            }
        });

        // Cast vote (didefinisikan global)
        window.castVote = async (keputusan) => {
            const confirm = await Swal.fire({
                title: `Konfirmasi Suara`,
                text: `Anda akan memilih: ${keputusan === 'setuju' ? 'SETUJU' : 'TOLAK'}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: keputusan === 'setuju' ? '#059669' : '#dc2626',
                confirmButtonText: 'Ya, konfirmasi'
            });
            if (!confirm.isConfirmed) return;

            Swal.fire({ title: 'Memproses...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
            try {
                const res = await fetch(`/admin/validasi/chat/${usulanId}/vote`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ keputusan })
                });
                const result = await res.json();
                if (result.success) {
                    userVoted = true;
                    // Update tampilan voting counts dan progress bar
                    if (result.vote_counts) {
                        // Penulisan yang benar dan aman dari Syntax Error
                        const elSetuju = document.getElementById('voteCountSetuju');
                        if (elSetuju) elSetuju.innerText = result.vote_counts.setuju;

                        const elTolak = document.getElementById('voteCountTolak');
                        if (elTolak) elTolak.innerText = result.vote_counts.tolak;

                        const progress = (result.vote_counts.total / 3) * 100;
                        const progressBar = document.querySelector('.voting-progress-bar');
                        if (progressBar) progressBar.style.width = `${progress}%`;
                    }
                    if (result.voting_complete) {
                        isVotingComplete = true;
                        Swal.fire({
                            title: result.result.final_decision === 'diterima' ? '🎉 Usulan Diterima!' : '📌 Usulan Ditolak',
                            text: `Keputusan final: ${result.result.final_decision === 'diterima' ? 'DITERIMA' : 'DITOLAK'}`,
                            icon: result.result.final_decision === 'diterima' ? 'success' : 'info'
                        }).then(() => location.reload());
                    } else {
                        Swal.fire('Suara tersimpan', 'Terima kasih telah memberikan suara.', 'success');
                        location.reload(); // refresh untuk update tampilan
                    }
                } else {
                    Swal.fire('Gagal', result.error || 'Tidak dapat menyimpan suara', 'error');
                }
            } catch(e) {
                Swal.fire('Error', 'Terjadi kesalahan', 'error');
            }
        };

        // Polling untuk pesan baru
        function startPolling() {
            if (pollingInterval) clearInterval(pollingInterval);
            pollingInterval = setInterval(async () => {
                try {
                    const res = await fetch(`/admin/validasi/chat/${usulanId}/messages?last_id=${lastMessageId}`);
                    const result = await res.json();
                    if (result.messages && result.messages.length) {
                        result.messages.forEach(msg => {
                            if (msg.is_system_message) addSystemMessage(msg);
                            else appendMessage(msg);
                        });
                        lastMessageId = result.last_id;
                    }
                } catch(e) { console.error(e); }
            }, 3000);
        }
        startPolling();

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
        }
    </script>
</body>
</html>