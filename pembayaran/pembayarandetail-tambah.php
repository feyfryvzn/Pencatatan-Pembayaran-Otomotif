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
    $row_total = mysqli_fetch_assoc($result_total);
    $total_sebelumnya = $row_total['jumlahRp'] ?? 0;

    // Insert ke detail_pembayaran
    $query_insert = "INSERT INTO detail_pembayaran (no_pembayaran, id_barang, banyaknya, jumlah_harga) 
                     VALUES ('$no_pembayaran', '$id_barang', '$banyaknya', '$jumlah_harga')";
    $result_insert = mysqli_query($conn, $query_insert);

    if ($result_insert) {
        // Update total di tabel pembayaran
        $total = $total_sebelumnya + $jumlah_harga;
        $query_update_total = "UPDATE pembayaran SET jumlahRp = '$total' WHERE no_pembayaran = '$no_pembayaran'";
        mysqli_query($conn, $query_update_total);

        $_SESSION['success'] = "Data detail pembayaran berhasil ditambahkan.";
        header("Location: nota-lihat.php?no_pembayaran=" . urlencode($no_pembayaran));
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Ambil data pembayaran berdasarkan no_pembayaran dari URL
if (isset($_GET['no_pembayaran'])) {
    $no_pembayaran = mysqli_real_escape_string($conn, $_GET['no_pembayaran']);
    $query = mysqli_query($conn, "SELECT * FROM pembayaran WHERE no_pembayaran = '$no_pembayaran'");
    $data = mysqli_fetch_array($query);
    if (!$data) {
        die("Data pembayaran tidak ditemukan.");
    }
} else {
    die("No Pembayaran tidak disediakan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🛠 Tambah Detail Pembayaran - Auto Otomotif ⚙️</title>
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
    </style>
</head>
<body>
    <div class="container">
        <h3>🛠 Tambah Detail Pembayaran</h3>
        <form action="" method="post">
            <label for="no_pembayaran">No Pembayaran</label>
            <input type="text" name="no_pembayaran" value="<?php echo htmlspecialchars($data['no_pembayaran']); ?>" readonly>

            <label for="id_barang">Barang</label>
<select name="id_barang" required>
    <option value="">--Pilih Barang--</option>
    <?php
        $result = mysqli_query($conn, "SELECT id_barang, nama_barang, harga FROM barang");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . htmlspecialchars($row['id_barang']) . "' data-harga='" . htmlspecialchars($row['harga']) . "'>" . htmlspecialchars($row['nama_barang']) . "</option>";
        }
    ?>
</select>


            <label for="banyaknya">Banyaknya</label>
            <input type="text" name="banyaknya" min="1" required>

            <label for="jumlah_harga">Jumlah Harga</label>
            <input type="number" name="jumlah_harga" readonly>

            <div class="btn-container">
                <a class="btn btn-home" href="pembayarandetail-lihat.php?no_pembayaran=<?php echo urlencode($data['no_pembayaran']); ?>">Kembali</a>
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
            var banyaknya = parseInt(inputBanyaknya.value) || 0;
            var jumlah = hargaSatuan * banyaknya;
            inputJumlahHarga.value = jumlah;
        }

        // Panggil fungsi hitungJumlah saat nilai input berubah
        selectBarang.addEventListener("change", hitungJumlah);
        inputBanyaknya.addEventListener("input", hitungJumlah);
    </script>
</body>
</html>
<?php
// Proses form (sudah ditempatkan di atas untuk keamanan)
?>