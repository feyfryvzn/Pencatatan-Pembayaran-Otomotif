<?php
session_start();
include '../koneksi.php';

// Proses form sebelum ada output HTML
if (isset($_POST['proses'])) {
    $no_pembayaran = mysqli_real_escape_string($conn, $_POST['no_pembayaran']);
    $nopol = mysqli_real_escape_string($conn, $_POST['nopol']);
    $id_pegawai = mysqli_real_escape_string($conn, $_POST['id_pegawai']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $jumlahRp = mysqli_real_escape_string($conn, $_POST['jumlahRp']);

    // Query INSERT dengan kolom eksplisit
    $query_insert = "INSERT INTO pembayaran (no_pembayaran, nopol, id_pegawai, tanggal, jumlahRp) 
                     VALUES ('$no_pembayaran', '$nopol', '$id_pegawai', '$tanggal', '$jumlahRp')";
    $result = mysqli_query($conn, $query_insert);

    if ($result) {
        $_SESSION['success'] = "Data pembayaran berhasil ditambahkan.";
        header("Location: pembayaranlihat.php");
        exit();
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($conn);
        header("Location: pembayaran-tambah.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🛠 Tambah Pembayaran - Auto Otomotif ⚙️</title>
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
            background:rgb(235, 154, 182); /* Pink pastel */
        }
        .btn-simpan {
            background:rgb(145, 218, 247); /* Hijau pastel lembut */
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
        <h3>🛠 Tambah Pembayaran ⚙️</h3>
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
            <input type="number" name="no_pembayaran" required>

            <label for="nopol">No Polisi</label>
            <select name="nopol" required>
                <option value="">--Pilih Plat--</option>
                <?php
                    $result = mysqli_query($conn, "SELECT nopol FROM mobil");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . htmlspecialchars($row['nopol']) . "'>" . htmlspecialchars($row['nopol']) . "</option>";
                    }
                ?>
            </select>

            <label for="id_pegawai">Pegawai</label>
            <select name="id_pegawai" required>
                <option value="">--Pilih Pegawai--</option>
                <?php
                    $result = mysqli_query($conn, "SELECT id_pegawai, nama_pegawai FROM pegawai");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . htmlspecialchars($row['id_pegawai']) . "'>" . htmlspecialchars($row['nama_pegawai']) . "</option>";
                    }
                ?>
            </select>

            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal"  required>

            <label for="jumlahRp">Jumlah Rp</label>
            <input type="number" name="jumlahRp" required>

            <div class="btn-container">
                <a class="btn btn-home" href="pembayaranlihat.php">Kembali</a>
                <button type="submit" name="proses" class="btn btn-simpan">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>
<?php
// Proses form (sudah ditempatkan di atas untuk keamanan)
?>