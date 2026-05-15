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

Sebelum menjalankan dan mengembangkan aplikasi di komputer/laptop client, pastikan sistem Anda memiliki perangkat lunak berikut:
- **Visual Studio Code (VS Code)** (Sebagai Text Editor)
- PHP >= 8.2
- Composer
- MySQL / MariaDB (via Laragon / XAMPP)
- Node.js & NPM (Opsional, untuk kompilasi aset jika diperlukan)

## Instalasi dan Setup (Cara Clone)

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi di komputer lokal:

### 1. Clone Repository ke Komputer Client
Buka terminal di dalam VS Code (atau command prompt), lalu arahkan ke direktori tempat Anda ingin menyimpan proyek (misalnya `htdocs` untuk XAMPP atau `www` untuk Laragon), kemudian jalankan:
```bash
git clone https://github.com/USERNAME_GITHUB_ANDA/DashboardMonitoringSederhana.git
cd DashboardMonitoringSederhana
```
*Catatan: Ganti URL di atas dengan link repository GitHub Anda.*

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

Gunakan kredensial berikut untuk mencoba masuk ke sistem. Login kini menggunakan **Username**.

**Admin (Manajemen Sistem)**
- Username: `admin`
- Password: `admin` *(Password admin bersifat case-insensitive, huruf besar/kecil tidak masalah)*

**Perawat (Full Access: Tambah, Edit, Pulang)**
- Username: `DAHLIASURGIKAL`
- Password: `DAHLIASURGIKAL`

**Dokter (View Only)**
- Username: `drahmadfauzi`
- Password: `password123`

---

## 🚀 Deployment ke Vercel (Gratis)

Aplikasi ini sudah dikonfigurasi untuk dapat di-deploy ke **Vercel** secara gratis. File konfigurasi `vercel.json` dan `api/index.php` (untuk menangani *Serverless Functions* PHP) telah disediakan.

### Langkah-Langkah Deployment:
1. **Siapkan Database Eksternal**: Vercel tidak menyediakan layanan database. Anda harus membuat database MySQL/PostgreSQL secara gratis di layanan seperti **[Supabase](https://supabase.com/)**, **[Aiven](https://aiven.io/)**, atau **[PlanetScale](https://planetscale.com/)**.
2. **Login ke Vercel**: Buat akun dan login di [Vercel](https://vercel.com).
3. **Hubungkan GitHub**: Klik "Add New Project" dan pilih "Import from Git Repository". Pilih repository aplikasi ini.
4. **Konfigurasi Environment**: Sebelum klik "Deploy", buka menu "Environment Variables" dan masukkan variabel dari database eksternal Anda (seperti `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, dan `APP_KEY`).
5. **Klik Deploy**: Tunggu proses build selesai (Vercel akan menggunakan `vercel-php` otomatis berdasarkan `vercel.json`).
6. **Migrasi Database**: Karena Vercel adalah lingkungan *serverless*, Anda perlu menjalankan migrasi `php artisan migrate --force --seed` dari komputer Anda (lokal) yang dihubungkan ke *host* database eksternal Anda (Supabase/Aiven) sebelum aplikasi Vercel dapat digunakan.

*Catatan Vercel: Fitur upload file (gambar/dokumen) secara lokal (`/storage`) tidak akan berfungsi di Vercel karena sistem file yang bersifat read-only. Namun, aplikasi pemantauan ini murni menggunakan database sehingga akan berjalan 100% lancar di Vercel.*

---

## Teknologi yang Digunakan
- [Laravel 12](https://laravel.com/) - PHP Web Framework
- [Livewire 3](https://livewire.laravel.com/) - Full-stack framework for Laravel
- [Tailwind CSS](https://tailwindcss.com/) - Utility-first CSS framework
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission) - Role & Permission management

## Lisensi
Aplikasi ini bersifat open-source. Silakan dikembangkan sesuai dengan kebutuhan instansi.
