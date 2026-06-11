# Companion Release Cheatsheet 🚀

Sebuah aplikasi web berbasis **PHP** yang dirancang untuk mengelola, melacak, dan menyimpan catatan rilis (*release cheatsheets*). Aplikasi ini dilengkapi dengan sistem autentikasi, dashboard manajemen, operasi CRUD yang lengkap, serta fitur filter dan ekspor data untuk memudahkan pengguna.

## ✨ Fitur Utama

- **Sistem Autentikasi**: Fitur *Login*, *Register*, *Logout*, dan manajemen *Profile* pengguna.
- **Dashboard**: Tampilan antarmuka utama (`dashboard.php`) untuk melihat ringkasan aktivitas dan rilis.
- **Manajemen Rilis (CRUD)**: 
  - Menambah rilis baru (`create.php`)
  - Melihat detail rilis (`view.php`, `all_releases.php`)
  - Memperbarui rilis & status (`edit.php`, `update_release.php`, `update_status.php`)
  - Menghapus rilis (`delete.php`)
- **Filter Waktu & Data**: Fitur filter cerdas untuk melihat data berdasarkan waktu seperti:
  - Hari ini (`today.php`)
  - Kemarin (`kemaren.php`)
  - Tahunan (`tahun.php`)
  - Filter khusus lainnya (`filter.php`)
- **Ekspor Data**: Memudahkan untuk mengunduh atau mengekspor data rilis yang sudah dicatat (`export.php`).

## 🛠️ Teknologi yang Digunakan

- **Backend**: PHP
- **Database**: MySQL
- **Frontend/Styling**: HTML & CSS (berada di folder `assets/css`)

## 📋 Persyaratan (Prerequisites)

Sebelum menjalankan proyek ini, pastikan sistem kamu sudah terpasang:
- Web Server lokal (XAMPP, MAMP, Laragon, dll.)
- PHP (disarankan versi 7.4 atau 8.x)
- MySQL / MariaDB

## 🚀 Cara Instalasi

1. **Clone repositori ini** ke dalam direktori server lokal kamu (contoh: folder `htdocs` jika menggunakan XAMPP):
   ```bash
   git clone [https://github.com/endrisusanto/companion-release-cheatsheet.git](https://github.com/endrisusanto/companion-release-cheatsheet.git)
