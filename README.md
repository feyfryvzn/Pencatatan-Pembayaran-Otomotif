# Sistem Informasi Pencatatan Pembayaran Otomotif

Sistem informasi berbasis web yang dirancang untuk mengelola data transaksi pembayaran di sektor otomotif secara terorganisir. Aplikasi ini memungkinkan pengguna untuk mencatat data pelanggan, kendaraan, pegawai, serta mengelola rincian pembayaran layanan secara efisien.

## 🚀 Fitur Utama
Sistem ini mencakup berbagai modul fungsional, antara lain:
* **Manajemen Data Master**: Pengelolaan database pelanggan, data mobil, dan informasi pegawai.
* **Inventaris Barang**: Pencatatan data barang atau *sparepart* yang digunakan dalam layanan otomotif.
* **Transaksi Pembayaran**: Fitur utama untuk mencatat pembayaran layanan secara mendetail.
* **Pelaporan & Cetak**: Kemampuan untuk menghasilkan dan mencetak struk atau bukti pembayaran bagi pelanggan.
* **Dashboard Interaktif**: Halaman ringkasan untuk memantau aktivitas transaksi terbaru.
* **Sistem Keamanan**: Dilengkapi dengan mekanisme login untuk melindungi akses data.

## 🛠️ Teknologi yang Digunakan
Proyek ini dibangun menggunakan teknologi stack berikut:
* **Bahasa Pemrograman**: PHP
* **Database**: MySQL (MariaDB)
* **Frontend**: HTML5, CSS3, JavaScript
* **Library**: jQuery & Popper.js untuk interaksi UI yang lebih dinamis

## 📂 Struktur Repositori
* `/barang`: Modul manajemen data barang/onderdil.
* `/mobil`: Modul khusus untuk pengelolaan data kendaraan pelanggan.
* `/pegawai`: Modul manajemen data staf dan teknisi.
* `/pelanggan`: Modul manajemen data informasi pelanggan.
* `/pembayaran`: Modul inti pengolahan transaksi dan fitur cetak bukti bayar.
* `/images`: Aset gambar pendukung antarmuka aplikasi.
* `dashboard.php`: Halaman utama ringkasan sistem.
* `strukfeyza.sql`: Skema database lengkap untuk inisialisasi sistem.

## 💻 Cara Instalasi
1.  **Clone Repositori**:
    ```bash
    git clone [https://github.com/feyfryvzn/Pencatatan-Pembayaran-Otomotif.git](https://github.com/feyfryvzn/Pencatatan-Pembayaran-Otomotif.git)
    ```
2.  **Persiapan Database**:
    * Impor file `strukfeyza.sql` ke dalam database MySQL kamu.
3.  **Konfigurasi Koneksi**:
    * Sesuaikan pengaturan kredensial database pada file `koneksi.php`.
4.  **Jalankan Aplikasi**:
    * Tempatkan folder proyek di direktori server lokal (seperti `htdocs` pada XAMPP).
    * Akses aplikasi melalui browser di `http://localhost/Pencatatan-Pembayaran-Otomotif`.

---
*Dibuat oleh **Feyza Revalina** sebagai bagian dari portofolio Sistem Informasi Industri Otomotif.*
