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



 ?>
 <section id="header" class="jumbotron">
   <div class="container">
 <h1>Edit User</h1><br><br>

 <?php
 if ( (isset($_GET['user_id'])) && (is_numeric($_GET['user_id'])) ) {
 	$user_id = $_GET['user_id'];
} elseif ( (isset($_POST['user_id'])) && (is_numeric($_POST['user_id'])) ) {
 	$user_id = $_POST['user_id'];
 } else {
 	echo '<p class="error">This page has been accessed in error.</p>';
 	include ('include/footer.html');
 	exit();
 }

 require ('connect.php');
// $test = $_SESSION['user_id'];
// echo "$test";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$errors = array();

	if (empty($_POST['Fname'])) {
		$errors[] = 'You forgot to enter your first name.';
	} else {
		$fn = mysqli_real_escape_string($dbc, trim($_POST['Fname']));
	}

	if (empty($_POST['Lname'])) {
		$errors[] = 'You forgot to enter your last name.';
	} else {
		$ln = mysqli_real_escape_string($dbc, trim($_POST['Lname']));
	}

	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}

	if (empty($errors)) {


		$q = "SELECT user_id FROM users WHERE email='$e' AND user_id != $user_id";
		$r = @mysqli_query($dbc, $q);
		if (mysqli_num_rows($r) == 0) {


			$q = "UPDATE users SET Fname='$fn', Lname='$ln', email='$e' WHERE user_id=$user_id LIMIT 1";
			$r = @mysqli_query ($dbc, $q);
			if (mysqli_affected_rows($dbc) == 1) {


				echo '<p>The user has been edited.</p>';

			} else {
        echo '<p class="error">Nothing has been changed</p>';
				echo '<p class="error">The user was not edited</p>'; // Public message.
			//	echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>';
			}

		} else {
			echo '<p class="error">The email address has already been registered.</p>';
		}

	} else {

		echo '<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) {
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p>';

	}

}

$q = "SELECT Fname, Lname, email FROM users WHERE user_id=$user_id";
$r = @mysqli_query ($dbc, $q);

if (mysqli_num_rows($r) == 1) {

	$row = mysqli_fetch_array ($r, MYSQLI_NUM);

	echo '    <form action="edit_user.php" method="post">
        <div class="form-group row">
          <label for="Fname" class="col-sm-2 col-form-label">First Name:</label>
          <div class="col-sm-10">
            <input type="text"  name="Fname" class="form-control"  value = "' . $row[0] . '" >
          </div>
        </div>

        <div class="form-group row">
          <label for="Lname" class="col-sm-2 col-form-label">Last Name:</label>
          <div class="col-sm-10">
            <input type="text"  name="Lname" class="form-control" value = "' . $row[1] . '">
          </div>
        </div>

        <div class="form-group row">
          <label for="Lname" class="col-sm-2 col-form-label">Email:</label>
          <div class="col-sm-10">
            <input type="text"  name="email" class="form-control" value = "' . $row[2] . '">
          </div>
        </div>

              <button type="submit" name="submit" class="btn btn-primary " value="submit" >Submit</button>
              <input type="hidden" name="user_id" value="' . $user_id . '" />
              <br><br>';

} else {
	echo '<p class="error">This page has been accessed in error.</p>';
}

mysqli_close($dbc);

include ('include/footer.html');
?>
