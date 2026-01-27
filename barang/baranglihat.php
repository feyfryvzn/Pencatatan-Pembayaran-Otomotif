<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📦 Daftar Barang - Auto Otomotif ⚙️</title>
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
            margin-top: 20px;
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
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .pagination a {
            display: inline-block;
            padding: 8px 12px;
            margin: 0 5px;
            background: #80d8ff;
            color: #ffffff;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
        }
        .pagination a.current {
            background: #ff80ab;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>📦 Daftar Barang</h3>
        <a class="kembali" href="../dashboard.php">🏠 HOME</a>
        <a class="kembali" href="barangtambah.php">➕ Tambah Barang</a>
        <table>
            <tr>
                <th>ID Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
            <?php
                include '../koneksi.php';
                $limit = 10;
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $start = ($page - 1) * $limit;
                $query = mysqli_query($conn, "SELECT * FROM barang LIMIT $start, $limit");
                while ($data = mysqli_fetch_array($query)) {
            ?>
                <tr>
                    <td><?php echo $data['id_barang']; ?></td>
                    <td><?php echo $data['nama_barang']; ?></td>
                    <td><?php echo $data['harga']; ?></td>
                    <td class="action-buttons">
                        <a href="barangubah.php?id_barang=<?php echo $data['id_barang']; ?>">📝 Ubah</a>
                        <!-- Hapus: hilangkan onclick dan tambahkan kelas "delete-link" -->
                        <a class="delete-link" href="baranghapus.php?id_barang=<?php echo $data['id_barang']; ?>">❌ Hapus</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <?php
                $query_total = mysqli_query($conn, "SELECT COUNT(*) as total FROM barang");
                $data_total = mysqli_fetch_assoc($query_total);
                $total_pages = ceil($data_total['total'] / $limit);

                if ($page > 1) {
                    echo '<a href="?page=' . ($page - 1) . '">Back</a>';
                }

                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == $page) {
                        echo '<a href="?page=' . $i . '" class="current">' . $i . '</a>';
                    } else {
                        echo '<a href="?page=' . $i . '">' . $i . '</a>';
                    }
                }

                if ($page < $total_pages) {
                    echo '<a href="?page=' . ($page + 1) . '">Next</a>';
                }
            ?>
        </div>
    </div>

    <script>
        // Tambahkan event listener untuk link hapus agar menampilkan SweetAlert konfirmasi
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
                        // Jika pengguna mengonfirmasi, arahkan ke URL hapus
                        window.location.href = href;
                    }
                });
            });
        });

        // Tampilkan notifikasi sukses jika terdapat query parameter status=deleted
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('status') === 'deleted') {
            Swal.fire({
                title: 'Terhapus!',
                text: 'Data barang telah dihapus.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }
    </script>
</body>
</html>
