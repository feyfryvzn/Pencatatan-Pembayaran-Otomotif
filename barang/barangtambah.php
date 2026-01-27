<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🛠 Tambah Barang - Auto Otomotif ⚙️</title>
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
        label {
            font-weight: 600;
            color: #ff80ab;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #b0bec5;
            border-radius: 8px;
            font-size: 1rem;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            color: #ffffff;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: background 0.2s;
        }
        .btn-kembali {
            background: #80d8ff;
        }
        .btn-kembali:hover {
            background: #40c4ff;
        }
        .btn-simpan {
            background: #ff80ab;
        }
        .btn-simpan:hover {
            background: #ff4081;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>🛠 Tambah Barang</h3>
        <form action="" method="post">
            <label for="id_barang">ID Barang</label>
            <input type="text" id="id_barang" name="id_barang" required>

            <label for="nama_barang">Nama Barang</label>
            <input type="text" id="nama_barang" name="nama_barang" required>

            <label for="harga">Harga</label>
            <input type="text" id="harga" name="harga" required>

            <div class="button-group">
                <a class="btn btn-kembali" href="baranglihat.php"> Kembali</a>
                <input class="btn btn-simpan" type="submit" name="proses" value="Simpan">
            </div>
        </form>
    </div>
</body>
</html>

<?php
if (isset($_POST['proses'])){
    include '../koneksi.php';
    
    $id_barang = $_POST['id_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    
    mysqli_query($conn, "INSERT INTO barang VALUES('$id_barang','$nama_barang','$harga')");
    header("location:baranglihat.php");
}
?>