<?php
include "koneksi.php";
session_start();



if(isset($_POST["submit"])){
    $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
    if(in_array($_FILES["image"]["type"], $allowed_types)) {
        $img = $_FILES["image"]["tmp_name"];
        $imgData = addslashes(file_get_contents($img));
        $nama = $_SESSION["nama_pengguna"];
        $kueri = mysqli_query($koneksi, "UPDATE login SET profile='$imgData' WHERE user='$nama'");
        if($kueri){
            echo "<script>alert('Gambar berhasil ditambahkan'); window.location.href='profile.php';</script>";
            exit;
        } else {
            $error_message = "Terjadi kesalahan saat menambahkan gambar.";
        }
    } else {
        $error_message = "File yang diunggah bukanlah gambar yang valid.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Gambar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: linear-gradient(90deg, #fcff35 0%, #ff4be7 100%);
            background-attachment: fixed;
        }
        .container {
            margin: 100px auto;
            width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        h2 {
            margin-top: 0;
            text-align: center;
        }
        input[type="file"] {
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Mengganti Gambar Profile</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="image" accept="image/*" required>
            <input type="submit" value="Upload" name="submit" style="margin-top:10px;">
        </form>
        <?php if(isset($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
