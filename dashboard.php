<?php
session_start();
$conn = new mysqli("localhost", "root", "", "strukfeyza");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk menghitung jumlah pelanggan unik dari tabel transaksi
$query_pelanggan = $conn->query("SELECT COUNT(DISTINCT nama_pelanggan) AS total_pelanggan FROM pelanggan");
$data_pelanggan = $query_pelanggan->fetch_assoc();
$total_pelanggan = $data_pelanggan['total_pelanggan'];

// Ambil halaman yang diminta dari parameter URL (default ke dashboard)
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();

    
}


?>

<!DOCTYPE html>
<html lang="id">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pembayaran</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function loadTransactions() {
            $.ajax({
                url: "get_transactions.php",
                method: "GET",
                success: function(data) {
                    $("#transactions-table").html(data);
                }
            });
        }

        $(document).ready(function() {
            loadTransactions();
            setInterval(loadTransactions, 5000);

        });
    </script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, #ffc0cb, #b3d9ff);
            color: #d81b60;
            min-height: 100vh;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .header-bar {
            background: #ffb6c1;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
            background: linear-gradient(135deg, #ffb6c1, #ffc0cb);
            background-size: 200% 200%;
            animation: shimmer 3s infinite linear;
        }

        .header-bar h1 {
            margin: 0;
            font-size: 24px;
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            background: #ffb6c1;
            color: #d81b60;
            padding: 20px;
            position: fixed;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.2);
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 22px;
            font-weight: bold;
        }

        .menu {
            list-style: none;
            padding-top: 10px;
        }

        .menu a {
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 16px;
            color: #d81b60;
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 8px;
            transition: 0.3s;
            background: linear-gradient(135deg, #ffb6c1, #b3d9ff);
            background-size: 200% 200%;
            animation: shimmer 5s infinite linear;
        }

        .menu a:hover, .menu a.active {
            background: #b3d9ff;
            transform: scale(1.05);
        }

        .main-content {
            margin-left: 260px;
            padding: 20px;
            width: calc(100% - 260px);
            flex-grow: 1;
        }

        .table-container {
            margin-top: 30px;
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        th {
            background: #ffb6c1;
        }

        tr:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .footer {
            text-align: center;
            padding: 10px 0;
            background: #ffb6c1;
            color: white;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                width: 100%;
        }

        
        .logout {
            margin-top: 20px;
            text-align: center;
        }

        .logout a {
            text-decoration: none;
            color: white;
            background: #ff6347;
            padding: 12px 20px;
            border-radius: 30px;
            display: inline-flex;
            align-items: center;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
        }

        .logout a:hover {
            background: #d9534f;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }

        .logout a::before {
            content: "🚪";
            margin-right: 8px;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                box-shadow: none;
            }
        }
        
    }
    </style>
</head>
<body>
    <div class="header-bar">
        <h1>🚗 Dashboard Pembayaran Otomotif</h1>
    </div>

    <div class="sidebar">
        <h2>🚗 Menu</h2>
        <ul class="menu">
        <li><a href="dashboard.php?page=dashboard" class="<?= ($page == 'dashboard') ? 'active' : '' ?>">🏩 Dashboard</a></li>
            <li><a href="pelanggan/pelangganlihat.php">👥 Pelanggan</a></li>
            <li><a href="barang/baranglihat.php">📦 Barang</a></li> 
            <li><a href="pegawai/pegawailihat.php">👨‍💼 Pegawai</a></li> 
            <li><a href="mobil/mobillihat.php">🚘 Mobil</a></li> 
            <li><a href="pembayaran/pembayaranlihat.php">💳 Pembayaran</a></li>
            <a href="dashboard.php?action=logout">🚪 Logout</a>
        </div>
    </div>

     <!-- Main Content -->
     <div class="main-content">
        <div class="header">
            <h2> Dashboard Admin</h2>
        </div>

        <div class="stats">
    <div class="card">
        <h3>👥 <?php echo $total_pelanggan; ?></h3>
        <p>Total Pelanggan</p>
    </div>
</div>
        <div class="table-container">
            <h3>📑 Transaksi Terbaru</h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>No Telepon</th>
                    </tr>
                </thead>
                <tbody id="transactions-table">
                    <!-- Data akan diperbarui secara realtime -->
                </tbody>
            </table>
        </div>
    </div>
   
    <div class="footer">
        <p>© 2025 Dashboard Otomotif. Terima Kasih Manis.</p>
    </div>
</body>
</html>
