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
$page_title = 'Delete a User';

?>



<div class="container">
 <div class="jumbotron">
<h1>Deleting a User</h1><br><br>

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
//echo "$user_id";
require ('connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if ($_POST['sure'] == 'Yes') {

		$q = "DELETE FROM users WHERE user_id=$user_id LIMIT 1";
		$r = @mysqli_query ($dbc, $q);
		if (mysqli_affected_rows($dbc) == 1) {

			echo '<p>The user has been deleted.</p>';

		} else {
			echo '<p class="error">The user could not be deleted due to a system error.</p>'; // Public message.
			echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
		}

	} else {
		echo '<p>The user has NOT been deleted.</p>';
	}

} else {

	$q = "SELECT user_id, CONCAT(lname, ', ', fname) FROM users WHERE user_id=$user_id";
	$r = @mysqli_query ($dbc, $q);

	if (mysqli_num_rows($r) == 1) {

		$row = mysqli_fetch_array ($r, MYSQLI_NUM);

		?>
<h4 class="text-dark">Name: <?php echo "$row[1]"; ?></h4>
<br>
<p class="text-danger">Are you sure you want to delete this user?</p>

<form class="" action="delete_user.php" method="post">
	<input type="radio" name="sure" value="Yes" /> Yes
	<input type="radio" name="sure" value="No" checked="checked" /> No
	<input type="submit" class="btn btn-danger" name="submit" value="Submit" />
		<?php echo '<input type="hidden" name="user_id" value="' . $user_id . '" />'; ?>

</form>
		<?php


	} else {
		echo '<p class="error">This page has been accessed in error.</p>';
	}

}

mysqli_close($dbc);

include ('include/footer.html');
?>
