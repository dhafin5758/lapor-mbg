
# Lapor-MBG

Aplikasi berbasis web untuk membantu proses pelaporan, peninjauan, pemantauan, dan rekapitulasi laporan terkait keamanan makanan dalam program Makan Bergizi Gratis (MBG).

## Deskripsi Project

Aplikasi ini dikembangkan untuk memfasilitasi pelaporan permasalahan keamanan makanan MBG oleh Pelapor, proses peninjauan oleh Pemantau Komunitas, serta pengelolaan tindak lanjut dan rekapitulasi oleh Koordinator Komunitas.

Aplikasi menerapkan autentikasi dan pembatasan hak akses berdasarkan peran pengguna (*Role-Based Access Control*).

## Identitas Mahasiswa

Nama: Muhammad Dhafin Ramadhan

NIM : 251511019

Kelas : D3-2A


## Teknologi yang Digunakan

- PHP 8.3
- Laravel 13
- MySQL
- Bootstrap 5
- JavaScript
- HTML
- CSS

## Persyaratan Instalasi

Pastikan perangkat telah memiliki:

- PHP 8.3 atau versi yang kompatibel dengan project.
- Composer.
- MySQL.
- Node.js dan NPM 
- Git.

## Instalasi dan Menjalankan Project

### 1. Clone Repository

```bash
git clone https://github.com/dhafin5758/lapor-mbg
```

Masuk ke direktori project:

```bash
cd lapor-mbg
```

### 2. Install Dependency

```bash
composer install
```

Jika project menggunakan dependency frontend:

```bash
npm install
```

### 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`.

Untuk Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Sesuaikan konfigurasi database pada file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lapor_mbg
DB_USERNAME=root
DB_PASSWORD=
```

Buat database `lapor_mbg` melalui MySQL.

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Jalankan Migration

```bash
php artisan migrate
```

### 6. Buat Storage Link

```bash
php artisan storage:link
```

### 7. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi dapat diakses melalui:

```text
http://127.0.0.1:8000
```



## Akun Pengujian

Akun berikut disediakan untuk kebutuhan pengujian:

| Role | Email | Password |
|---|---|---|
| Pelapor  | pelapor@mbg.test | password123 |
| Pelapor  | pelaporb@mbg.test | password123 | 
| Pemantau | pemantau@mbg.test | password123 |
| Koordinator | koordinator@mbg.test | password123 |



## Penyimpanan File Bukti

File bukti laporan disimpan menggunakan Laravel Filesystem pada disk `public`, di direktori:

```text
storage/app/public/evidence
```

File dapat diakses melalui  direktori `public/storage`.

