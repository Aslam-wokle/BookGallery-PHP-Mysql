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
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  $errors = array();

  if (empty($_POST['Fname'])){
    $errors[]='You forgot to enter your first name !!';
  }else{
    $Fname = trim($_POST['Fname']);
  }

  if (empty($_POST['Lname'])){
    $errors[]='You forgot to enter your Last name !!';
  }else{
    $Lname = trim($_POST['Lname']);
  }

  if (empty($_POST['gender'])){
    $errors[]='You forgot to pick your gender !!';
  }else{
    $gender = trim($_POST['gender']);
  }

  if (empty($_POST['email'])){
    $errors[]='You forgot to enter your email !!';
  }else{
    $email = trim($_POST['email']);
  }

  if (empty($_POST['phone'])){
    $errors[]='You forgot to enter your phone number !!';
  }else{
    $phone = trim($_POST['phone']);
  }

  if (empty($_POST['address'])){
    $errors[]='You forgot to enter your address !!';
  }else{
    $address = trim($_POST['address']);
  }

  if (!empty($_POST['pass1'])) {
  if ($_POST['pass1'] != $_POST['pass2']) {
    $errors[] = 'Your password did not match the confirmed password.';
  } else {
    $p = trim($_POST['pass1']);
  }
} else {
  $errors[] = 'You forgot to enter your password.';
}

  if (empty($errors)){

    require ('connect.php');

    $q = "INSERT INTO users (Fname, Lname, gender, email, phone, address, registration_date, pass) VALUES ('$Fname', '$Lname', '$gender', '$email', '$phone', '$address', NOW(), SHA1('$p'))";
    $r = @mysqli_query ($dbc, $q);
    if ($r){

      ?>
      <section id="header" class="jumbotron">
        <div class="container">
      <h2>Thank You !</h2><br>

      <p>You are now registered, <?php echo " $Fname" ?></p><br/>
      <?php

    }else{
      ?>
      <section id="header" class="jumbotron">
        <div class="container">
      <h2>System Error</h2><br><br>
      <p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
      <?php
      echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';

    }

    mysqli_close($dbc);

    include ('include/footer.html');
    exit();

  }else{

    echo '<h1>Error!</h1>
    <p class = "error"> The following error(s) occured:<br />';
    foreach ($errors as $msg) {
      echo " - $msg<br /> \n";
    }

    echo '</p><p>Please try again.</p><p><br /></p>';
  }
}

?>
<section id="header" class="jumbotron">
  <div class="container">
<h1>Registration</h1><br><br>
    <form action="register.php" method="post">
      <div class="form-group row">
        <label for="Fname" class="col-sm-2 col-form-label">First Name:</label>
        <div class="col-sm-10">
          <input type="text"  name="Fname" class="form-control"  placeholder="Aslam">
        </div>
      </div>

      <div class="form-group row">
        <label for="Lname" class="col-sm-2 col-form-label">Last Name:</label>
        <div class="col-sm-10">
          <input type="text"  name="Lname" class="form-control" placeholder="Hamdi">
        </div>
      </div>

      <div class="form-group row">
        <label for="Lname" class="col-sm-2 col-form-label">Gender:</label>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="Male">
          <label class="form-check-label" for="inlineRadio1"><b>Male</b></label>
        </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="Female">
            <label class="form-check-label" for="inlineRadio2"><b>Female</b></label>
          </div>
      </div>

      <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">Email:</label>
        <div class="col-sm-10">
          <input type="text" name="email" class="form-control"  placeholder="email@example.com">
        </div>
      </div>

      <div class="form-group row">
        <label for="phone" class="col-sm-2 col-form-label">Phone No:</label>
        <div class="col-sm-10">
          <input type="text" name="phone" class="form-control" placeholder="0123456789">
        </div>
      </div>

      <div class="form-group row">
        <label for="address" class="col-sm-2 col-form-label">Address:</label>
        <div class="col-sm-10">
          <textarea type="text" name="address" class="form-control"  rows= '4' placeholder="Address"></textarea>
        </div>
      </div>

    <div class="form-group row">
      <label for="exampleInputPassword1" class="col-sm-2 col-form-label">Password:</label>
      <div class="col-sm-10">
          <input type="password" name="pass1" class="form-control" id="exampleInputPassword1" placeholder="Password">
      </div>
    </div>

    <div class="form-group row">
      <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Password:</label>
      <div class="col-sm-10">
              <input type="password" name="pass2" class="form-control" id="exampleInputPassword1" placeholder="Password">
      </div>
    </div>

      <button type="submit" name="submit" class="btn btn-primary ">Submit</button>
<br><br>


<?php  include ('include/footer.html');  ?>
