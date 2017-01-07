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
  function sign_in(){
    $error='good';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $username = cleanup($username);
    $password = cleanup($password);
    if (empty($password)){
      $error = 'pass';
    }else{
      $password = hash('sha256', $password);
    }
    if (empty($username)){
      $error = 'user';
    }
    if ($error =='good'){
      if (login_user($username,$password) == true){
        unset($username);
        unset($password);
        if(ismobile()){
          header("Location: " . redirecturl() ."/mobile.php");
        }else {
          header("Location: " . redirecturl() ."/index.php");
        }
      }else{

      }

    }
  }
  ?>
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
    body {
        padding-top: 70px;
    }
    </style>

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-fixed-top navbar-dark bg-inverse">
        <div class="container">
            <a class="navbar-brand" href="welcome.php">Sign In</a>
            <button class="navbar-toggler hidden-md-up float-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"></button>
            <!-- Clearfix with a utility class added to allow for better navbar responsiveness. -->
            <div class="clearfix hidden-md-up"></div>
            <div class="collapse navbar-toggleable-sm" id="navbarResponsive">
                <ul class="nav navbar-nav float-md-right">
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-xs-center">
              <h1>Welcome!</h1>
              <p>Login</p>
              <?php
              print "<form action=\"welcome.php\" method=\"post\">
              <input type=\"text\" name=\"username\" placeholder=\"Username\"><br>
              <input type=\"password\" name=\"password\" placeholder=\"Password\"><br>
              <input type=\"submit\" name=\"signin\" value=\"Submit\"><br>
            </form>";

            if ($_SESSION['user'] == 'Julia'){
              $_SESSION['name'] = 'Julia';
              if(ismobile()){
                header("Location: " . redirecturl() ."/mobile.php");
              }else {
                header("Location: " . redirecturl() ."/index.php");
              }

            }elseif ($_SESSION['user'] == 'Joe'){
              $_SESSION['name'] = 'Joe';
              if(ismobile()){
                header("Location: " . redirecturl() ."/mobile.php");
              }else {
                header("Location: " . redirecturl() ."/index.php");
              }
            }



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
