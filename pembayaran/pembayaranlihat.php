<?php
session_start();
include '../koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>💳 Tabel Pembayaran - Auto Otomotif ⚙️</title>
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
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>💳 Data Pembayaran</h5>
                <a href="pembayarantambah.php" class="btn btn-warning">+ TAMBAHKAN</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered table-hover" style="width:100%; text-align: center;">
                        <thead class="thead-dark">
                            <tr>
                                <th>No Pembayaran</th>
                                <th>No Polisi</th>
                                <th>Pegawai</th>
                                <th>Tanggal</th>
                                <th>Jumlah Rp</th>
                                <th>Aksi</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($conn, "SELECT p.no_pembayaran, p.nopol, p.tanggal, p.jumlahRp, pg.nama_pegawai
                                                          FROM pembayaran p
                                                          JOIN mobil m ON p.nopol = m.nopol
                                                          JOIN pegawai pg ON p.id_pegawai = pg.id_pegawai");
                            while ($data = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($data['no_pembayaran']); ?></td>
                                    <td><?php echo htmlspecialchars($data['nopol']); ?></td>
                                    <td><?php echo htmlspecialchars($data['nama_pegawai']); ?></td>
                                    <td><?php echo htmlspecialchars($data['tanggal']); ?></td>
                                    <td><?php echo number_format($data['jumlahRp'], 0, ',', '.'); ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-sm btn-success" href="pembayaranubah.php?no_pembayaran=<?php echo $data['no_pembayaran']; ?>" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-sm btn-danger delete-link" href="pembayaranhapus.php?no_pembayaran=<?php echo $data['no_pembayaran']; ?>" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-sm btn-secondary" href="pembayarandetail-lihat.php?no_pembayaran=<?php echo $data['no_pembayaran']; ?>" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
                                            <a class="btn btn-sm btn-primary" href="pembayarancetak.php?no_pembayaran=<?php echo $data['no_pembayaran']; ?>" data-toggle="tooltip" title="Cetak"><i class="fa fa-print"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <a class="btn btn-primary mt-3" href="../dashboard.php">🏠 HOME</a>
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
                    text: "Data pembayaran akan dihapus secara permanen.",
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