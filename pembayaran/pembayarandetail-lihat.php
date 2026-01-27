<?php
session_start();
include '../koneksi.php';

// Inisialisasi $no_pembayaran dari URL dengan penanganan error
if (isset($_GET['no_pembayaran'])) {
    $no_pembayaran = mysqli_real_escape_string($conn, $_GET['no_pembayaran']);
} else {
    die("Error: No Pembayaran tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembayaran</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #fde2e4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 50px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background: #ff80ab;
            color: #ffffff;
            font-weight: 600;
        }
        .card-header h5 {
            margin: 0;
        }
        .btn-warning {
            background: #ffca28;
            border-color: #ffca28;
            color: #ffffff;
        }
        .btn-warning:hover {
            background: #ffb300;
            border-color: #ffb300;
        }
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            padding: 10px;
            background: #d1c4e9;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            background: #ffffff;
        }
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            background: #b3e5fc;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: #ff80ab;
            color: #ffffff !important;
            border: none;
            border-radius: 4px;
            margin: 0 2px;
            padding: 5px 10px;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #ec407a;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #ec407a;
        }
        table.dataTable thead th {
            background: #ff80ab;
            color: #ffffff;
            border-bottom: 2px solid #fff;
        }
        table.dataTable.no-footer {
            border-bottom: 1px solid #ddd;
        }
        table.dataTable tbody tr:nth-child(even) {
            background: #fce4ec;
        }
        .btn-group .btn {
            padding: 5px 10px;
            margin: 0 2px;
            border-radius: 4px;
        }
        .btn-success {
            background: #81c784;
            border-color: #81c784;
        }
        .btn-success:hover {
            background: #66bb6a;
        }
        .btn-danger {
            background: #ef9a9a;
            border-color: #ef9a9a;
        }
        .btn-danger:hover {
            background: #ef5350;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>TABEL DETAIL PEMBAYARAN</h5>
                <a href="pembayarandetail-tambah.php?no_pembayaran=<?php echo htmlspecialchars($no_pembayaran); ?>" class="btn btn-warning">Tambah</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered table-hover" style="width:100%; text-align: center;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Pembayaran</th>
                                <th>Barang</th>
                                <th>Banyaknya</th>
                                <th>Jumlah Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $index = 1;
                            $jumlahRp = 0; // Inisialisasi grand total
                            $query = mysqli_query($conn, "SELECT dp.no_pembayaran, dp.id_barang, dp.banyaknya, dp.jumlah_harga, b.nama_barang
                                                          FROM detail_pembayaran dp
                                                          JOIN barang b ON dp.id_barang = b.id_barang
                                                          WHERE dp.no_pembayaran = '$no_pembayaran'");

                            while ($data_barang = mysqli_fetch_array($query)) {
                                $jumlahRp += $data_barang['jumlah_harga'];
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($index++); ?></td>
                                    <td><?php echo htmlspecialchars($data_barang['no_pembayaran']); ?></td>
                                    <td><?php echo htmlspecialchars($data_barang['nama_barang']); ?></td>
                                    <td><?php echo htmlspecialchars($data_barang['banyaknya']); ?></td>
                                    <td><?php echo number_format($data_barang['jumlah_harga'], 0, ',', '.'); ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-sm btn-success" href="pembayarandetail-ubah.php?no_pembayaran=<?php echo htmlspecialchars($no_pembayaran); ?>&id_barang=<?php echo htmlspecialchars($data_barang['id_barang']); ?>" data-toggle="tooltip" title="Ubah"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-sm btn-danger delete-link" href="pembayarandetail-hapus.php?no_pembayaran=<?php echo htmlspecialchars($no_pembayaran); ?>&id_barang=<?php echo htmlspecialchars($data_barang['id_barang']); ?>" data-toggle="tooltip" title="Hapus" onclick="return confirm('Yakin hapus?')"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>

                            <!-- Total -->
                            <?php
                            $updateFakturQuery = "UPDATE pembayaran SET jumlahRp = '$jumlahRp' WHERE no_pembayaran = '$no_pembayaran'";
                            mysqli_query($conn, $updateFakturQuery);
                            ?>
                            <tr>
                                <td colspan="4" style="text-align: center;"><strong>TOTAL HARGA</strong></td>
                                <td><?php echo number_format($jumlahRp, 0, ',', '.'); ?></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <a class="btn btn-primary mt-3" href="pembayaranlihat.php">Kembali</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('[data-toggle="tooltip"]').tooltip();
        });

        document.querySelectorAll('.delete-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                Swal.fire({
                    title: 'Yakin hapus?',
                    text: "Data detail pembayaran akan dihapus secara permanen.",
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

    <?php
    if (isset($_SESSION['success'])) {
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