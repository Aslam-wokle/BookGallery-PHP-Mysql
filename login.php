<?php

//include ('include/header.html');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require ('include/login_functions.inc.php');
	require ('connect.php');

	list ($check, $data) = check_login($dbc, $_POST['email'], $_POST['pass']);

	if ($check) {

		session_start();
		$_SESSION['user_id'] = $data['user_id'];
		$_SESSION['Fname'] = $data['Fname'];

		redirect_user('loggedin.php');

	} else {

		$errors = $data;

	}

	mysqli_close($dbc);

}

include ('include/login_page.inc.php');
?>
