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
            <a class="navbar-brand" href="newlist.php">Create A New List</a>
            <button class="navbar-toggler hidden-md-up float-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"></button>
            <!-- Clearfix with a utility class added to allow for better navbar responsiveness. -->
            <div class="clearfix hidden-md-up"></div>
            <div class="collapse navbar-toggleable-sm" id="navbarResponsive">
                <ul class="nav navbar-nav float-md-right">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Current List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Modify List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Modify Groups</a>
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
              <p>Who are you?</p>
              <?php
              print "<form action=\"welcome.php\" method=\"get\">
              <input type=\"submit\" name=\"name\" value=\"Joe\"><br>
              <br />
              <input type=\"submit\" name=\"name\" value=\"Julia\"><br>
            </form>";

            if ($_GET['name'] == 'Julia'){
              $_SESSION['name'] = 'Julia';
              if(ismobile()){
                header("Location: http://shop.sugarbombed.com/mobile.php");
              }else {
                header("Location: http://shop.sugarbombed.com/index.php");
              }

            }elseif ($_GET['name'] == 'Joe'){
              $_SESSION['name'] = 'Joe';
              if(ismobile()){
                header("Location: http://shop.sugarbombed.com/mobile.php");
              }else {
                header("Location: http://shop.sugarbombed.com/index.php");
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
<?php
function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
 ?>
