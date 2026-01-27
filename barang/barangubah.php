<?php
include '../koneksi.php';
$id_barang = $_GET['id_barang'];
$query = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang = '$id_barang'");
$data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🛠 Ubah Barang - Auto Otomotif ⚙️</title>
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

        input[type="text"], input[type="number"] {
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

        .btn-back {
            background: #80d8ff;
        }

        .btn-back:hover {
            background: #40c4ff;
        }

        .btn-save {
            background: #ff80ab;
        }

        .btn-save:hover {
            background: #ff4081;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>🛠 Ubah Barang</h3>
        <form action="" method="post">
            <div class="form-group">
                <label for="id_barang">ID Barang</label>
                <input type="text" name="id_barang" value="<?php echo $data['id_barang']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" name="nama_barang" value="<?php echo $data['nama_barang']; ?>" required>
            </div>
            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" name="harga" value="<?php echo $data['harga']; ?>" required>
            </div>
            <div class="buttons">
                <a class="btn btn-back" href="baranglihat.php">Kembali</a>
                <button type="submit" name="proses" class="btn btn-save">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
if (isset($_POST['proses'])) {
    include '../koneksi.php';
    $id_barang = $_POST['id_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];

    mysqli_query($conn, "UPDATE barang SET nama_barang='$nama_barang', harga='$harga' WHERE id_barang='$id_barang'");
    header("location:baranglihat.php");
}
?>
