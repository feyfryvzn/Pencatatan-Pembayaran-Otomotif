<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['nopol'])) {
    $nopol=$_GET['nopol'];
}
 
// Delete user row from table based on given id
    $result = mysqli_query($conn, "DELETE FROM mobil WHERE nopol='$nopol'");
 
// After delete redirect to Home, so that latest user list will be displayed.
header("Location:mobillihat.php");
?>