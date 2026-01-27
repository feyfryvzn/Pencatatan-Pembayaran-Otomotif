<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pegawai - Auto Otomotif ⚙️</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <!-- Sertakan SweetAlert 3 dari CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #fde2e4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        h3 {
            color: #ff80ab;
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 12px;
            border: 1px solid #b0bec5;
            text-align: center;
        }
        table th {
            background: #ff80ab;
            color: #ffffff;
        }
        table tr:nth-child(even) {
            background: #fce4ec;
        }
        .action-buttons a {
            padding: 8px 12px;
            margin: 0 5px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            color: #ffffff;
            background: #80d8ff;
            transition: background 0.2s;
        }
        .action-buttons a:hover {
            background: #40c4ff;
        }
        .kembali {
            display: inline-block;
            padding: 12px 24px;
            margin-bottom: 15px;
            background: #ff80ab;
            color: #ffffff;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            text-align: center;
        }
        .kembali:hover {
            background: #ff4081;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Daftar Pegawai</h3>
        <a class="kembali" href="../dashboard.php">🏠 HOME</a>
        <a class="kembali" href="pegawaitambah.php">➕ Tambah Pegawai</a>
        <table>
            <thead>
                <tr>
                    <th>Id Pegawai</th>
                    <th>Nama Pegawai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include '../koneksi.php';
                    $query = mysqli_query($conn, "SELECT * FROM pegawai");
                    while ($data = mysqli_fetch_array($query)) {
                ?>
                <tr>
                    <td><?php echo $data['id_pegawai']; ?></td>
                    <td><?php echo $data['nama_pegawai']; ?></td>
                    <td class="action-buttons">
                        <a href="pegawaiubah.php?id_pegawai=<?php echo $data['id_pegawai']; ?>">📝 Ubah</a>
                        <!-- Ganti tombol hapus dengan kelas "delete-link" -->
                        <a class="delete-link" href="pegawaihapus.php?id_pegawai=<?php echo $data['id_pegawai']; ?>">❌ Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        // Event listener untuk konfirmasi hapus dengan SweetAlert 3
        document.querySelectorAll('.delete-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                Swal.fire({
                    title: 'Yakin hapus?',
                    text: "Data akan dihapus secara permanen.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }
                });
            });
        });
    </script>

    <!-- Tampilkan notifikasi sukses menggunakan flash session -->
    <?php
    if(isset($_SESSION['success'])) {
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: '" . $_SESSION['success'] . "',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>";
        unset($_SESSION['success']);
    }
    ?>
</body>
</html>
