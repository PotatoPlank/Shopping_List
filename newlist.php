<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<?php
include("includes/mysqli.php");
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
              <h1>Shopping List for <?php echo $date;?></h1>
              <?php
              $con = db_connect();
              $result = mysqli_query($con, "SELECT * FROM currentlist WHERE qty > '0' GROUP BY name");
              print '<table class="listtable">';
              $rowcount = $result->num_rows;
              print '<th> Qty </th>';
              print '<th> Name </th>';
              print '<th> Price </th>';
              print '<th> Aisle </th>';
              print '<th> Group </th>';
              print '<th> Added On </th>';
              print '<th> Added By </th>';
              $i = 0;
            while($row = $result->fetch_assoc()){
              if ($i != $result->num_rows){
                //var_dump($row);
                $id[] = $row['id'];
                $qty[] = $row['qty'];
                $pname[] = $row['name'];
                $price[] = $row['price'];
                $aisle[] = $row['aisle'];
                $pgroup[] = $row['product_group'];
                $addedby[] = $row['add_by'];
                $timeadd[] = $row['time_add'];
                $dateadd[] = $row['date_add'];
                $i++;
              }
              }
              $i = 0;
              while($i != count($pname)) {
                $addedon = new DateTime($dateadd[$i] . ' ' . $timeadd[$i]);
                $addedon = $addedon->format('m/d/Y h:i a');
                print '<tr>';
                print '<td>' . $qty[$i] . '</td>';
                print '<td>' . $pname[$i] . '</td>';
                print '<td>' . $price[$i] . '</td>';
                print '<td>' . $aisle[$i] . '</td>';
                print '<td>' . $pgroup[$i] . '</td>';
                print '<td>' . $addedon . '</td>';
                print '<td>' . $addedby[$i] . '</td>';
                print '</tr>';
                $i++;
              }
              print '</table';

               ?>
              //var_dump($result);


            </div>
        </div>
    </div>

    <!-- jQuery Version 4.x.x -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
