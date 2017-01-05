<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<?php
date_default_timezone_set('America/New_York');
$date = date('m/d/Y', time());
$editid = $_GET['id'];
$listtoedit = $_GET['list'];
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
              <?php
              $qtyvalue;
              $namevalue;
              $pricevalue;
              $aislevalue;
              $groupvalue;
              $addby;
              $timeadd;
              $dateadd;
              if ($listtoedit =='current'){
                $con = db_connect();
                $result = mysqli_query($con, "SELECT * FROM currentlist WHERE id = $editid ORDER BY aisle");
                $rowcount = $result->num_rows;
                while($row = $result->fetch_assoc()){
                    $qtyvalue = $row['qty'];
                    $namevalue = $row['name'];
                    $pricevalue = $row['price'];
                    $aislevalue = $row['aisle'];
                    $groupvalue = $row['product_group'];
                    $addby = $row['add_by'];
                    $timeadd = $row['time_add'];
                    $dateadd = $row['date_add'];
                }
              }elseif ($listtoedit =='cart'){
                $con = db_connect();
                $result = mysqli_query($con, "SELECT * FROM list_cart WHERE id = $editid ORDER BY aisle");
                $rowcount = $result->num_rows;
                while($row = $result->fetch_assoc()){
                    $qtyvalue = $row['qty'];
                    $namevalue = $row['name'];
                    $pricevalue = $row['price'];
                    $aislevalue = $row['aisle'];
                    $groupvalue = $row['product_group'];
                    $addby = $row['add_by'];
                    $timeadd = $row['time_add'];
                    $dateadd = $row['date_add'];
                }
              }
              print "<form action=\"includes/updates.php\" method=\"get\">
              <input type=\"hidden\" name=\"addby\" value=\"$addby\"><br>
              <input type=\"hidden\" name=\"time\" value=\"$timeadd\"><br>
              <input type=\"hidden\" name=\"id\" value=\"$editid\"><br>
              <input type=\"hidden\" name=\"date\" value=\"$dateadd\"><br>
              <input type=\"hidden\" name=\"view\" value=\"$_GET[view]\"><br>
              <h1>Editing list</h1>
            Quantity:  <input type=\"text\" name=\"qty\" value=\"$qtyvalue\"><br>
            Name:  <input type=\"text\" name=\"name\" value=\"$namevalue\"><br>
            Price:  <input type=\"text\" name=\"price\" value=\"$pricevalue\"><br>
            Aisle:  <input type=\"text\" name=\"aisle\" value=\"$aislevalue\"><br>
            Group:  <input type=\"text\" name=\"group\" value=\"$groupvalue\"><br>
              <input type=\"submit\" name=\"edit\" value=\"Save\"><br>
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
