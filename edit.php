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
    </style>

</head>

<body>

    <!-- Navigation -->
    <div class="navbar navbar-inverse">
      <div class="navbar-inner">
        <a class="brand" href="#">Shopping List</a>
        <ul class="nav">
          <li class="active"><a href="#">Home</a></li>
          <li><a href="index.php">Desktop View</a></li>
          <li><a href="mobile.php">Mobile View</a></li>
          <li><a href="cart.php">Manage Cart</a></li>
        </ul>
      </div>
    </div>
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

    <script src="js/jquery.js"></script>
    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
