<?php
session_start();
require_once("includes/mysqli.php");
require_once("includes/functions.php");

date_default_timezone_set('America/New_York');
$date = date('m/d/Y', time());

  if (isset($_SESSION['user']) and $_SESSION['user']!=''){
    if(ismobile()){
      header("Location: " . redirecturl() ."/mobile.php");
    }else {
      header("Location: " . redirecturl() ."/index.php");
    }
  }
  if (isset($_POST['signin'])){
    sign_in();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">
    <meta name="author" content="">
    <title>Create New Shopping List</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/stylesheet.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
    .form-control{width:100%;}.login-cont{margin-left:35%;margin-right:35%;}.btn-primary{margin-left:5vw;}
    </style>

</head>

<body>

    <!-- Navigation -->

    <div class="navbar navbar-inverse">
      <div class="navbar-inner">
        <a class="brand" href="#">Sign In</a>
        <ul class="nav">
          <li><a href="register.php">Register</a></li>
        </ul>
      </div>
    </div>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="login-cont">
              <h1>Welcome!</h1>
              <p>Login</p>
              <?php
              print "<form action=\"welcome.php\" method=\"post\">
              <input type=\"text\" class=\"form-control\" name=\"username\" placeholder=\"Username\"><br>
              <input type=\"password\" class=\"form-control\" name=\"password\" placeholder=\"Password\"><br>
              <input type=\"submit\" name=\"signin\" class=\"btn btn-primary\" value=\"Submit\"><br>
            </form>";
               ?>
            </div>
        </div>
    </div>

    <!-- jQuery Version 4.x.x -->
    <script src="js/jquery.js"></script>
    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
