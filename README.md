# Sistem Inventaris Barang (Laravel Docker)

Aplikasi manajemen inventaris barang yang dibangun dengan Laravel 10+, PostgreSQL, dan Redis, dibungkus menggunakan Docker untuk kemudahan deployment.

## Prasyarat
- [Docker](https://docs.docker.com/get-docker/) & [Docker Compose](https://docs.docker.com/compose/install/)
- [Git](https://git-scm.com/)

---

## 🛠 Panduan Development (Lokal)

Gunakan metode ini jika Anda ingin mengembangkan aplikasi di komputer lokal. Perubahan kode akan langsung terlihat (hot-reload) tanpa perlu build ulang.

1. **Clone Repository:**
   ```bash
   git clone <url-repository> inventaris-app
   cd inventaris-app
   ```

2. **Persiapan Environment:**
   ```bash
   cp .env.example .env
   ```

3. **Jalankan Container:**
   ```bash
   docker-compose up -d --build
   ```

4. **Instalasi Awal:**
   ```bash
   docker-compose exec app composer install
   docker-compose exec app php artisan key:generate
   docker-compose exec app php artisan migrate --seed
   ```

5. **Akses Aplikasi:**
   - **Aplikasi:** [http://localhost:8080](http://localhost:8080)
   - **Database (PostgreSQL):** `localhost:5432`

---

## 🚀 Panduan Deployment (Production)

Gunakan metode ini untuk mendeploy di server VPS. Kode akan "dibakar" langsung ke dalam image Docker untuk keamanan dan performa maksimal.

1. **Clone & Persiapan di Server:**
   ```bash
   git clone <url-repository> inventaris-app
   cd inventaris-app
   cp .env.example .env
   ```
   *Edit `.env` dan sesuaikan `APP_ENV=production`, `APP_DEBUG=false`, serta password database.*

2. **Build & Jalankan (Production Mode):**
   ```bash
   docker-compose -f docker-compose.prod.yml up -d --build
   ```

3. **Setup Awal (Hanya sekali):**
   ```bash
   docker-compose -f docker-compose.prod.yml exec app php artisan key:generate
   docker-compose -f docker-compose.prod.yml exec app php artisan migrate --force --seed
   ```

4. **Optimasi Laravel:**
   ```bash
   docker-compose -f docker-compose.prod.yml exec app php artisan config:cache
   docker-compose -f docker-compose.prod.yml exec app php artisan route:cache
   docker-compose -f docker-compose.prod.yml exec app php artisan view:cache
   ```

---

## 📋 Perintah Penting (Cheat Sheet)

### Management Container
- **Melihat Log:** `docker-compose logs -f app`
- **Menghentikan Container:** `docker-compose down`
- **Masuk ke Terminal Container:** `docker-compose exec app bash`

### Laravel Artisan (via Docker)
Selalu jalankan perintah artisan melalui container `app`.
- **Reset Database:** `docker-compose exec app php artisan migrate:fresh --seed`
- **Clear Cache:** `docker-compose exec app php artisan cache:clear`

### Cara Update Aplikasi di Production
Jika ada perubahan kode di repository:
```bash
git pull origin main
docker-compose -f docker-compose.prod.yml up -d --build
docker-compose -f docker-compose.prod.yml exec app php artisan migrate --force
```

---

## Layanan yang Tersedia
- **PHP 8.1 Apache** (Service: `app`)
- **PostgreSQL 15** (Service: `db`)
- **Redis Alpine** (Service: `redis`)
