# 📖 Hulontalo Qur'an: Digitalisasi Al-Qur'an Terjemahan Bahasa Gorontalo

Sebuah Sistem Informasi berbasis *website* yang dikembangkan untuk mendigitalisasi, mengarsipkan, dan mempublikasikan Al-Qur'an dengan terjemahan bahasa daerah Gorontalo. 

Proyek ini dibangun sebagai dedikasi untuk pelestarian bahasa Gorontalo serta mempermudah masyarakat dalam mempelajari tafsir dan makna Al-Qur'an melalui bahasa ibu mereka, dengan jaminan akurasi teologis dan linguistik.

## ✨ Fitur Utama (Core Features)

*   **📖 Mushaf & Terjemahan Gorontalo**
    Antarmuka pembacaan Al-Qur'an yang bersih (*distraction-free*) disesuaikan untuk layar digital, menampilkan teks Arab beserta terjemahan Gorontalo yang telah tervalidasi.
*   **🛡️ Sistem Validasi Ganda (Double-Blind Validation)**
    Alur kerja publikasi terjemahan yang ketat. Setiap ayat harus melewati dua tahap validasi sebelum tayang:
    *   **Validasi Linguistik:** Memastikan kelancaran tata bahasa dan resonansi budaya Gorontalo.
    *   **Validasi Teologis:** Verifikasi makna terhadap sumber tafsir oleh Ulama untuk menjaga integritas ilahi.
*   **🎧 Sistem Audio Murottal Hybrid**
    Pemutar audio adaptif yang mendukung keragaman bacaan (*Qira'at* dan Langgam) bekerja sama dengan IPQAH Gorontalo:
    *   *Audio Per Ayat:* Untuk mode belajar dan pengejaan terjemahan (Tartil).
    *   *Audio Full Surah:* Memutar murottal satu surah penuh dengan berbagai pilihan *Langgam* (Bayati, Rost, dll) tanpa merusak hukum *washal* (napas).
*   **💬 Ruang Diskusi Komunitas (Forum)**
    Wadah interaktif bagi masyarakat, ahli bahasa, dan sarjana Islam untuk berdiskusi seputar tata bahasa Gorontalo, tafsir ayat, dan ilmu keagamaan. Dilengkapi dengan kontrol akses dan moderasi.
*   **📱 Modern & Responsive UI/UX**
    Panel Admin dan Editor yang dinamis (dilengkapi *collapsible sidebar* berbekal *local storage memory*), serta antarmuka publik yang 100% responsif untuk pengalaman pengguna yang mulus di perangkat *mobile* maupun *desktop*.

## 👥 Aktor & Hak Akses (User Roles)

Sistem ini memiliki *Role-Based Access Control* (RBAC) yang spesifik:
1.  **Administrator:** Mengelola pengguna, *monitoring* antrean usulan, dan mengontrol sistem secara keseluruhan.
2.  **Editor:** Bertugas menginput teks terjemahan, mengunggah file audio (massal maupun tunggal), dan mengajukan usulan publikasi.
3.  **Validator (Linguistik & Teologi):** Ahli yang bertugas meninjau, merevisi, atau menyetujui draf terjemahan dari Editor.
4.  **Pengguna / Publik:** Masyarakat umum yang dapat membaca mushaf, mendengarkan audio, dan berpartisipasi dalam forum diskusi.

## 🛠️ Tech Stack

*   **Framework:** Laravel 12 (PHP)
*   **Frontend:** Tailwind CSS, Alpine.js / Vanilla JS, Blade Components
*   **Database:** MySQL
*   **Architecture:** MVC (Model-View-Controller) dengan Relasional Database Management System yang kompleks.

## 🤝 Dukungan & Kolaborasi

Pengembangan data dan validasi pada sistem ini terwujud atas dukungan dan kerja sama dari:
*   **Universitas Negeri Gorontalo (UNG)**
*   **Pemerintah Provinsi Gorontalo**
*   **Majelis Ulama Indonesia (MUI) Provinsi Gorontalo**
*   **IPQAH (Ikatan Persaudaraan Qari-Qariah) Gorontalo**

---
*Dikembangkan oleh Moh Hilal S. Bouti sebagai bagian dari tugas akhir Program Studi Sistem Informasi.*
