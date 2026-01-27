<?php
include '../koneksi.php';
$nopol = $_GET['nopol'];
$query = mysqli_query($conn, "SELECT * FROM mobil WHERE nopol = '$nopol'");
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

        input[type="text"], select {
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
        <h3>Ubah Mobil</h3>
        <form action="" method="post">
            <div class="form-group">
                <label for="nopol">No Polisi</label>
                <input type="text" name="nopol" value="<?php echo $data['nopol']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="id_pelanggan">Id Pelanggan</label>
                <select name="id_pelanggan" required>
                    <option value="">--Pilih--</option>
                    <?php
                        $result = mysqli_query($conn, "SELECT id_pelanggan FROM pelanggan");
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selected = ($row['id_pelanggan'] == $data['id_pelanggan']) ? "selected" : "";
                            echo "<option value='" . $row['id_pelanggan'] . "' $selected>" . $row['id_pelanggan'] . "</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="nama_mobil">Nama Mobil</label>
                <input type="text" name="nama_mobil" value="<?php echo $data['nama_mobil']; ?>" required>
            </div>
            <div class="buttons">
                <a class="btn btn-back" href="mobillihat.php">Kembali</a>
                <button type="submit" name="proses" class="btn btn-save">Ubah Mobil</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
if (isset($_POST['proses'])){
    $nopol = $_POST['nopol'];
    $id_pelanggan = $_POST['id_pelanggan'];
    $nama_mobil = $_POST['nama_mobil'];
    mysqli_query($conn, "UPDATE mobil SET id_pelanggan='$id_pelanggan', nama_mobil='$nama_mobil' WHERE nopol='$nopol'");
    header("location:mobillihat.php");
}
?>
