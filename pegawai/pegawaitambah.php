<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #fde2e4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
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
            display: block;
            margin-bottom: 8px;
            color: #424242;
            font-weight: 600;
        }

        input[type="number"],
        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #b0bec5;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
        }

        input[type="submit"],
        .kembali {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            text-decoration: none;
            transition: background 0.2s;
        }

        input[type="submit"] {
            background: #80d8ff;
            color: #ffffff;
        }

        input[type="submit"]:hover {
            background: #40c4ff;
        }

        .kembali {
            background: #ff80ab;
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .kembali:hover {
            background: #ff4081;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Tambah Pegawai</h3>
        <form action="" method="post">
            <label for="id_pegawai">Id Pegawai</label>
            <input type="number" id="id_pegawai" name="id_pegawai" required>

            <label for="nama_pegawai">Nama Pegawai</label>
            <input type="text" id="nama_pegawai" name="nama_pegawai" required>

            <div class="button-group">
                <input type="submit" name="proses" value="Simpan">
                <a class="kembali" href="pegawailihat.php">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>

<?php
if (isset($_POST['proses'])){
    include '../koneksi.php';
  
    $id_pegawai = $_POST['id_pegawai'];
    $nama_pegawai = $_POST['nama_pegawai'];
    
    mysqli_query($conn, "INSERT INTO pegawai VALUES('$id_pegawai','$nama_pegawai')");
    header("location:pegawailihat.php");
}
?>
