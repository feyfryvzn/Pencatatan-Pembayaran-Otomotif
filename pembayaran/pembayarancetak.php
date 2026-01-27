<?php
// Pastikan koneksi database sudah ada
include '../koneksi.php';

// Validasi parameter
if (!isset($_GET['no_pembayaran']) || empty($_GET['no_pembayaran'])) {
    die("No pembayaran tidak ditemukan");
}

$no_pembayaran = mysqli_real_escape_string($conn, $_GET['no_pembayaran']);

// Query untuk data header (pembayaran, mobil, dan pelanggan)
$query_header = mysqli_query($conn, "SELECT p.no_pembayaran, p.nopol, p.tanggal, p.jumlahRp, 
                                           pl.nama_pelanggan, pl.no_telepon, m.nama_mobil, pg.nama_pegawai 
                                    FROM pembayaran p 
                                    LEFT JOIN mobil m ON p.nopol = m.nopol 
                                    LEFT JOIN pelanggan pl ON m.id_pelanggan = pl.id_pelanggan 
                                    LEFT JOIN pegawai pg ON p.id_pegawai = pg.id_pegawai 
                                    WHERE p.no_pembayaran = '$no_pembayaran'");

if (!$query_header) {
    die("Error dalam query header: " . mysqli_error($conn));
}

$data = mysqli_fetch_array($query_header);
if (!$data) {
    die("Data pembayaran tidak ditemukan");
}

// Format tanggal
$tanggal = date('d/m/Y', strtotime($data['tanggal']));
$nama_pegawai = $data['nama_pegawai'];
$jumlahRp = $data['jumlahRp'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Pembayaran - <?php echo $data['no_pembayaran']; ?></title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f9f9f9; /* Abu-abu lembut untuk latar belakang */
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 30px auto;
            padding: 25px;
            background-color: #ffffff;
            border: 2px solid #e0e0e0; /* Border abu-abu lembut */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .header {
            text-align: center;
            padding: 15px;
            background-color: rgb(255, 255, 255); 
            border-bottom: 3px solid #ff6f91; 
            border-radius: 10px 10px 0 0;
            color: rgb(0, 0, 0); /* Teks putih untuk kontras */
        }
        .header img {
            max-width: 320px;
            height: auto;
            margin-bottom: 10px;
        }
        .header p {
            font-size: 0.95rem;
            color: rgb(0, 0, 0); /* Teks putih */
            margin: 5px 0;
            line-height: 1.4;
        }
        .header strong {
            color: #ff6f91; /* Merah muda untuk teks penting */
            font-weight: 600;
        }
        .details {
            display: flex;
            justify-content: space-between;
            padding: 20px 0;
            border-bottom: 1px dashed #ff6f91; /* Merah muda untuk garis putus-putus */
        }
        .details .left, .details .right {
            width: 48%;
        }
        .details .right pre {
            font-size: 0.95rem;
            color: #333; /* Teks lebih gelap untuk legibility */
            white-space: pre-wrap;
            text-align: left;
            line-height: 1.5;
        }
        .details .right hr {
            margin: 15px 0;
            border: 0;
            height: 1px;
            background: #ff6f91; /* Merah muda untuk garis pemisah */
        }
        .medicine-list {
            margin-top: 20px;
        }
        .medicine-list table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .medicine-list th {
            background-color: #003087; /* Biru tua solid */
            color: #ffffff;
            padding: 12px;
            text-align: center;
            font-weight: 600;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
        }
        .medicine-list td {
            padding: 12px;
            border: 1px solid #e0e0e0; /* Border abu-abu lembut */
            text-align: center;
            vertical-align: middle;
        }
        .medicine-list tr:nth-child(even) {
            background-color: #f5f5f5; /* Latar abu-abu sangat lembut */
        }
        .total-amount {
            font-size: 1.3rem;
            font-weight: 700;
            color: #ff6f91; /* Merah muda untuk total */
            margin-top: 20px;
            text-align: right;
            padding-right: 10px;
        }
        .notice {
            margin-top: 10px;
            font-size: 0.9rem;
            color: #333;
            text-align: left;
            padding-left: 10px;
        }
        .signature {
            display: flex;
            justify-content: flex-end;
            padding: 25px 0 10px;
            position: relative;
            border-top: 1px dashed #ff6f91; /* Merah muda untuk garis atas */
        }
        .signature pre {
            margin: 0;
            text-align: center;
            font-size: 0.95rem;
            color: #333;
        }
        .signature img {
            width: 110px;
            height: auto;
            margin: 10px 0;
        }
        .no-print {
            display: block;
        }
        @media print {
            .no-print {
                display: none;
            }
            .container {
                margin: 0;
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="../images/tulisan.jpg" alt="Logo" style="width: 320px; height: auto;">
            <p>
                <strong>SAKURA KOREA PARTS</strong><br>
                Spesialis Auto Sparepart & Genuine Accessories For Korean Car<br>
                Pasar Mobil Kemayoran, Tahap III Blok.A No. 55-58<br>
                HP. 085218580300
            </p>
        </div>

        <div class="details">
            <div class="left"></div>
            <div class="right">
                <pre>
Jakarta, <?php echo $tanggal; ?>

Kepada Yth,
<?php echo htmlspecialchars($data['nama_pelanggan']); ?>

Nama Mobil: <?php echo htmlspecialchars($data['nama_mobil']); ?>

No Telepon: <?php echo htmlspecialchars($data['no_telepon']); ?>

No Polisi: <?php echo htmlspecialchars($data['nopol']); ?>
<hr style="height:1px;background-color: #ff6f91;"> 
                </pre>
            </div>
        </div>
        <strong style="font-size: large; color: #ff6f91;">
            No Pembayaran: <?php echo htmlspecialchars($data['no_pembayaran']); ?>
        </strong>
        <div class="medicine-list">
            <table>
                <thead>
                    <tr>
                        <th>Banyaknya</th>
                        <th>Nama Barang</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query untuk detail barang
                    $query_detail = mysqli_query($conn, "SELECT b.nama_barang, b.harga AS harga_satuan, 
                                                              dp.banyaknya, dp.jumlah_harga 
                                                       FROM detail_pembayaran dp
                                                       JOIN barang b ON dp.id_barang = b.id_barang
                                                       WHERE dp.no_pembayaran = '$no_pembayaran'");
                    
                    if (!$query_detail) {
                        die("Error dalam query detail: " . mysqli_error($conn));
                    }
                    
                    $rowCount = 0;
                    while ($data_detail = mysqli_fetch_array($query_detail)) {
                        $banyaknya = $data_detail['banyaknya'];
                        $harga_satuan = floatval($data_detail['harga_satuan']) ?: 0;
                        $jumlah_harga = floatval($data_detail['jumlah_harga']) ?: 0;
                        $rowCount++;
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($banyaknya); ?></td>
                            <td style="text-align: left;"><?php echo htmlspecialchars($data_detail['nama_barang']); ?></td>
                            <td>Rp <?php echo number_format($harga_satuan, 0, ',', '.'); ?></td>
                            <td>Rp <?php echo number_format($jumlah_harga, 0, ',', '.'); ?></td>
                        </tr>
                    <?php }

                    // Tambahkan baris kosong secara dinamis untuk total 10 baris (termasuk tfoot)
                    $totalRows = $rowCount + 1; // +1 untuk baris TOTAL di tfoot
                    $emptyRows = max(0, 7 - $totalRows); // Hitung baris kosong agar total 10 baris
                    for ($i = 0; $i < $emptyRows; $i++) {
                        echo "<tr><td> </td><td> </td><td> </td><td> </td></tr>";
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr style="background-color: #f8f9fa; font-weight: bold;">
                        <td colspan="3" style="text-align: right;"><strong>TOTAL</strong></td>
                        <td><strong>Rp <?php echo number_format($jumlahRp, 0, ',', '.'); ?></strong></td>
                    </tr>
                </tfoot>
            </table>
            <div class="notice">
                <strong>Catatan:</strong> Barang yang sudah dibeli tidak dapat dikembalikan/diretur
            </div>
        </div>

        <div class="signature">
            <div>
                <pre>
<strong>Hormat Kami,</strong>
<img src="../images/korea.jpg" alt="Signature" style="width: 110px; height: auto;">
<strong><?php echo htmlspecialchars($nama_pegawai); ?></strong>
                </pre>
            </div>
        </div>
        
        <!-- Tombol untuk tidak dicetak -->
        <div class="no-print" style="text-align: center; margin-top: 20px;">
            <button onclick="window.print()" class="btn btn-primary" style="background: #003087; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px;">
                <i class="fa fa-print"></i> Cetak
            </button>
            <button onclick="window.history.back()" class="btn btn-secondary" style="background: #e0e0e0; color: #333; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                <i class="fa fa-arrow-left"></i> Kembali
            </button>
        </div>
    </div>

    <script>
        // Auto print saat halaman dimuat (opsional)
        // window.onload = function() {
        //     window.print();
        // }
        
        // Print function
        function printPage() {
            window.print();
        }
    </script>
</body>
</html>

<?php
// Tutup koneksi database
mysqli_close($conn);
?>