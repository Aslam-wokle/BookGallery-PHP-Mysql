 <?php
$page_title = 'Login';
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

if (isset($errors) && !empty($errors)) {
	echo '<div class="container">
	 <div class="jumbotron">
	<h1>Error!</h1>
	<p class="error">The following error(s) occurred:<br />';
	foreach ($errors as $msg) {
		echo " - $msg<br />\n";
	}
	echo '</p><p>Please try again.</p>';
}

// Display the form:
?>
<section id="container" class="jumbotron">
<div class="container">

<h1>Login</h1><br><br>
<form action="login.php" method="post">
	<div class="form-group row">
		<label for="email" class="col-sm-2 col-form-label">Email:</label>
		<div class="col-sm-10">
			<input type="email" name="email" class="form-control"  placeholder="wokle@gmail.com"></iput>
		</div>
	</div>
	<div class="form-group row">
		<label for="exampleInputPassword1" class="col-sm-2 col-form-label">Password:</label>
		<div class="col-sm-10">
				<input type="password" name="pass" class="form-control" id="exampleInputPassword1" placeholder="Password">
		</div>
	</div>

    <button type="submit" name="submit" class="btn btn-primary pull-right ">Login</button>
</form>

<?php include ('include/footer.html'); ?>
