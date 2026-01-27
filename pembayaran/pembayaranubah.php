<?php
include '../koneksi.php';
$no_pembayaran = $_GET['no_pembayaran'];
$query = mysqli_query($conn, "SELECT * FROM pembayaran WHERE no_pembayaran = '$no_pembayaran'");
$data = mysqli_fetch_array($query);
?>

<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #fde2e4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
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

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #ff80ab;
        }

        input[type="text"], input[type="date"], input[type="number"], select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #b0bec5;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .buttons {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            color: #ffffff;
            text-decoration: none;
            cursor: pointer;
            margin: 5px;
        }

        .btn-save {
            background: #80d8ff;
        }

        .btn-save:hover {
            background: #40c4ff;
        }

        .btn-back {
            background: #ff80ab;
        }

        .btn-back:hover {
            background: #ff4081;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Ubah Pembayaran</h3>
        <form action="" method="post">
            <div class="form-group">
                <label for="no_pembayaran">No Pembayaran</label>
                <input type="number" name="no_pembayaran" value="<?php echo $data['no_pembayaran']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="nopol">No Polisi</label>
                <select name="nopol" required>
                    <?php
                        $result = mysqli_query($conn, "SELECT nopol FROM mobil");
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selected = ($row['nopol'] == $data['nopol']) ? "selected" : "";
                            echo "<option value='" . $row['nopol'] . "' $selected>" . $row['nopol'] . "</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_pegawai">Pegawai</label>
                <select name="id_pegawai" required>
                    <?php
                        $result = mysqli_query($conn, "SELECT nama_pegawai FROM pegawai");
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selected = ($row['id_pegawai'] == $data['id_pegawai']) ? "selected" : "";
                            echo "<option value='" . $row['id_pegawai'] . "' $selected>" . $row['nama_pegawai'] . "</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" name="tanggal" value="<?php echo $data['tanggal']; ?>" required>
            </div>
            <div class="form-group">
                <label for="jumlahRp">Jumlah Rp</label>
                <input type="number" name="jumlahRp" value="<?php echo $data['jumlahRp']; ?>" required>
            </div>
            <div class="buttons">
                <a class="btn btn-back" href="pembayaranlihat.php">Kembali</a>
                <button type="submit" name="proses" class="btn btn-save">Ubah Pembayaran</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
if (isset($_POST['proses'])){
    $no_pembayaran = $_POST['no_pembayaran'];
    $nopol = $_POST['nopol'];
    $id_pegawai = $_POST['id_pegawai'];
    $tanggal = $_POST['tanggal'];
    $jumlahRp = $_POST['jumlahRp'];

    mysqli_query($conn, "UPDATE pembayaran SET nopol='$nopol', id_pegawai='$id_pegawai', tanggal='$tanggal', jumlahRp='$jumlahRp' WHERE no_pembayaran='$no_pembayaran'");
    header("location:pembayaranlihat.php");
}
?>
