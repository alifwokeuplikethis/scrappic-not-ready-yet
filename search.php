
<?php
// Include file koneksi.php untuk melakukan koneksi ke database
include "koneksi.php";

// Ambil nilai dari input pencarian
$search = $_POST['query'];

// Query pencarian berdasarkan judul atau nama pengguna
$query = "SELECT * FROM images WHERE judul LIKE '%$search%' OR user LIKE '%$search%'";
$result = mysqli_query($koneksi, $query);

// Tampilkan hasil pencarian dalam bentuk HTML
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Tampilkan gambar dan informasi lainnya sesuai format yang diinginkan
        // Anda dapat menyesuaikan kode ini dengan tampilan tile yang ada di halaman web Anda
        echo "<div class='tile' data-id='{$row["id"]}'>";
        echo "<img src='img/donwload-logo.png' class='donlod' style='width: 40px;' title='ini download' onclick='downloadImage({$row["id"]})'><h2 style='position:absolute;top:10px;left:50px;'>{$row["user"]}</h2>";
        echo "<img src='data:image/jpeg;base64," . base64_encode($row["image_data"]) . "' class='gambar'>";
        echo "<div class='overlay'></div>";
        echo "<h3>{$row["judul"]}</h3>";
        echo "<form method='POST'>";
        echo "<input type='hidden' name='image_id' value='{$row["id"]}'>";
        echo "<input type='submit' value='&#9906; Save' style='all:unset;cursor:pointer;' name='action'>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "No results found";
}

// Tutup koneksi database
mysqli_close($koneksi);
?>
