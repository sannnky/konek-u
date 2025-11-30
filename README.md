🚀 Connecting-U

Connecting-U adalah sebuah platform berbasis website yang dirancang untuk memberikan ruang kolaborasi inklusif bagi mahasiswa. Aplikasi ini bertujuan untuk meningkatkan kapabilitas mahasiswa dan institusi melalui kompetisi atau riset bersama dengan memudahkan proses pencarian partner tim lintas jurusan.

Final Project Mata Kuliah Framework Pemrograman Web > Program Studi Informatika - Universitas Singaperbangsa Karawang (UNSIKA)

👥 Anggota Kelompok

Project ini disusun oleh Mahasiswa Kelas 5A - Informatika:

Nama

NPM

Role

Mohammad Ichsan Nurdin

2310631170097

Fullstack Developer

Iqbal Umar Kadafi

2310631170091

Fullstack Developer

📖 Tentang Project

Di lingkungan kampus, seringkali mahasiswa memiliki ide brilian untuk kompetisi (seperti PKM, Gemastik, atau Business Plan) namun kesulitan menemukan anggota tim dengan skill spesifik yang dibutuhkan. Cara konvensional seperti menyebar pesan di grup WhatsApp seringkali tidak efektif dan tidak terstruktur.

Connecting-U hadir sebagai solusi untuk menjembatani Idea Owner (Ketua Tim) dengan Talent (Anggota Tim). Aplikasi ini memungkinkan mahasiswa untuk:

Mempublikasikan ide proyek/lomba.

Mencari tim berdasarkan minat dan keahlian.

Mengelola proses rekrutmen hingga pengerjaan proyek dalam satu platform terintegrasi.

🛠️ Tech Stack

Aplikasi ini dibangun menggunakan teknologi modern untuk memastikan performa yang cepat dan tampilan yang responsif:

Backend Framework: Laravel 10 (PHP)

Frontend Styling: Tailwind CSS

Templating Engine: Blade

Database: MySQL

Local Server Environment: Laragon

Version Control: Git & GitHub

✨ Fitur Utama

Aplikasi Connecting-U memiliki fitur lengkap mulai dari rekrutmen hingga manajemen proyek:

1. Otentikasi & Profil Pengguna

✅ Login & Register: Sistem keamanan terenkripsi.

✅ Profil Profesional: Menampilkan Bio, Keahlian (Skills), Jurusan, dan Foto Profil (Avatar).

✅ Digital Portfolio: Pengguna dapat memilih dan mem-pin 3 proyek terbaik (baik yang dibuat sendiri atau diikuti) untuk ditampilkan di profil publik.

2. Pencarian & Dashboard

✅ Dashboard Interaktif: Menampilkan daftar Open Recruitment terbaru.

✅ Smart Filtering: Cari tim berdasarkan Kategori (PKM, Riset, IT, Bisnis) atau kata kunci skill.

✅ Status Indikator: Pembeda visual untuk status proyek (Open, On-Going, Completed, Closed).

3. Manajemen Tim (Untuk Leader)

✅ Buat Tim/Proyek: Input judul, deskripsi, deadline, dan kriteria anggota.

✅ Kelola Pelamar: Melihat profil pelamar, membaca pesan motivasi, serta tombol Terima/Tolak anggota.

✅ Update Progress: Mengubah status proyek (misal: dari Open ke On-Going saat tim penuh).

✅ Upload Dokumen: Fitur untuk mengunggah proposal atau hasil proyek (PDF) yang bisa diakses anggota.

4. Kolaborasi (Untuk Member)

✅ Apply Project: Mengajukan diri bergabung ke tim dengan pesan motivasi (validasi otomatis jika lewat deadline).

✅ Riwayat Lamaran: Memantau status lamaran (Pending, Diterima, Ditolak).

✅ Ruang Diskusi (Chat): Fitur chatting internal khusus untuk anggota tim yang sudah diterima dan ketua tim.

⚙️ Cara Instalasi (Localhost)

Jika ingin menjalankan project ini di komputer lokal:

Clone Repository

git clone [https://github.com/username-github-kamu/connecting-u.git](https://github.com/username-github-kamu/connecting-u.git)
cd connecting-u


Install Dependencies

composer install
npm install


Setup Environment

Copy file .env.example menjadi .env.

Buat database baru di MySQL bernama connectingu.

Konfigurasi DB di file .env.

Generate Key & Migrate

php artisan key:generate
php artisan migrate
php artisan storage:link


Run Application

npm run dev
php artisan serve


Dibuat dengan ❤️ oleh Tim Connecting-U Unsika.
