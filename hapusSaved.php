<?php
include "koneksi.php";
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM savedimages WHERE id = '$id'";
    mysqli_query($koneksi, $query);
}
?>