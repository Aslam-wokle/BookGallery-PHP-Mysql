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

}
echo '<style media="screen">
  #susuk{
    display:none;
  }
</style>
';

$user = $_SESSION['user_id'];

 ?>
 <section id="header" class="jumbotron">
   <div class="container">
 <h1>Edit Book</h1>

 <?php
 if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) {
  $id = $_GET['id'];
 } elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) {
  $id = $_POST['id'];

 } else {
  echo '<p class="error">This page has been accessed in error.</p>';
    echo "$id";
  include ('include/footer.html');
  exit();
 }

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
  //$target = "images/".basename($image);

 $q = "UPDATE images SET user_id='$user', name='$image', descr='$image_text', title='$title', img_dir='$target' WHERE id=$id LIMIT 1";
  //$r = @mysqli_query($dbc, $q);
  if(mysqli_query($dbc, $q))
     {
          $test = move_uploaded_file($_FILES['image']['tmp_name'], $target);
          echo '<script>alert("Book succesfully edited")</script>';
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

 $q = "SELECT title, descr FROM images WHERE id=$id";
$r = @mysqli_query ($dbc, $q);
if (mysqli_num_rows($r) == 1) {

	$row = mysqli_fetch_array ($r, MYSQLI_NUM);
 ?>

<div class="container">
 <div class="jumbotron">
<form class="" action="edit_book2.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="" value="1000000">
  <input type="file" name="image" value="" id="image">
<?php   echo "$id";  ?>
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
            <?php echo ' <input type="hidden" name="id" value="' . $id . '" />' ?>
</form>

<?php
} else {
	echo '<p class="error">This page has been accessed in error.</p>';
}

mysqli_close($dbc);

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
