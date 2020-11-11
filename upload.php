<?php

session_start();
if (!isset($_SESSION['user_id'])) {

  include ('include/header.html');
  echo '<style media="screen">
    #extra{
      display:none;
    }
    #susuk{
      display:none;
    }
  </style>
  ';

}else{
    include ('include/header.html');
  //echo ($_SESSION['user_id']);
  $user_id = ($_SESSION['user_id']);
}
echo '<style media="screen">
  #susuk{
    display:none;
  }
</style>
';
?>
<div class="container">
 <div class="jumbotron">
<form class="" action="upload.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="" value="1000000">
  <input type="file" name="image" value="" id="image">

  <br><br>

  <div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label">Book Title:</label>
    <div class="col-sm-10">
      <input type="text"  name="title" class="form-control" placeholder="Title">
    </div>
  </div>

  <div class="form-group row">
    <label for="address" class="col-sm-2 col-form-label">Description:</label>
    <div class="col-sm-10">
      <textarea type="text" name="descr" class="form-control"  rows= '4' placeholder="Description"></textarea>
    </div>
  </div>
  <button type="submit" name="upload" class="btn btn-primary pull-right " value="upload" id="insert">Upload</button>
</form>

<?php
require ('connect.php');



$msg = "";

if (isset($_POST['upload'])) {

$dir = '/images/';
  $image = ($_FILES['image']['name']);
   $target = "images/".basename($image);

    if (empty($_POST['descr'])) {
    $errors[] = 'You forgot to enter the description';
     } else {
    $image_text = mysqli_real_escape_string($dbc, $_POST['descr']);
    }

    if (empty($_POST['title'])) {
    $errors[] = 'You forgot to enter the title';
     } else {
    $title = mysqli_real_escape_string($dbc, $_POST['title']);
    }

if(empty($errors)){
  $sql = "INSERT INTO images (user_id, name, descr, title, img_dir) VALUES ('$user_id','$image', '$image_text', '$title', '$target')";

  if(mysqli_query($dbc, $sql))
     {
          $test = move_uploaded_file($_FILES['image']['tmp_name'], $target);
          echo '<script>alert("Book successfully uploaded")</script>';
     }

   }else {

    echo '<p class="error">The following error(s) occurred:<br />';
    foreach ($errors as $msg) {
      echo " - $msg<br />\n";
    }
    echo '</p><p>Please try again.</p>';
 }
}

$result = mysqli_query($dbc, "SELECT * FROM images");

?>
<script>
  $('#upload').click(function(){
    var image_name = $('#mage').val();
    if(image_name==''){
     alert("Please select image");
      return false;
    }else{
    var extension = $('#image').val().split('.').pop().toLowerCase();
      if(jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg'])== -1){
        alert('Invalid image file');
        $('#image').val('');
      return false;
      }
    }
});
</script>

<?php





include ('include/footer.html');
 ?>
