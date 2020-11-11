<?php
session_start(); // Start the session.

if (!isset($_SESSION['user_id'])) {

	// Need the functions:
	require ('include/login_functions.inc.php');
	redirect_user();

}
include ('include/header.html');
echo '<style media="screen">

	#susuk{
		display:none;
	}
</style>
';
 ?>
 <section id="header" class="jumbotron">
   <div class="container">
 <h1>Registered users</h1><br><br>

 <?php

require ('connect.php');

$q = "SELECT user_id, CONCAT(Lname, ' ', Fname) AS name,  email AS mail, DATE_FORMAT(registration_date, '%M %d, %Y') AS dr FROM users ORDER BY registration_date ASC";
$r = @mysqli_query ($dbc,$q);

if($r){

  $i = 0;

  ?>
  <table class="table">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Registration Date</th>
    </tr>
  </thead>

  <?php
  while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
    $i++;
    ?>
    <tbody>
   <tr>
     <th scope="row"><?php echo '<p>' . $i . '</p>'; ?></th>
     <td><?php echo '<p>' . $row['name'] . '</p>'; ?></td>
     <td><?php echo '<p>' . $row['mail'] . '</p>'; ?></td>
     <td><?php echo '<p>' . $row['dr'] . '</p>'; ?></td>
     <td><?php echo '<a href="edit_user.php?user_id=' . $row['user_id'] . '"><button type="button" class="btn btn-success">Edit <i class="fa fa-pencil" aria-hidden="true"></i></button></a>'; ?></td>

     <td><?php  echo '<a href="delete_user.php?user_id=' . $row['user_id'] . '"><button type="button" class="btn btn-danger">Delete <i class="fa fa-trash-o" aria-hidden="true"></i></button></a>'; ?></td>

   </tr>

   <?php } ?>

 </tbody>
</table>

<?php
mysqli_free_result ($r);
}else{
  ?>
  <section id="header" class="jumbotron">
    <div class="container">
  <h2>System Error</h2><br><br>
  <p class="error">The current users could not be retrieved. We apologize for any inconvenience</p>';
  <?php
  	echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
}

mysqli_close($dbc);

include ('include/footer.html')
  ?>
