<?php # Script 12.9 - loggedin.php #2
// The user is redirected here from login.php.

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
$page_title = 'Logged In!';

// Print a customized message:
?>
<div class="container">
  <div class="jumbotron">
<?php
echo "
<h1>Logged In!</h1>
<p>You are now logged in, {$_SESSION['Fname']}!</p>
<p><a href=\"logout.php\"><button type=\"submit\" name=\"submit\" class=\"btn btn-primary \">Logout</button></a></p>";


include ('include/footer.html');
?>
