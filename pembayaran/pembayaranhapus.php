<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['no_pembayaran'])) {
    $no_pembayaran=$_GET['no_pembayaran'];
}
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM pembayaran WHERE no_pembayaran='$no_pembayaran'");
 
// After delete redirect to Home, so that latest user list will be displayed.
header("Location:pembayaranlihat.php");
?>