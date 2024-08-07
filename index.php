<?php
include "koneksi.php";
$search = isset($_GET['search']) ? $_GET['search'] : '';

session_start();
if (!empty($search)) {
  $kueri = mysqli_query($koneksi, "SELECT * FROM images WHERE judul LIKE '%$search%'");
} else {
  // Jika tidak ada kata kunci pencarian, gunakan kueri awal
  $kueri = mysqli_query($koneksi, "SELECT * FROM images");
}
$images = [];
while ($row = mysqli_fetch_assoc($kueri)) {
    $images[] = $row;
}
if(isset($_SESSION["nama_pengguna"])){
$namaPengguna = $_SESSION["nama_pengguna"];
$kueriProfile = mysqli_query($koneksi, "SELECT * FROM login where user='$namaPengguna'");
}

// Mengacak urutan array
shuffle($images);
?>
<!DOCTYPE html>
<html>
<head>
  <title>scrappic</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery-1.7.js" type="text/javascript"></script>
  <script src="js/pinto.js" type="text/javascript"></script>  
</head>
<style>
    
  </style>
<body> 
  <div class="headers"><form method="GET" class="search-container">
      <img src="img/sc.jpg" class="logo" alt="scrappic logo" style="width:25px;">
    <input type="text" placeholder="Cari sesuatu dengan judul" id="searchInput" class="inputSearch" style="flex: 1; padding: 10px; border: 1px solid black; border-radius: 5px; font-size: 16px; margin-right: 10px; color: black;width:800px;" name="search">
    <input type="submit" value="&#x1F50D; Search" style="padding: 10px; border: none; border-radius: 5px; background-color: #4CAF50; color: white; cursor: pointer;width:100px; line-height: 1; vertical-align: middle;" name="cari">
    <button style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; text-align: center; text-decoration: none; font-size: 16px; margin-top: 10px;" onclick="window.location.href='index.php'">Refresh halaman</button>

</div>    <div class="icons" style="position:absolute;right:0;">
    <?php 
    if(isset($_SESSION["nama_pengguna"])){
    $rrow = mysqli_fetch_array($kueriProfile);
    $fotoProfile = $rrow["profile"];
    if(!empty($fotoProfile)){
?>  
    <img src="data:image/jpeg;base64,<?= base64_encode($fotoProfile) ?>" alt="Profile" style="width:50px;height:40px;">
<?php }else{
 ?>  <img src="img/profile.png" alt="Profile" style="all: unset;width:50px;"><span class="profile-name">
  <?php
}
} else{
?>
    <img src="img/profile.png" alt="Profile" style="all: unset;width:50px;"><span class="profile-name">
<?php 
    }
?></form>


        <?php
        if(isset($_SESSION["udahLogin"]) == true){
          $namaPengguna = $_SESSION["nama_pengguna"];
          echo "<a>".$namaPengguna."</a>";
          if(isset($_POST["action"])){
            $image_saved_id = $_POST["image_id"];
            $kuweriSimpen = mysqli_query($koneksi, "SELECT * FROM images WHERE id='$image_saved_id'");
            while($rowah = mysqli_fetch_assoc($kuweriSimpen)){
              $isiGambar = mysqli_real_escape_string($koneksi, $rowah["image_data"]);
              $namaPengguna = mysqli_real_escape_string($koneksi, $namaPengguna);
              $isiUser = mysqli_real_escape_string($koneksi, $rowah["user"]);
              $isiJudul = mysqli_real_escape_string($koneksi, $rowah["judul"]);
              if(mysqli_query($koneksi, "INSERT INTO savedimages(id,user,saved_user,gambar,judul) VALUES('$image_saved_id','$isiUser','$namaPengguna','$isiGambar','$isiJudul')")) {
                echo "<script>alert('Data berhasil disimpan')</script>";
            } else {
                echo "Error: " . mysqli_error($koneksi);
            }
            }
          }
        }else{
          echo "<a href='login.php'>Login</a>";
        }
        ?>
      </span>
      <div class="navbar">
        <div class="nav_right">
          <ul>
            <li class="nr_li dd_main" id="settingg">
              <img src="img/barger.png" class="seting" id="settingImage">
              <div class="dd_menu">
                <div class="dd_right">
                  <ul>
                    <?php if(isset($_SESSION["udahLogin"]) == true) {
                      echo "<li><a href='profile.php'>Profil anda</a></li>
                      <li><a href='tambah.php'>Tambah foto</a></li>
                      <li><a href='logout.php'>Logout</a></li>";
                    }else{
                      echo "<a href='login.php'>Login</a>";
                    }
                    ?>
                  </ul>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="tile-container">
    <?php 
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    foreach($images as $row){
      $id = $row["id"];
      $user = $row["user"];
      $kuweriBaru = mysqli_query($koneksi, "SELECT profile FROM login WHERE user='$user'");
      ?>
      <div class="tile"  data-id="<?=$id?>">
        <?php
        if (mysqli_num_rows($kuweriBaru) > 0) {
          $rawr = mysqli_fetch_assoc($kuweriBaru);
          if (!empty($rawr['profile'])) {
              ?> <img src="data:image/jpeg;base64,<?=base64_encode($rawr["profile"])?>" style="all: unset;width:40px;border-radius:10px;">
              <?php
          } else {
              ?> <img src="img/profile.png" alt="Profile" style="all: unset;width:30px;">
                
              <?php
          }
      } else {
          ?> <img src="img/profile.png" alt="Profile" style="all: unset;width:30px;">
          <?php
      }
        ?><h2 style="cursor:pointer;" onclick="onAnotherPage('<?php echo htmlspecialchars($user);?>')"><?=$user?></h2><img src="img/donwload-logo.png" class="donlod" style="width: 40px;float:right;position:absolute;top:0px;left:200px;background-color:white;" title="ini download" onclick="downloadImage('<?=$id?>')">
        <img src="data:image/jpeg;base64,<?=base64_encode($row["image_data"])?>" class="gambar">
        <div class="overlay"></div>
        <h3><?php echo $row["judul"];?></h3>
        <form method="POST">
          <input type="hidden" name="image_id" value="<?=$id?>"> 
          <input type="submit" value="&#9906; Save" style="all:unset;cursor:pointer;" name="action">
        </form>
      </div>
      <?php 
    }
    ?>
  </div>
  <script type="text/javascript">
    window.onload = function() {
      $('.tile-container').pinto();
      var dd_main = document.querySelector(".dd_main");
      dd_main.addEventListener("click", function(){
        this.classList.toggle("active");
      })
    } 

    function onAnotherPage(user){
    window.location.href = "profileOrang.php?user=" + user;
    }

    var dotsImage = document.getElementById("settingImage");
    var rotated = false;
    document.getElementById("settingg").addEventListener("click", function() {
      if(!rotated){
        dotsImage.style.transform = "rotate(90deg)";
        dotsImage.style.transition = "transform 0.5s ease";
        rotated = true;
      }else{
        dotsImage.style.transform = "rotate(0deg)";
        rotated = false;
      }
    });

    function downloadImage(imageId) {
  var imageData = document.querySelector('.tile[data-id="' + imageId + '"] .gambar').getAttribute('src').split(',')[1];
  var blob = b64toBlob(imageData, 'image/jpeg');
  var url = URL.createObjectURL(blob);
  var a = document.createElement('a');
  a.href = url;
  a.download = 'image.jpg';
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
  URL.revokeObjectURL(url);
}

function b64toBlob(b64Data, contentType) {
  contentType = contentType || '';
  var sliceSize = 512;
  var byteCharacters = atob(b64Data);
  var byteArrays = [];
  for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
    var slice = byteCharacters.slice(offset, offset + sliceSize);
    var byteNumbers = new Array(slice.length);
    for (var i = 0; i < slice.length; i++) {
      byteNumbers[i] = slice.charCodeAt(i);
    }
    var byteArray = new Uint8Array(byteNumbers);
    byteArrays.push(byteArray);
  }
  var blob = new Blob(byteArrays, {type: contentType});
  return blob;
}
  </script>
</body>
</html>


