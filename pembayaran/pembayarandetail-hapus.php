<?php
session_start();
include '../koneksi.php';

// Get id from URL to delete that user
if (isset($_GET['no_pembayaran']) && isset($_GET['id_barang'])) {
    $no_pembayaran = mysqli_real_escape_string($conn, $_GET['no_pembayaran']);
    $id_barang = mysqli_real_escape_string($conn, $_GET['id_barang']);
    
    // Check if the record exists before deletion
    $check_query = mysqli_query($conn, "SELECT * FROM detail_pembayaran WHERE no_pembayaran = '$no_pembayaran' AND id_barang = '$id_barang'");
    if (mysqli_num_rows($check_query) > 0) {
        // Delete user row from table based on given id with LIMIT 1
        $result = mysqli_query($conn, "DELETE FROM detail_pembayaran WHERE no_pembayaran = '$no_pembayaran' AND id_barang = '$id_barang' LIMIT 1");

        if ($result) {
            // Calculate new total price after deletion using jumlah_harga
            $query = "SELECT SUM(jumlah_harga) AS total FROM detail_pembayaran WHERE no_pembayaran = '$no_pembayaran'";
            $totalResult = mysqli_query($conn, $query);
            
            if ($totalResult) {
                $row = mysqli_fetch_assoc($totalResult);
                $jumlahRp = $row['total'] ?? 0;

                // Update total price in pembayaran table
                $updateResult = mysqli_query($conn, "UPDATE pembayaran SET jumlahRp = '$jumlahRp' WHERE no_pembayaran = '$no_pembayaran'");

                if ($updateResult) {
                    $_SESSION['success'] = "Data detail pembayaran berhasil dihapus.";
                    header("Location: pembayarandetail-lihat.php?no_pembayaran=" . urlencode($no_pembayaran));
                    exit();
                } else {
                    $_SESSION['error'] = "Error updating total price: " . mysqli_error($conn);
                }
            } else {
                $_SESSION['error'] = "Error calculating new total: " . mysqli_error($conn);
            }
        } else {
            $_SESSION['error'] = "Error deleting item: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error'] = "Data tidak ditemukan.";
    }
} else {
    $_SESSION['error'] = "Invalid parameters.";
}

// Redirect to the same page or error page with session message
header("Location: pembayarandetail-lihat.php?no_pembayaran=" . urlencode($no_pembayaran));
exit();
?>

<?php
// Optional: Display error or success on the redirect page (handled in notadetail-lihat.php)
?>