<?php

session_start();
if (!isset($_SESSION['user_id'])) {

  include ('include/header.html');
  echo '<style media="screen">
    #extra{
      display:none;
    }
  </style>
  ';
}else{
    include ('include/header.html');

}

echo '<div class="container">
  <div class="jumbotron">
      <h1 class="main"><span><i class="fas fa-book"></i></span>Aslam Book Gallery</h1>
    <p class="lead">A bunch of book. </p>
    <hr class="my-4">

  </div>
</div>
';

require ('connect.php');

$table = 'images';

$result = $dbc->query("SELECT * FROM $table") or die($dbc->error);
$r = @mysqli_query ($dbc,$query);

?>
<section class="gallery-block cards-gallery">

  <div class="container mt-1">
  <div class="row">

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect value of input field
  $tajuk = $_POST['tajuk'];
  if (empty($tajuk)) {
    while($data = $result->fetch_assoc()){
  $uploaded = $data['user_id'];
  $user = $dbc->query("SELECT Fname FROM users where user_id = '$uploaded' ") or die($dbc->error);
  $q = @mysqli_query ($dbc,$query);
  $row = $user->fetch_assoc();

  ?>

    <div class="col-md-6 col-lg-4">
      <div style="background-color:#2c3e50" class="card border-8 transform-on-hover mb-4" id="test">
        <img src='<?php echo "{$data['img_dir']}" ?>' id="kad"  width="700" height="450" class="card-img-top"/>
        <div class="card-body">
          <h5 style="color:White" class="card-title"><?php echo "{$data['title']}" ?></h5>
          <p class="card-text"><?php echo "{$data['descr']}" ?></p>
          <p class="card-text">Uploaded by, <?php echo "{$row['Fname']}" ?></p>
          <a href="#" class="btn btn-primary">Start Reading</a>
        </div>
      </div>
    </div>

  <?php
  }
} else if (!empty($tajuk)){
//display ikut tajuk search
$table = 'images';
$buku = $dbc->query("SELECT * FROM $table where title LIKE '%$tajuk%'") or die($dbc->error);
$r = @mysqli_query ($dbc,$query);

    while($data = $buku->fetch_assoc()){
    $uploaded = $data['user_id'];
    $user = $dbc->query("SELECT Fname FROM users where user_id = '$uploaded' ") or die($dbc->error);
    $q = @mysqli_query ($dbc,$query);
    $row = $user->fetch_assoc();
    $baru = $user->fetch_assoc(); //baru = query untuk tajuk

    ?>

      <div class="col-md-6 col-lg-4">
        <div style="background-color:#2c3e50" class="card border-8 transform-on-hover mb-4" id="test">
          <img src='<?php echo "{$data['img_dir']}" ?>' id="kad"  width="700" height="450" class="card-img-top"/>
          <div class="card-body">
            <h5 style="color:White" class="card-title"><?php echo "{$data['title']}" ?></h5>
            <p class="card-text"><?php echo "{$data['descr']}" ?></p>
            <p class="card-text">Uploaded by, <?php echo "{$row['Fname']}" ?></p>
            <a href="#" class="btn btn-primary">Start Reading</a>
          </div>
        </div>
      </div>

    <?php

}
}
}else{
  while($data = $result->fetch_assoc()){
$uploaded = $data['user_id'];
$user = $dbc->query("SELECT Fname FROM users where user_id = '$uploaded' ") or die($dbc->error);
$q = @mysqli_query ($dbc,$query);
$row = $user->fetch_assoc();

?>

  <div class="col-md-6 col-lg-4">
    <div style="background-color:#2c3e50" class="card border-8 transform-on-hover mb-4" id="test">
      <img src='<?php echo "{$data['img_dir']}" ?>' id="kad"  width="700" height="450" class="card-img-top"/>
      <div class="card-body">
        <h5 style="color:White" class="card-title"><?php echo "{$data['title']}" ?></h5>
        <p class="card-text"><?php echo "{$data['descr']}" ?></p>
        <p class="card-text">Uploaded by, <?php echo "{$row['Fname']}" ?></p>
        <a href="#" class="btn btn-primary">Start Reading</a>
      </div>
    </div>
  </div>

<?php
}
}
?>

</section>
</div>
</div>
<?php
include ('include/footer.html');
 ?>
