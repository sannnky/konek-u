# 🚀 Connecting-U

**Connecting-U** adalah platform berbasis web yang dirancang untuk memberikan ruang kolaborasi inklusif bagi mahasiswa. Aplikasi ini membantu meningkatkan kapabilitas mahasiswa dan institusi melalui kompetisi atau riset bersama dengan memudahkan proses pencarian partner tim lintas jurusan.

_Final Project Mata Kuliah Framework Pemrograman Web_  
**Program Studi Informatika – Universitas Singaperbangsa Karawang (UNSIKA)**

---

## 👥 Anggota Kelompok

Project ini disusun oleh Mahasiswa Kelas **5A – Informatika**:

| Nama                     | NPM           | Role                |
|-------------------------|---------------|----------------------|
| Mohammad Ichsan Nurdin  | 2310631170097 | Fullstack Developer |
| Iqbal Umar Kadafi       | 2310631170091 | Fullstack Developer |

---

## 📖 Tentang Project

Di lingkungan kampus, mahasiswa sering memiliki ide brilian untuk kompetisi seperti **PKM**, **Gemastik**, atau **Business Plan**, namun kesulitan menemukan anggota tim dengan keahlian yang tepat. Cara konvensional seperti broadcast di grup WhatsApp kurang efektif, tidak terstruktur, dan sulit dipantau.

**Connecting-U** hadir sebagai solusi untuk menjembatani **Idea Owner (Ketua Tim)** dengan **Talent (Calon Anggota)**.

Platform ini memungkinkan pengguna untuk:

- Mempublikasikan ide proyek/lomba  
- Mencari tim berdasarkan minat dan skill  
- Mengelola proses rekrutmen  
- Berkolaborasi dalam satu platform terintegrasi  

---

## 🛠️ Tech Stack

Aplikasi ini dibangun menggunakan teknologi modern:

- **Backend Framework**: Laravel 10 (PHP)
- **Frontend Styling**: Tailwind CSS  
- **Templating Engine**: Blade  
- **Database**: MySQL  
- **Local Server Environment**: Laragon  
- **Version Control**: Git & GitHub  

---

## ✨ Fitur Utama

### 1. Otentikasi & Profil Pengguna
- 🔐 **Login & Register** (terenkripsi)
- 👤 **Profil Profesional**: Bio, keahlian, jurusan, avatar
- 🗂️ **Digital Portfolio**: Menampilkan 3 proyek terbaik (pin project)

### 2. Pencarian & Dashboard
- 📊 **Dashboard Interaktif** berisi daftar Open Recruitment
- 🔍 **Smart Filtering** berdasarkan kategori atau skill
- 🟢 **Status Indikator**: Open, On-Going, Completed, Closed

### 3. Manajemen Tim (Leader)
- 📝 Membuat tim/proyek (judul, deskripsi, deadline, kriteria anggota)
- 👀 Melihat dan menyaring pelamar
- ✔️ Terima / ❌ Tolak anggota
- 🔄 Update status proyek
- 📎 Upload dokumen (PDF) untuk tim

### 4. Kolaborasi (Member)
- ✉️ **Apply Project** dengan pesan motivasi
- 📌 **Riwayat Lamaran**: Pending, Diterima, Ditolak
- 💬 **Ruang Diskusi (Chat)** internal tim

---

## ⚙️ Cara Instalasi (Localhost)

Ikuti langkah berikut untuk menjalankan project di komputer lokal:

### 1. Clone Repository
```bash
git clone https://github.com/username-github-kamu/connecting-u.git
cd connecting-u
```
### 2. Install Dependencies
```bash
composer install
npm install
```
### 3. Setup Environment
```bash
cp .env.example .env
```
Kemudian sesuaikan pengaturan database di file .env:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=connectingu
DB_USERNAME=root
DB_PASSWORD=
```
### 4. Generate Key & Migrate
```bash
php artisan key:generate
php artisan migrate
php artisan storage:link
```
### 5. Run Application
```bash
npm run dev
php artisan serve
```
---
## Akses aplikasi di:
➡️ http://127.0.0.1:8000
