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
$page_title = 'Delete a Book';
?>

<div class="container">
 <div class="jumbotron">
<h1>Deleting a Book</h1><br><br>

<?php
//$test = $_SESSION['id'];
//echo"$test"; ?>
<?php

if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) {
	$id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) {
	$id = $_POST['id'];
} else {
	echo '<p class="error">This page has been accessed in error.</p>';
	include ('include/footer.html');
	exit();
}
 //echo "$id";
require ('connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if ($_POST['sure'] == 'Yes') {

		$q = "DELETE FROM images WHERE id=$id LIMIT 1";
		$r = @mysqli_query ($dbc, $q);
		if (mysqli_affected_rows($dbc) == 1) {

			echo '<p>The book has been deleted.</p>';

		} else {
			echo '<p class="error">The user could not be deleted due to a system error.</p>'; // Public message.
			echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
		}

	} else {
		echo '<p>The book has NOT been deleted.</p>';
	}

} else {

	$q = "SELECT id, title FROM images WHERE id=$id";
	$r = @mysqli_query ($dbc, $q);

	if (mysqli_num_rows($r) == 1) {

		$row = mysqli_fetch_array ($r, MYSQLI_NUM);

		?>
<h4 class="text-dark">Book Title: <?php echo "$row[1]"; ?></h4>
<br>
<p class="text-danger">Are you sure you want to delete this book?</p>

<form class="" action="delete_book.php" method="post">
	<input type="radio" name="sure" value="Yes" /> Yes
	<input type="radio" name="sure" value="No" checked="checked" /> No
	<input type="submit" class="btn btn-danger" name="submit" value="Submit" />
		<?php echo '<input type="hidden" name="id" value="' . $id . '" />'; ?>

</form>
		<?php


	} else {
		echo '<p class="error">This page has been accessed in error.</p>';
	}

}

mysqli_close($dbc);

include ('include/footer.html');
?>
