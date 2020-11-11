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
    echo '<style media="screen">
      #susuk{
        display:none;
      }
    </style>';
}

echo '<div class="container">
  <div class="jumbotron">
      <h1 class="main"><span><i class="fas fa-book"></i></span> Book(s) you owned</h1>

  </div>
</div>';
    require ('connect.php');

    $table = 'images';
$user = $_SESSION['user_id'];
    $result = $dbc->query("SELECT * FROM $table where user_id  = '$user'") or die($dbc->error);
    $r = @mysqli_query ($dbc,$query);



    ?>

    <!-- -lg-4 col-sm-2 -->
    <section class="gallery-block cards-gallery">

      <div class="container mt-1">
      <div class="row">

    <?php
      while($data = $result->fetch_assoc()){
    $uploaded = $data['user_id'];
    $user = $dbc->query("SELECT Fname FROM users where user_id = '$uploaded' ") or die($dbc->error);
    $q = @mysqli_query ($dbc,$query);
    $row = $user->fetch_assoc();
    ?>

      <div class="col-md-6 col-lg-4">
        <div style="background-color:#2c3e50" class="card border-8 transform-on-hover mb-4" id="test">
        <!-- <div class="card mb-2" style="width: 18rem;" id="kad"> -->
          <img src='<?php echo "{$data['img_dir']}" ?>' id="kad"  width="700" height="450" class="card-img-top"/>
          <div class="card-body">
            <h5 style="color:White" class="card-title"><?php echo "{$data['title']}" ?></h5>
            <p class="card-text"><?php echo "{$data['descr']}" ?></p>
            <p class="card-text">Uploaded by, <?php echo "{$row['Fname']}" ?></p>
            <td><?php echo '<a href="edit_book2.php?id=' . $data['id'] . '"><button type="button" class="btn btn-success">Edit <i class="fa fa-pencil" aria-hidden="true"></i></button></a>'; ?></td>

            <td><?php  echo '<a href="delete_book.php?id=' . $data['id'] . '"><button type="button" class="btn btn-danger">Delete <i class="fa fa-trash-o" aria-hidden="true"></i></button></a>'; ?></td>

          </div>
        <!-- </div> -->
        </div>
      </div>

    <?php


    }
    ?>

    </section>
    </div>
    </div>

<?php
 include ('include/footer.html');
 ?>
