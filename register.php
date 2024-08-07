<?php
include "koneksi.php";

if(isset($_POST["submit"])){
    $user = $_POST["user"];
    $pass = $_POST["password"];
    $passHashed = password_hash($pass, PASSWORD_DEFAULT);
    $kuweri = mysqli_query($koneksi, "SELECT * FROM login where user='$user'");
    if(mysqli_num_rows($kuweri) == 0){
        $kueriTambah = mysqli_query($koneksi, "INSERT INTO login(user,password) values('$user','$passHashed')");
        header("Location: login.php");
        exit;
    }else{
        echo "<script>alert('Username sudah ada!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: linear-gradient(90deg, #fcff35 0%, #ff4be7 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .kotak {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 400px;
            max-width: 90%;
            text-align: center;
        }

        .kotak h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .kotak label {
            display: block;
            text-align: left;
            margin-bottom: 6px;
            color: #555;
        }

        .kotak input[type="text"],
        .kotak input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .kotak input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .kotak input[type="submit"]:hover {
            background-color: #45a049;
        }

        .kotak a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }

        .kotak a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="kotak">
        <form action="" method="POST">
            <h2>Register</h2>
            <br/>          
            <label for="email">Username:</label>
            <input type="text" name="user" placeholder="Username" class="form" required>
            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Password" class="form" required>
            <input type="submit" value="Submit" name="submit" onclick="alert('Akun telah ditambah!')">      
        </form>
        <a href="login.php">Kembali ke form login</a>
    </div>

</body>
</html>
