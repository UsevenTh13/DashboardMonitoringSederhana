# Sistem Monitoring Length of Stay (LOS) Pasien Rawat Inap

Aplikasi berbasis web untuk memonitoring Length of Stay (LOS) pasien rawat inap di rumah sakit. Dilengkapi dengan fitur Early Warning System (EWS) untuk mendeteksi pasien yang mendekati atau telah melewati standar waktu rawat inap (overstay).

Dibangun menggunakan **Laravel 12**, **Livewire 3**, dan **Tailwind CSS**.

## Fitur Utama

- **Dashboard Statistik Real-time**: Ringkasan jumlah pasien aktif, rata-rata LOS, dan notifikasi overstay.
- **Monitoring LOS Otomatis**: Perhitungan hari rawat inap (LOS) secara real-time yang terus diperbarui.
- **Early Warning System (EWS)**:
  - 🟢 **Normal (≤ 3 hari)**: Pasien dalam batas aman standar perawatan.
  - 🟡 **Warning (4 - 5 hari)**: Pasien mendekati batas overstay. Perlu evaluasi rencana pemulangan.
  - 🔴 **Overstay (≥ 6 hari)**: Pasien melewati standar LOS.
- **Manajemen Role User**:
  - **Perawat**: Memiliki akses CRUD (Tambah, Edit, Pulangkan pasien).
  - **Dokter**: Akses *Read-only* untuk memantau daftar pasien.
- **Filter Overstay Khusus**: Halaman khusus yang hanya menampilkan pasien dengan status overstay.
- **Riwayat Pasien**: Penyimpanan data pasien yang sudah dipulangkan untuk kebutuhan evaluasi ruangan.

## Prasyarat (Requirements)

Sebelum menjalankan aplikasi, pastikan sistem Anda memiliki perangkat lunak berikut:
- PHP >= 8.2
- Composer
- MySQL / MariaDB (via Laragon / XAMPP)
- Node.js & NPM (Opsional, untuk kompilasi aset jika diperlukan)

## Instalasi dan Setup (Cara Clone)

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi di komputer lokal:

### 1. Clone Repository
```bash
git clone <URL_REPOSITORY_GITHUB_ANDA>
cd DashboardMonitoringSederhana
```

### 2. Install Dependensi PHP (Composer)
```bash
composer install
```

### 3. Konfigurasi Environment
Salin file `.env.example` menjadi `.env`.
```bash
cp .env.example .env
```
Buka file `.env` dan sesuaikan konfigurasi database Anda. Contoh jika menggunakan Laragon:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=los_monitoring_rs
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Buat Database dan Jalankan Migrasi + Seeder
Pastikan MySQL Anda sudah menyala, lalu jalankan perintah berikut untuk membuat tabel dan mengisi data contoh (akun login & pasien dummy):
```bash
php artisan migrate --seed
```

### 6. Jalankan Server Lokal
```bash
php artisan serve
```
Aplikasi dapat diakses di browser melalui URL: `http://127.0.0.1:8000`

---

## Akun Demo (Seeder)

Gunakan kredensial berikut untuk mencoba aplikasi:

**Perawat (Full Access)**
- Email: `perawat@rsarifin.id`
- Password: `password123`

**Dokter (View Only)**
- Email: `dokter@rsarifin.id`
- Password: `password123`

---

## Teknologi yang Digunakan
- [Laravel 12](https://laravel.com/) - PHP Web Framework
- [Livewire 3](https://livewire.laravel.com/) - Full-stack framework for Laravel
- [Tailwind CSS](https://tailwindcss.com/) - Utility-first CSS framework
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission) - Role & Permission management

## Lisensi
Aplikasi ini bersifat open-source. Silakan dikembangkan sesuai dengan kebutuhan instansi.
