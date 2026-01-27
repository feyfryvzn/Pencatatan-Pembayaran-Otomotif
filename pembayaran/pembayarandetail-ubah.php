<?php
session_start();
include '../koneksi.php';

// Proses form sebelum ada output HTML
if (isset($_POST['proses'])) {
    $no_pembayaran = mysqli_real_escape_string($conn, $_POST['no_pembayaran']);
    $id_barang = mysqli_real_escape_string($conn, $_POST['id_barang']);
    $banyaknya = mysqli_real_escape_string($conn, $_POST['banyaknya']);
    $jumlah_harga = mysqli_real_escape_string($conn, $_POST['jumlah_harga']);

    // Ambil total sebelumnya dari tabel pembayaran
    $query_total = "SELECT jumlahRp FROM pembayaran WHERE no_pembayaran = '$no_pembayaran'";
    $result_total = mysqli_query($conn, $query_total);
    if ($result_total) {
        $row_total = mysqli_fetch_assoc($result_total);
        $total_sebelumnya = $row_total['jumlahRp'] ?? 0;

        // Ambil jumlah_harga sebelumnya untuk pengurangan
        $query_old = "SELECT jumlah_harga FROM detail_pembayaran WHERE no_pembayaran = '$no_pembayaran' AND id_barang = '$id_barang'";
        $result_old = mysqli_query($conn, $query_old);
        $old_jumlah_harga = mysqli_fetch_assoc($result_old)['jumlah_harga'] ?? 0;

        // Update detail_pembayaran
        $queryUpdate = "UPDATE detail_pembayaran SET banyaknya = '$banyaknya', jumlah_harga = '$jumlah_harga' 
                        WHERE no_pembayaran = '$no_pembayaran' AND id_barang = '$id_barang' LIMIT 1";
        $result_update = mysqli_query($conn, $queryUpdate);

        if ($result_update) {
            // Mengupdate nilai total (kurangi lama, tambah baru)
            $total = $total_sebelumnya - $old_jumlah_harga + $jumlah_harga;
            $query_update_total = "UPDATE pembayaran SET jumlahRp = '$total' WHERE no_pembayaran = '$no_pembayaran'";
            $result_update_total = mysqli_query($conn, $query_update_total);

            if ($result_update_total) {
                $_SESSION['success'] = "Data detail pembayaran berhasil diubah.";
                header("Location: pembayarandetail-lihat.php?no_pembayaran=" . urlencode($no_pembayaran));
                exit();
            } else {
                $_SESSION['error'] = "Error updating total: " . mysqli_error($conn);
            }
        } else {
            $_SESSION['error'] = "Error updating data: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error'] = "Error fetching total: " . mysqli_error($conn);
    }
    // Redirect back with error if any
    header("Location: pembayaran_detail-ubah.php?no_pembayaran=" . urlencode($no_pembayaran) . "&id_barang=" . urlencode($id_barang));
    exit();
}

// Ambil data untuk tampilan form
if (isset($_GET['no_pembayaran']) && isset($_GET['id_barang'])) {
    $no_pembayaran = mysqli_real_escape_string($conn, $_GET['no_pembayaran']);
    $id_barang = mysqli_real_escape_string($conn, $_GET['id_barang']);

    $query_pembayaran = mysqli_query($conn, "SELECT * FROM pembayaran WHERE no_pembayaran = '$no_pembayaran'");
    if ($query_pembayaran) {
        $data_pembayaran = mysqli_fetch_array($query_pembayaran);
    } else {
        die("Error: " . mysqli_error($conn));
    }

    $query_detail = mysqli_query($conn, "SELECT dp.id_barang, b.nama_barang, dp.banyaknya, dp.jumlah_harga, b.harga 
                                        FROM detail_pembayaran dp 
                                        JOIN barang b ON dp.id_barang = b.id_barang 
                                        WHERE dp.no_pembayaran = '$no_pembayaran' AND dp.id_barang = '$id_barang'");
    if ($query_detail) {
        $data = mysqli_fetch_array($query_detail);
        if (!$data) {
            die("Data detail pembayaran tidak ditemukan.");
        }
    } else {
        die("Error: " . mysqli_error($conn));
    }
} else {
    die("No Pembayaran atau ID Barang tidak disediakan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🛠 Ubah Detail Pembayaran - Auto Otomotif ⚙️</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: #fde2e4; /* Background pastel merah muda */
            padding: 40px 20px;
        }
        .container {
            max-width: 500px;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin: 50px auto;
        }
        h3 {
            color: #f8bbd0; /* Pink pastel lembut */
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            font-weight: bold;
            color: #f06292; /* Pink lebih tua untuk kontras */
        }
        input, select {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #b0bec5;
            border-radius: 8px;
            font-size: 1rem;
        }
        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: background 0.2s, transform 0.2s;
        }
        .btn-home {
            background: #f8bbd0; /* Pink pastel */
        }
        .btn-simpan {
            background: #a5d6a7; /* Hijau pastel lembut */
        }
        .btn:hover {
            transform: translateY(-3px);
            opacity: 0.9;
        }
        .alert {
            margin-top: 10px;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
        }
        .alert-success {
            background: #a5d6a7;
            color: white;
        }
        .alert-error {
            background: #f8bbd0;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>🛠 Ubah Detail Pembayaran</h3>
        <?php
        if (isset($_SESSION['success'])) {
            echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-error">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        ?>
        <form action="" method="post">
            <label for="no_pembayaran">No Pembayaran</label>
            <input type="text" name="no_pembayaran" value="<?php echo htmlspecialchars($data_pembayaran['no_pembayaran']); ?>" readonly>

            <label for="id_barang">Barang</label>
            <select name="id_barang" required>
                <option value="">--Pilih Barang--</option>
                <?php
                    $result = mysqli_query($conn, "SELECT id_barang, nama_barang, harga FROM barang");
                    while ($row = mysqli_fetch_assoc($result)) {
                        $selected = ($row['id_barang'] == $data['id_barang']) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($row['id_barang']) . "' data-harga='" . htmlspecialchars($row['harga']) . "' $selected>" . htmlspecialchars($row['nama_barang']) . "</option>";
                    }
                ?>
            </select>

            <label for="banyaknya">Banyaknya</label>
            <input type="text" name="banyaknya" value="<?php echo htmlspecialchars($data['banyaknya']); ?>" min="1" required>

            <label for="jumlah_harga">Jumlah Harga</label>
            <input type="number" name="jumlah_harga" value="<?php echo htmlspecialchars($data['jumlah_harga']); ?>" readonly>

            <div class="btn-container">
                <a class="btn btn-home" href="pembayarandetail-lihat.php?no_pembayaran=<?php echo urlencode($data_pembayaran['no_pembayaran']); ?>">Kembali</a>
                <button type="submit" name="proses" class="btn btn-simpan">Simpan</button>
            </div>
        </form>
    </div>

    <script>
        // Ambil elemen-elemen yang diperlukan
        var selectBarang = document.querySelector("select[name='id_barang']");
        var inputBanyaknya = document.querySelector("input[name='banyaknya']");
        var inputJumlahHarga = document.querySelector("input[name='jumlah_harga']");

        // Fungsi untuk menghitung total
        function hitungJumlah() {
            var hargaSatuan = parseInt(selectBarang.options[selectBarang.selectedIndex].getAttribute("data-harga")) || 0;
            var banyaknya = parseInt(inputBanyaknya.value) || <?php echo $data['banyaknya']; ?>") || 0;
            var jumlah = hargaSatuan * banyaknya;
            inputJumlahHarga.value = jumlah || <?php echo $data['jumlah_harga']; ?>; // Jaga nilai awal jika kosong
        }

        // Panggil fungsi hitungJumlah saat nilai input berubah
        selectBarang.addEventListener("change", hitungJumlah);
        inputBanyaknya.addEventListener("input", hitungJumlah);

        // Set initial calculation when page loads
        window.addEventListener("load", hitungJumlah);
    </script>
</body>
</html>
<?php
// Proses form (sudah ditempatkan di atas untuk keamanan)
?>