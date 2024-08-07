<?php
include "koneksi.php";
session_start();
if(isset($_SESSION["udahLogin"]) && $_SESSION["udahLogin"] == true){

}else{
  header("Location: index.php");
}
$namaUser = $_SESSION["nama_pengguna"];
$kueri = mysqli_query($koneksi, "SELECT * FROM savedimages where saved_user='$namaUser'");
$kuwerih = mysqli_query($koneksi, "SELECT * FROM login where user='$namaUser'");
?>
<!DOCTYPE html>
  <head>
    <title>scrappic</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery-1.7.js" type="text/javascript"></script>
    <script src="js/pinto.js" type="text/javascript"></script>
  </head>
  <style>
    .baten1{
        background-color:#FF5580;
        cursor:pointer;
    }
    .baten2{
        background-image: linear-gradient(90deg, #fcff35 0%, #ff4be7 100%);
        cursor:pointer;
    }
    .baten1:hover, .baten2:hover{
        background-image: linear-gradient(90deg, #fcff35 0%, #ff4be7 100%);
    }
    </style>
  <body>
   <h1 style="text-align:center;"><?php echo $namaUser;?></h1>
   <a href="index.php" style="text-align:right;margin-top:-60px;margin-right:10px;">Kembali ke halaman utama</a>
   <?php while($kueh = mysqli_fetch_assoc($kuwerih)){?>
   <img src="data:image/jpeg;base64,<?=base64_encode($kueh["profile"])?>" style="width:180px;height:180px;border-radius:150px;margin:auto;cursor:pointer;"><center><button style="background-color: #C73659; color: white; padding: 5px 10px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; width: 20%;" onclick="window.location.href='gantiProfile.php'">Ganti foto profil</button>
</center>
<?php } ?>
<div style="display:block;margin:auto;"><br/>
   <button class="baten1" style="border-top:none;border-right:none;border-left:none;" onclick="window.location.href='profile.php'">Foto yang kamu upload</button>
   <button class="baten2" style="border-top:none;border-right:none;border-left:none;">Foto yang kamu simpan</button></div>

      <div class="tile-container">
<?php 
$rows = array();
while($row = mysqli_fetch_assoc($kueri)){
  $rows[] = $row;
}
shuffle($rows);

foreach($rows as $row){
  $id = $row["id"];
  echo "
<div class='tile' data-id='".$id."'>
  <img src='img/donwload-logo.png' class='donlod' style='width: 40px;' title='ini download' onclick='downloadImage(".$id.")'><h2 style='position:absolute;top:10px;left:50px;''>".$row["user"]."</h2><img src='img/hapus.png' alt='share icon' style='margin-left: 160px;width:40px;'  title='Tekan tombol ini jika ingin menghapus dari saved' id='sher' onclick='hapusData($id)'></img>
<img src='data:image/jpeg;base64," . base64_encode($row["gambar"]) . "' class='gambar'>
<div class='overlay'>
  </div><h3>".$row["judul"]."
</div>
";}
?>
</div>
      </div>  
    <script type="text/javascript">
		window.onload = function() {$('.tile-container').pinto();
};
function hapusData(id){
  var konfirmasi = confirm("apakah anda yakin ingin menghapus ini?");
  if(konfirmasi){
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      alert("data berhasil dihapus");window.location.reload();
    }
  };
  xmlhttp.open("GET", "hapusSaved.php?id=" + id, true);
  xmlhttp.send();
}}

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
