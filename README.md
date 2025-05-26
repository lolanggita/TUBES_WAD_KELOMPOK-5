# **UKM Platform - Laravel Web App**

Aplikasi platform sistem informasi untuk mendukung kegiatan UKM di lingkungan kampus Telkom University

## 📦 Tech Stack
- Framework: Laravel 11+
- Bahasa: PHP 8.x
- Database: MySQL
- Tools: Git, Postman, Composer
  
## **Cara Clone dan Setup Proyek**
**Clone Repository (Hanya Sekali di Awal)**
1. Clone Repository
   ```bash
   git clone https://github.com/lolanggita/TUBES_WAD_KELOMPOK-5.git
   cd nama-repo [TUBES_WAD_KELOMPOK-5]
2. Install Depedency
   ```terminal
   composer install
   npm install
5. Setup Environment
   sesuaikan konfigurasi database pada file .env
   ```.env 
   DB_DATABASE=nama_database
   DB_USERNAME=root
   DB_PASSWORD=
6. Generate Key & Migrate
   ```terminal
   php artisan key:generate
   php artisan migrate atau php artisan migrate:fresh
8. Jalankan Server
   php artisan serve

## Struktur Folder Utama (Setelah Scaffold Laravel + Breeze + Fitur Awal)
    
    📁 project-root/
    ├── 📁 app/
    │   ├── 📁 Http/
    │   │   ├── 📁 Controllers/
    │   │   │   ├── Auth/                     <-- Dari Breeze
    │   │   │   ├── CommentController.php     <-- Untuk komentar
    │   │   │   ├── DashboardController.php   <-- Untuk dashboard utama
    │   │   │   ├── EventController.php       <-- Untuk postingan kegiatan
    │   │   │   ├── EventRegistrationController.php <-- Untuk registrasi
    │   │   │   ├── GalleryController.php     <-- Untuk galeri UKM
    │   │   │   ├── ReportController.php      <-- Untuk pengaduan
    │   │   │   └── UKMController.php         <-- Untuk profil UKM
    │   ├── 📁 Models/
    │   │   ├── User.php
    │   │   ├── Event.php
    │   │   ├── Comment.php
    │   │   ├── Report.php
    │   │   ├── UKM.php
    │   │   ├── Gallery.php
    │   │   └── EventRegistration.php
    ├── 📁 database/
    │   ├── 📁 migrations/
    │   │   ├── 202x_xx_xx_create_events_table.php
    │   │   ├── 202x_xx_xx_create_comments_table.php
    │   │   ├── 202x_xx_xx_create_reports_table.php
    │   │   ├── 202x_xx_xx_create_ukms_table.php
    │   │   ├── 202x_xx_xx_create_galleries_table.php
    │   │   └── 202x_xx_xx_create_event_registrations_table.php
    ├── 📁 routes/
    │   ├── web.php        <-- untuk route user/login/view
    │   └── api.php        <-- endpoint untuk akses API via Postman
    ├── 📁 resources/
    │   ├── 📁 views/       <-- view blade jika digunakan
    │   │   └── ...         <-- ex: events, dashboard, etc.
    ├── 📁 public/
    │   └── 📁 storage/ (jika nanti upload file)
    ├── .env               <-- konfigurasi koneksi DB, APP_KEY, dll.
    ├── README.md          <-- panduan kerja proyek
    └── ...

## Pengarahan pengerjaan 
| Fitur                        | File Terkait                                                    | Tanggung Jawab Developer | Penjelasan Pekerjaan                                                                                                               |
| ---------------------------- | --------------------------------------------------------------- | ------------------------ | ---------------------------------------------------------------------------------------------------------------------------------- |
| 1. Postingan Kegiatan        | EventController, Event model, migration events                  | Anggota 1                | Implementasi CRUD postingan kegiatan (create, update, delete, list), dengan tipe kegiatan yang bisa memiliki registrasi atau tidak |
| 2. Komentar Postingan        | CommentController, Comment model, migration comments            | Anggota 2                | Komentar untuk postingan. Komentar harus terhubung ke event dan user                                                               |
| 3. Registrasi dari Postingan | EventRegistrationController, EventRegistration model, migration | Anggota 3                | Pengguna dapat mendaftar ke event jika `is_registrable == true`. Buat form + validasi API untuk registrasi                         |
| 4. Pengaduan Postingan       | ReportController, Report model, migration reports               | Anggota 4                | Form pelaporan untuk postingan (misalnya: spam, tidak pantas). Hubungkan ke postingan dan user yang melaporkan                     |
| 5. Profil UKM                | UKMController, UKM model, migration ukms                        | Anggota 5                | CRUD profil UKM (nama, deskripsi, logo, kontak). Dapat disesuaikan oleh masing-masing UKM                                          |
| 6. Galeri Dokumentasi UKM    | GalleryController, Gallery model, migration galleries           | Anggota 6                | Upload dan list gambar kegiatan. Hanya bisa dilakukan oleh akun UKM yang terkait                                                   |
| 7. Login & Register          | Auth (Breeze)                                                   | Semua (default)          | Breeze sudah menyediakan login & register. Bisa digunakan langsung.                                                                |
| 8. Dashboard                 | DashboardController                                             | Frontend/UI              | Menampilkan data ringkasan, postingan terbaru, status pengguna, dll                                                                |


## **Cara Push dengan branch masing-masing nama**
1. Buat branch
   ```bash
   git checkout -b fitur-nama    <-- nama branch (bisa dibuat dengan nama fitur yang dikerjakan)
5. Setelah mengedit => push branch ke github
   ```bash
   git add .
   git commit -m "feat: membuat fitur komentar dasar"
   git push origin fitur-nama-fitur
7. Buat pull request (PR) di github
   - Buka GitHub repository kamu.
   - Akan muncul tombol: “Compare & pull request” → klik.
   - Pastikan base branch = main, compare = fitur-nama.
   - Beri judul dan deskripsi PR (misalnya: "Menambahkan fitur komentar").
   - Klik “Create pull request”.
9. Review & merge (Oleh ketua tim)
   Setelah PR disetujui oleh tim, klik “Merge pull request”.
   Klik “Confirm merge”.
   Setelah merge, branch fitur-nama bisa dihapus jika sudah tidak dipakai.
   
## **Catatan Tambahan**
1. Gunakan route web.php untuk halaman view, dan api.php untuk endpoint API (akses dari Postman atau frontend JS).
2. Pastikan semua fitur ada validasi inputnya, baik di sisi controller maupun di database.
3. Gunakan relasi antar model: misalnya Event hasMany Comments, User hasMany Registrations, dll.
4. Setiap anggota kerja di branch masing-masing, lalu lakukan pull request ke branch main.
