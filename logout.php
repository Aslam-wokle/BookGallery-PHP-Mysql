<?php # Script 12.11 - logout.php #2
// This page lets the user logout.
// This version uses sessions.

session_start(); // Access the existing session.
if (!isset($_SESSION['user_id'])) {

	// Need the functions:
	require ('include/login_functions.inc.php');
	redirect_user();

}
// If no session variable exists, redirect the user:
if (!isset($_SESSION['user_id'])) {

	// Need the functions:
	require ('include/login_functions.inc.php');
	redirect_user();

} else { // Cancel the session:

	$_SESSION = array(); // Clear the variables.
	session_destroy(); // Destroy the session itself.
	setcookie ('PHPSESSID', '', time()-3600, '/', '', 0, 0); // Destroy the cookie.

}

// Set the page title and include the HTML header:
$page_title = 'Logged Out!';
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

// Print a customized message:
echo '
<div class="container">
 <div class="jumbotron">
<h1>Logged Out!</h1>
<p>You are now logged out!</p>';

include ('include/footer.html');
?>
