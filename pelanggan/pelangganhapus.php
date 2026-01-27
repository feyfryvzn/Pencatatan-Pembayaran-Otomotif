<?php
// Include database connection file
include '../koneksi.php';

// Check if id_pelanggan is set in the URL and delete the record
if (isset($_GET['id_pelanggan'])) {
    $id_pelanggan = $_GET['id_pelanggan'];
    mysqli_query($conn, "DELETE FROM pelanggan WHERE id_pelanggan='$id_pelanggan'");
}

// Redirect back to pelanggan list after deletion
header("Location:pelangganlihat.php");
exit();
?>
