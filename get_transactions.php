<?php
$conn = new mysqli("localhost", "root", "", "strukfeyza");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT id_pelanggan, nama_pelanggan, no_telepon FROM pelanggan ORDER BY id_pelanggan ASC";
$result = $conn->query($sql);

$no = 1;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . htmlspecialchars($row['nama_pelanggan']) . "</td>";
        echo "<td>" . htmlspecialchars($row['no_telepon']) . "</td>";

        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>Tidak ada transaksi</td></tr>";
}

$conn->close();
?>