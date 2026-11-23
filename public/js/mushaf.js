window.addEventListener('load', function() {
    const loader = document.getElementById('loading-screen');
    if (loader) {
        loader.classList.add('hidden-loader');
        setTimeout(() => { loader.style.display = 'none'; }, 400);
    }
});

window.addEventListener('scroll', () => {
    const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
    const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrolled = (winScroll / height) * 100;
    document.getElementById('readingProgress').style.width = scrolled + '%';
});

// --- Modal Pengaturan ---
const settingsModal = document.getElementById('settingsModal');
const settingsBackdrop = document.getElementById('settingsBackdrop');

function toggleSettingsModal() {
    if (settingsModal.classList.contains('translate-y-full')) {
        settingsModal.classList.remove('translate-y-full');
        settingsBackdrop.classList.remove('opacity-0', 'pointer-events-none');
        document.body.style.overflow = 'hidden';
    } else {
        settingsModal.classList.add('translate-y-full');
        settingsBackdrop.classList.add('opacity-0', 'pointer-events-none');
        document.body.style.overflow = 'auto';
    }
}

// --- Sidebar Off-Canvas ---
const sidebar = document.getElementById('sidebarNav');
const backdrop = document.getElementById('sidebarBackdrop');
const openBtn = document.getElementById('openSidebarBtn');
const closeBtn = document.getElementById('closeSidebarBtn');

if(openBtn) {
    openBtn.addEventListener('click', () => {
        sidebar.classList.remove('-translate-x-full');
        backdrop.classList.remove('opacity-0', 'pointer-events-none');
        document.body.style.overflow = 'hidden';
    });
}

if(closeBtn) {
    closeBtn.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('opacity-0', 'pointer-events-none');
        document.body.style.overflow = 'auto';
    });
}
if(backdrop) {
    backdrop.addEventListener('click', () => {
        if(sidebar && !sidebar.classList.contains('-translate-x-full')){
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('opacity-0', 'pointer-events-none');
            document.body.style.overflow = 'auto';
        }
    });
}

// --- FUNGSI COPY ---
function copyAyat(ayatNumber, arabic, translation) {
    const textToCopy = `Ayat ${ayatNumber}\n${arabic}\n\n${translation}\n\n(Qur'an Gorontalo)`;
    navigator.clipboard.writeText(textToCopy).then(() => {
        alert('Teks ayat berhasil disalin!');
    });
}
// Pas Gembok / Loading:
document.getElementById('qariIcon').innerText = 'lock';
// Pas Sukses / Buka Gembok:
document.getElementById('qariIcon').innerText = 'expand_more';
// --- LocalStorage & Preferences ---
document.addEventListener('DOMContentLoaded', () => {
    let prefs = JSON.parse(localStorage.getItem('quranPrefs')) || {
        fontArab: 36,
        fontTrans: 16,
        showGoro: true,
        showIndo: true,
        showAudioBtn: true
    };

    const arabTexts = document.querySelectorAll('.arabic-text');
    const indoTexts = document.querySelectorAll('.target-indo');
    const goroTexts = document.querySelectorAll('.target-goro');
    const audioElements = document.querySelectorAll('.target-audio');

    const toggleGoro = document.getElementById('toggleGoro');
    const toggleIndo = document.getElementById('toggleIndo');
    const toggleAudioBtn = document.getElementById('toggleAudioBtn');

    function applyPreferences() {
        arabTexts.forEach(el => el.style.fontSize = prefs.fontArab + 'px');
        indoTexts.forEach(el => el.style.fontSize = prefs.fontTrans + 'px');
        goroTexts.forEach(el => el.style.fontSize = (prefs.fontTrans + 4) + 'px'); // Goro dibuat lebih besar sedikit

        goroTexts.forEach(el => prefs.showGoro ? el.classList.remove('hidden') : el.classList.add('hidden'));
        indoTexts.forEach(el => prefs.showIndo ? el.classList.remove('hidden') : el.classList.add('hidden'));
        audioElements.forEach(el => prefs.showAudioBtn ? el.classList.remove('hidden') : el.classList.add('hidden'));

        if(toggleGoro) toggleGoro.checked = prefs.showGoro;
        if(toggleIndo) toggleIndo.checked = prefs.showIndo;
        if(toggleAudioBtn) toggleAudioBtn.checked = prefs.showAudioBtn;

        localStorage.setItem('quranPrefs', JSON.stringify(prefs));
    }

    applyPreferences();

    if(toggleGoro) toggleGoro.addEventListener('change', (e) => { prefs.showGoro = e.target.checked; applyPreferences(); });
    if(toggleIndo) toggleIndo.addEventListener('change', (e) => { prefs.showIndo = e.target.checked; applyPreferences(); });
    if(toggleAudioBtn) toggleAudioBtn.addEventListener('change', (e) => { prefs.showAudioBtn = e.target.checked; applyPreferences(); });

    document.getElementById('fontIncreaseArab')?.addEventListener('click', () => {
        if (prefs.fontArab < 56) { prefs.fontArab += 2; applyPreferences(); }
    });
    document.getElementById('fontDecreaseArab')?.addEventListener('click', () => {
        if (prefs.fontArab > 24) { prefs.fontArab -= 2; applyPreferences(); }
    });
    
    document.getElementById('fontIncreaseTrans')?.addEventListener('click', () => {
        if (prefs.fontTrans < 24) { prefs.fontTrans += 1; applyPreferences(); }
    });
    document.getElementById('fontDecreaseTrans')?.addEventListener('click', () => {
        if (prefs.fontTrans > 14) { prefs.fontTrans -= 1; applyPreferences(); }
    });

    // --- AJAX Audio Filter ---
    const langgamSelect = document.getElementById('langgamSelect');
    const qariSelect = document.getElementById('qariSelect');

    if(langgamSelect && qariSelect) {
        // A. Filter Nama Qari Berdasarkan Langgam
        langgamSelect.addEventListener('change', async function() {
            const langgamId = this.value;
            const qariIcon = document.getElementById('qariIcon');
            
            // 1. KONDISI: Jika user reset opsi (Kembali Gembok)
            if (!langgamId) {
                qariSelect.innerHTML = '<option value="">Pilih irama terlebih dahulu ↑</option>';
                qariSelect.disabled = true;
                qariSelect.style.backgroundColor = '#f9fafb';
                qariSelect.style.color = '#9ca3af';
                qariSelect.style.borderColor = '#e5e7eb';
                qariSelect.style.cursor = 'not-allowed';
                if(qariIcon) qariIcon.innerText = 'lock';
                return;
            }

            // 2. KONDISI: Sedang Loading (Gembok)
            qariSelect.innerHTML = '<option value="">Mencari Qari...</option>';
            qariSelect.disabled = true;
            qariSelect.style.backgroundColor = '#f9fafb';
            qariSelect.style.color = '#9ca3af';
            qariSelect.style.borderColor = '#e5e7eb';
            qariSelect.style.cursor = 'wait';
            if(qariIcon) qariIcon.innerText = 'hourglass_empty';

            try {
                const response = await fetch(`${G_API_URL}?langgam_id=${langgamId}&surah_id=${G_SURAH_NO}`);
                const data = await response.json();
                
                qariSelect.innerHTML = '<option value="">-- Tekan untuk memilih Qari --</option>';
                
                if(data.qaris && data.qaris.length > 0) {
                    data.qaris.forEach(qari => {
                        qariSelect.innerHTML += `<option value="${qari.id}">${qari.nama}</option>`;
                    });
                    
                    // 3. KONDISI: BUKA GEMBOK (Ubah style balik ke normal/putih)
                    qariSelect.disabled = false;
                    qariSelect.style.backgroundColor = '#ffffff'; // Kembali Putih
                    qariSelect.style.color = '#1f2937'; // Teks hitam/gelap
                    qariSelect.style.borderColor = '#e5e7eb'; 
                    qariSelect.style.cursor = 'pointer'; // Kursor tangan
                    // if(qariIcon) qariIcon.innerText = 'expand_more';

                } else {
                    qariSelect.innerHTML = '<option value="">Qari tidak ditemukan</option>';
                    if(qariIcon) qariIcon.innerText = 'error';
                }
            } catch (error) {
                qariSelect.innerHTML = '<option value="">Gagal memuat data</option>';
                if(qariIcon) qariIcon.innerText = 'error';
            }
        });
    }
});

// --- AUDIO PLAYER LOGIC ---
let currentAudio = null;
let currentButton = null;

function getBtnMeta(btn) {
    return {
        icon: btn?.getAttribute('data-icon') || 'play_circle',
        text: btn?.getAttribute('data-text') || 'Dengarkan',
    };
}

function setButtonState(btn, state) {
    if (!btn) return;
    const iconSpan = btn.querySelector('.icon-play');
    const textSpan = btn.querySelector('.text-play');
    const meta = getBtnMeta(btn);

    if (iconSpan) iconSpan.classList.remove('animate-spin');

    if (state === 'play') {
        btn.classList.add('text-emerald-600');
        if (iconSpan) iconSpan.textContent = 'pause_circle';
        if (textSpan) textSpan.textContent = 'Jeda';
    } else if (state === 'pause') {
        btn.classList.add('text-emerald-600');
        if (iconSpan) iconSpan.textContent = meta.icon;
        if (textSpan) textSpan.textContent = meta.text;
    }
}

function resetButtonState(btn) {
    if (!btn) return;
    const iconSpan = btn.querySelector('.icon-play');
    const textSpan = btn.querySelector('.text-play');
    const meta = getBtnMeta(btn);

    btn.classList.remove('text-emerald-600');
    if (iconSpan) {
        iconSpan.classList.remove('animate-spin');
        iconSpan.textContent = meta.icon;
    }
    if (textSpan) textSpan.textContent = meta.text;
}

function playAudio(audioUrl, btnElement) {
    if (!audioUrl) {
        alert('Mohon maaf, file audio untuk ayat ini belum tersedia.');
        return;
    }
    const iconSpan = btnElement.querySelector('.icon-play');
    const textSpan = btnElement.querySelector('.text-play');

    if (currentAudio && currentButton === btnElement) {
        if (!currentAudio.paused) {
            currentAudio.pause();
            setButtonState(btnElement, 'pause');
        } else {
            currentAudio.play().then(() => setButtonState(btnElement, 'play')).catch(() => {
                alert('Gagal memutar audio.');
                resetButtonState(btnElement);
            });
        }
        return;
    }

    if (currentAudio) {
        currentAudio.pause();
        if (currentButton) resetButtonState(currentButton);
    }

    currentAudio = new Audio(audioUrl);
    currentButton = btnElement;

    if (iconSpan) {
        iconSpan.textContent = 'hourglass_empty';
        iconSpan.classList.add('animate-spin');
    }
    if (textSpan) textSpan.textContent = 'Memuat...';

    currentAudio.play()
        .then(() => setButtonState(btnElement, 'play'))
        .catch(() => {
            alert('Mohon maaf, file audio belum tersedia atau gagal dimuat.');
            resetButtonState(btnElement);
            currentAudio = null;
            currentButton = null;
        });

    currentAudio.onended = () => {
        resetButtonState(btnElement);
        currentAudio = null;
        currentButton = null;
    };
}

function openFootnoteModal(btn) {
    // console.log('Footnote button clicked:', btn);
    const nomor = btn.getAttribute('data-nomor');
    const ayat = btn.getAttribute('data-ayat');
    const terjemahan = btn.getAttribute('data-terjemahan');
    const isi = btn.getAttribute('data-isi');

    document.getElementById('fnModalNomor').textContent = nomor;
    document.getElementById('fnModalAyat').textContent = `Ayat ${ayat}`;
    document.getElementById('fnModalTerjemahan').textContent = `"${terjemahan}"`;
    document.getElementById('fnModalIsi').textContent = isi;

    const modal = document.getElementById('footnoteModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeFootnoteModal() {
    const modal = document.getElementById('footnoteModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}

// Tutup modal kalau klik area gelap di luar kotak
document.getElementById('footnoteModal')?.addEventListener('click', function (e) {
    if (e.target === this) closeFootnoteModal();
});

// --- GLOBAL AUDIO PLAYER LOGIC ---
let playlist = [];
let currentIndex = 0;
let isGlobalPlaying = false;
let globalAudio = new Audio();


const globalPlayerUI = document.getElementById('globalAudioPlayer');
const headerBtnIcon = document.querySelector('.icon-play-all');
const mainPlayPauseBtn = document.getElementById('mainPlayPauseBtn');
const playerTitle = document.getElementById('playerTitle');
const audioSeeker = document.getElementById('audioSeeker');
const currentTimeDisplay = document.getElementById('currentTimeDisplay');
const totalTimeDisplay = document.getElementById('totalTimeDisplay');

function buildPlaylist() {
    playlist = [];
    document.querySelectorAll('.ayah-card').forEach((card) => {
        const ayat = card.id.replace('ayat-', '');
        const arabBtn = card.querySelector('button[data-text="Arab"]');
        const gorBtn = card.querySelector('button[data-text="Gorontalo"]');
        const arabUrl = arabBtn?.dataset.audioUrl || '';
        const gorUrl = gorBtn?.dataset.audioUrl || '';

        if (arabUrl) playlist.push({ url: arabUrl, label: `Ayat ${ayat} - Arab` });
        if (gorUrl) playlist.push({ url: gorUrl, label: `Ayat ${ayat} - Gorontalo` });
    });
}

function loadAndPlayTrack(index) {
    if (index < 0 || index >= playlist.length) {
        closeGlobalPlayer();
        return;
    }
    currentIndex = index;
    const track = playlist[currentIndex];

    if (playerTitle) playerTitle.innerHTML = track.label;
    if (audioSeeker) audioSeeker.value = 0;
    if (currentTimeDisplay) currentTimeDisplay.innerHTML = "00:00";
    if (totalTimeDisplay) totalTimeDisplay.innerHTML = "00:00";

    globalAudio.src = track.url;
    globalAudio.play().then(() => {
        isGlobalPlaying = true;
        updatePlayPauseUI(true);
        if (currentAudio) {
            currentAudio.pause();
            if (currentButton) resetButtonState(currentButton);
        }
    }).catch(() => {
        console.warn('Skip track:', track.url);
        setTimeout(() => nextTrack(), 500);
    });
}

function togglePlayAll() {
    if (playlist.length === 0) buildPlaylist();
    
    if (playlist.length === 0) {
        alert("Tidak ada audio yang tersedia di surah ini.");
        return;
    }

    if (globalPlayerUI) globalPlayerUI.classList.remove('translate-y-full');

    if (isGlobalPlaying) {
        globalAudio.pause();
        isGlobalPlaying = false;
        updatePlayPauseUI(false);
    } else {
        if (globalAudio.src) {
            globalAudio.play();
        } else {
            loadAndPlayTrack(currentIndex);
        }
        isGlobalPlaying = true;
        updatePlayPauseUI(true);
    }
}

function updatePlayPauseUI(playing) {
    if (playing) {
        if(headerBtnIcon) headerBtnIcon.innerHTML = 'pause';
        if(mainPlayPauseBtn) mainPlayPauseBtn.innerHTML = '<span class="material-symbols-outlined text-5xl">pause_circle</span>';
    } else {
        if(headerBtnIcon) headerBtnIcon.innerHTML = 'play_arrow';
        if(mainPlayPauseBtn) mainPlayPauseBtn.innerHTML = '<span class="material-symbols-outlined text-5xl">play_circle</span>';
    }
}

function nextTrack() { loadAndPlayTrack(currentIndex + 1); }
function prevTrack() { loadAndPlayTrack(currentIndex - 1); }

function closeGlobalPlayer() {
    globalAudio.pause();
    isGlobalPlaying = false;
    updatePlayPauseUI(false);
    if(globalPlayerUI) globalPlayerUI.classList.add('translate-y-full');
}

globalAudio.addEventListener('timeupdate', () => {
    if (!isNaN(globalAudio.duration) && audioSeeker) {
        const progressPercent = (globalAudio.currentTime / globalAudio.duration) * 100;
        audioSeeker.value = progressPercent;
        if(currentTimeDisplay) currentTimeDisplay.innerHTML = formatTime(globalAudio.currentTime);
        if(totalTimeDisplay) totalTimeDisplay.innerHTML = formatTime(globalAudio.duration);
    }
});

globalAudio.addEventListener('ended', () => { nextTrack(); });

if(audioSeeker) {
    audioSeeker.addEventListener('input', (e) => {
        if (!isNaN(globalAudio.duration)) {
            const seekTo = (e.target.value / 100) * globalAudio.duration;
            globalAudio.currentTime = seekTo;
        }
    });
}

function formatTime(seconds) {
    const mins = Math.floor(seconds / 60);
    const secs = Math.floor(seconds % 60);
    return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
}