<?php
session_start();
unset($_SESSION["udahLogin"]);
unset($_SESSION["nama_pengguna"]);
echo "<script>alert('Berhasil logout!'); window.location.href='index.php';</script>";
?>