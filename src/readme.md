# Ebidancare - Sistem Manajemen Klinik Bidan

Ebidancare adalah sistem manajemen klinik bidan berbasis web yang dibangun dengan Laravel dan Filament PHP. Sistem ini menyediakan manajemen pasien, rekam medis, dokumen, dan transaksi untuk praktik bidan.

## 📋 Fitur Utama

- **Manajemen Pasien** - Pendaftaran dan pengelolaan data pasien
- **Rekam Medis** - Pencatatan dan pengelolaan riwayat kesehatan pasien
- **Manajemen Dokumen** - Penyimpanan dan pengelolaan dokumen medis
- **Transaksi** - Pencatatan transaksi pembayaran dan layanan
- **Dashboard Admin** - Visualisasi data dengan grafik dan statistik
- **Autentikasi & Otorisasi** - Sistem login dan peran pengguna
- **Activity Logging** - Pencatatan aktivitas sistem

## 🛠️ Teknologi

- **Backend:** Laravel 11.x
- **Admin Panel:** Filament PHP 3.x
- **Database:** MySQL 8.0
- **Web Server:** Nginx
- **Container:** Docker & Docker Compose
- **File Storage:** Cloudflare R2 / Local
- **Authentication:** Filament Authentication
- **Permissions:** Filament Shield & Spatie Permissions

## 📁 Struktur Project

```
ebidancare/
├── docker-compose.yml     # Konfigurasi Docker Compose
├── src/                   # Aplikasi Laravel
│   ├── app/               # Core application code
│   │   ├── Console/       # Artisan commands
│   │   ├── Filament/      # Filament admin resources & widgets
│   │   ├── Http/          # HTTP controllers
│   │   ├── Models/        # Eloquent models
│   │   ├── Policies/      # Authorization policies
│   │   └── Providers/     # Service providers
│   ├── bootstrap/         # Laravel bootstrap files
│   ├── config/            # Configuration files
│   ├── database/          # Migrations & seeders
│   ├── public/            # Public assets
│   ├── resources/         # Views & CSS/JS
│   ├── routes/            # Route definitions
│   └── storage/           # Storage files & logs
├── nginx/                 # Nginx configuration & Dockerfile
├── php/                   # PHP Dockerfile & configuration
└── db/                    # Database configuration
```

## 🚀 Panduan Instalasi

### Prasyarat

- Docker & Docker Compose
- Git
- Browser modern

### Langkah Instalasi

1. **Clone repository:**
   ```bash
   git clone <repository-url>
   cd ebidancare
   ```

2. **Salin file environment:**
   ```bash
   cp src/.env.example src/.env
   ```

3. **Configure environment variables di `src/.env`:**
   ```env
   APP_NAME="Ebidancare"
   APP_URL=http://localhost
   APP_DOMAIN=localhost

   DB_CONNECTION=mysql
   DB_HOST=db
   DB_PORT=3306
   DB_DATABASE=ebidancare
   DB_USERNAME=ebidancare
   DB_PASSWORD=password

   FILAMENT_FILESYSTEM_DISK=r2
   R2_ACCESS_KEY_ID=your_access_key
   R2_SECRET_ACCESS_KEY=your_secret_key
   R2_BUCKET=ebidancare-documents
   R2_ENDPOINT=https://your-account.r2.cloudflarestorage.com
   R2_REGION=auto
   ```

4. **Jalankan Docker Compose:**
   ```bash
   docker-compose up -d
   ```

5. **Install dependencies:**
   ```bash
   docker-compose exec php composer install
   docker-compose exec php npm install
   ```

6. **Generate application key:**
   ```bash
   docker-compose exec php php artisan key:generate
   ```

7. **Jalankan migrasi database:**
   ```bash
   docker-compose exec php php artisan migrate --seed
   ```

8. **Build assets:**
   ```bash
   docker-compose exec php npm run build
   ```

9. **Akses aplikasi:**
   - Admin Panel: http://localhost/admin
   - Default credentials: admin@ebidancare.test / password

## 📦 Available Commands

```bash
# Project initialization
php artisan project:initialize

# Project update
php artisan project:update

# Recache configuration
php artisan recache

# Development IDE helper
php artisan dev:ide
```

## 📊 Model & Relasi

| Model | Tabel | Deskripsi |
|-------|-------|-----------|
| Patient | patients | Data pasien klinik |
| MedicalRecord | medical_records | Rekam medis pasien |
| Document | documents | Dokumen medis pasien |
| Transaction | transactions | Transaksi pembayaran |

## 🔐 Peran & Izin

Sistem menggunakan Filament Shield untuk manajemen peran:

- **Super Admin** - Akses penuh ke semua fitur
- **Admin** - Akses admin dengan batasan tertentu
- **Bidan** - Akses fitur pelayanan pasien

## 📝 Konfigurasi Storage

Sistem mendukung Cloudflare R2 untuk penyimpanan dokumen:

```env
FILAMENT_FILESYSTEM_DISK=r2
R2_BUCKET=ebidancare-documents
R2_ENDPOINT=https://<ACCOUNT_ID>.r2.cloudflarestorage.com
```

Untuk penggunaan lokal, ubah `FILAMENT_FILESYSTEM_DISK` menjadi `local`.

## 🐳 Docker Commands

```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# View logs
docker-compose logs -f

# Execute PHP command
docker-compose exec php php artisan <command>

# Execute Composer
docker-compose exec php composer <command>

# Execute NPM
docker-compose exec php npm <command>
```

## 📄 Lisensi

Proyek ini adalah proprietary software.

## 👥 Kontak

Untuk dukungan, silakan hubungi tim pengembang.
