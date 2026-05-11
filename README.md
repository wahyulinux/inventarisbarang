# Sistem Inventaris Barang (Laravel)

Aplikasi manajemen inventaris barang sederhana yang dibangun menggunakan Laravel 10.

## Prasyarat (Prerequisites)

Sebelum memulai, pastikan Anda telah menginstal:
- PHP >= 8.1
- Composer
- MySQL atau MariaDB
- Docker & Docker Compose (Opsional, untuk instalasi via Docker)

---

## Cara Instalasi (Lokal Tanpa Docker)

1.  **Clone Repositori**
    ```bash
    git clone <url-repositori>
    cd inventarisbarang
    ```

2.  **Instal Dependensi**
    ```bash
    composer install
    ```

3.  **Pengaturan Environment**
    Salin file `.env.example` menjadi `.env`:
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` dan sesuaikan pengaturan database Anda:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=inventory_db
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Generate App Key**
    ```bash
    php artisan key:generate
    ```

5.  **Migrasi dan Seed Data**
    Pastikan database `inventory_db` sudah dibuat di MySQL Anda, lalu jalankan:
    ```bash
    php artisan migrate --seed
    ```

6.  **Jalankan Server**
    ```bash
    php artisan serve
    ```
    Aplikasi dapat diakses di `http://localhost:8000`.

---

## Cara Instalasi (Menggunakan Docker)

Aplikasi ini sudah dilengkapi dengan konfigurasi Docker.

1.  **Build dan Jalankan Kontainer**
    ```bash
    docker-compose up -d --build
    ```

2.  **Instal Dependensi (Di dalam Kontainer)**
    ```bash
    docker exec -it laravel_app composer install
    ```

3.  **Generate App Key**
    ```bash
    docker exec -it laravel_app php artisan key:generate
    ```

4.  **Migrasi dan Seed Data**
    ```bash
    docker exec -it laravel_app php artisan migrate --seed
    ```

5.  **Akses Aplikasi**
    - **Aplikasi:** [http://localhost:8080](http://localhost:8080)
    - **phpMyAdmin:** [http://localhost:8081](http://localhost:8081)

---

## Akun Login Default (Seed)

Jika Anda menjalankan `--seed`, Anda dapat masuk menggunakan akun administrator default:
- **Username:** `admin`
- **Password:** `admin123`

## Struktur Database Penting
- `categories`: Kategori barang.
- `items`: Data barang.
- `warehouses`: Data gudang.
- `transactions`: Riwayat keluar masuk barang.
- `users`: Data pengguna (Admin/Staff).

## Lisensi
Aplikasi ini menggunakan lisensi MIT.
