<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['id_barang'])) {
    $id_barang=$_GET['id_barang'];
}
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM barang WHERE id_barang='$id_barang'");
 
// After delete redirect to Home, so that latest user list will be displayed.
header("Location:baranglihat.php");
?>