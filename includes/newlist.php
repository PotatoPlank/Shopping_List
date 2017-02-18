<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<?php
require("mysqli.php");
require("functions.php");
if (isset($_POST['newlist']) and $_POST['name'] != ''){
  $listname = $_POST['name'];
  $listname = cleanup($listname);
  $newlist = createnewlist($listname);
  if ($newlist != false){
    if(ismobile()){
      header("Location: " . redirecturl() ."/mobile.php");
    }else {
      header("Location: " . redirecturl() ."/index.php");
    }
  }else{
    print '<center><b>Something went wrong creating a new list!</b></center>';
  }
}elseif ($_POST['name'] == '' and isset($_POST['newlist'])){
  print '<center><b>You need to enter a list name!</b></center>';
}
date_default_timezone_set('America/New_York');
$date = date('m/d/Y', time());
 ?>
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
                        <a class="nav-link" href="mobile.php">Mobile View</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">Manage Cart</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-xs-center">
              <h1>Create New Shopping List</h1>
              <?php
              print "<form action=\"newlist.php\" method=\"post\">
              <input type=\"text\" name=\"name\" placeholder=\"List name\"><br>
              <input type=\"submit\" name=\"newlist\" value=\"Submit\"><br>
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
