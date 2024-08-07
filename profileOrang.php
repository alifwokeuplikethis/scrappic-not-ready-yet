<?php
include "koneksi.php";
session_start();
$namaUser = $_GET["user"];
$kueri = mysqli_query($koneksi, "SELECT * FROM images where user='$namaUser'");
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
    .baten2{
        background-color:#FF5580;
        cursor:pointer;
    }
    .baten1{
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
   <img src="data:image/jpeg;base64,<?=base64_encode($kueh["profile"])?>" style="width:180px;height:180px;border-radius:150px;margin:auto;cursor:pointer;"><center>
</center>
<?php } ?>
<br/>

      <div class="tile-container">  
<?php 
$rows = array();
while($row = mysqli_fetch_assoc($kueri)){
  $rows[] = $row;
}
shuffle($rows);

foreach($rows as $key => $row){
  $id = $row["id"];
  echo "
<div class='tile' data-id='".$id."'>
  <img src='img/donwload-logo.png' class='donlod' style='width: 40px;' title='ini download' onclick='downloadImage(".$id.")'><h2 style='position:absolute;top:10px;left:50px;''>".$row["user"]."</h2>
<img src='data:image/jpeg;base64," . base64_encode($row["image_data"]) . "' class='gambar'>
<div class='overlay'>
  </div><h3>".$row["judul"]."</h3>
</div>
";}
?>  
</div>
      </div>  
    <script type="text/javascript">
		window.onload = function() {$('.tile-container').pinto();
};
function downloadImage(imageId) {
  var imageData = document.querySelector('.tile[data-id="' + imageId + '"] .gambar').getAttribute('src').split(',')[1];
  var blob = b64toBlob  (imageData, 'image/jpeg');
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
