<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<?php
date_default_timezone_set('America/New_York');
$date = date('m/d/Y', time());
 ?>
<head>
  <?php
  include("includes/mysqli.php");
  include("includes/functions.php");
if (isset($_POST['reg'])){
  register();
}
  function register(){
    $error='good';
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = cleanup($username);
    $email = cleanup($email);
    $password = cleanup($password);
    if (reg_pass($password) == false){
      $error = 'pass_reg';
    }else{
      $password = hash('sha256', $password);
    }
    if (reg_email($email) == false){
      $error = 'email_reg';
    }
    if (reg_user($username) == false){
      $error = 'user_reg';
    }
    if ($error =='good'){
      register_qry($username,$password,$email);
      unset($username);
      unset($password);
      unset($email);
      header("Location: " . redirecturl() ."/welcome.php");
    }
  }
  ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">
    <meta name="author" content="">
    <title>Register</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/stylesheet.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 70px;
    }
    </style>

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-fixed-top navbar-dark bg-inverse">
        <div class="container">
            <a class="navbar-brand" href="register.php">Register</a>
            <button class="navbar-toggler hidden-md-up float-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"></button>
            <!-- Clearfix with a utility class added to allow for better navbar responsiveness. -->
            <div class="clearfix hidden-md-up"></div>
            <div class="collapse navbar-toggleable-sm" id="navbarResponsive">
                <ul class="nav navbar-nav float-md-right">
                    <li class="nav-item">
                        <a class="nav-link" href="welcome.php">Login</a>
                    </li>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-xs-center">
              <h1>Register</h1>
              <p>Who are you?</p>
              <?php
              print "<form action=\"register.php\" method=\"post\">
              <input type=\"text\" name=\"username\" placeholder=\"Username\"><br>
              <input type=\"email\" name=\"email\" placeholder=\"E-mail\"><br>
              <input type=\"password\" name=\"password\" placeholder\"Password\"><br>
              <input type=\"submit\" name=\"reg\" value=\"Submit\"><br>
            </form>";
               ?>


            </div>
        </div>
    </div>

    <!-- jQuery Version 4.x.x -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
<?php
ob_end_flush();
?>
