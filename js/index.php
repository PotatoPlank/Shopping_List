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
$sqldate = date('Y-m-d',time());
$listcount =0;
$currtime = date('H:i:s', time());
if (!isset($_SESSION['name'])){
  print $_SESSION['name'];
  header("Location: http://shop.sugarbombed.com/welcome.php");
}
 ?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">
    <meta name="author" content="">
    <title>Shopping List</title>

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

  <?php
  if (isset($_GET['submit'])){
    $submittype=$_GET['submit'];
  if ($submittype == 'Add Item'){
    $newid=$_GET['id'];
    $newquan=$_GET['quan'];
    $newname=$_GET['name'];
    $newprice=$_GET['price'];
    $newaisle=$_GET['aisle'];
    $newgroup=$_GET['group'];
    $newaddby=$_GET['addby'];
    $newtime=$_GET['time'];
    $newdate=$_GET['date'];
    db_addlist($newid,$newquan,$newname,$newprice,$newaisle,$newgroup,$newaddby,$newtime,$newdate);
    header("Location: http://shop.sugarbombed.com/index.php");
  }elseif ($submittype =='Remove Item'){
    $remitemid=$_GET['removelistid'];
    db_remitem($remitemid);
    header("Location: http://shop.sugarbombed.com/index.php");
}
}
   ?>

    <!-- Navigation -->
    <nav class="navbar navbar-fixed-top navbar-dark bg-inverse">
        <div class="container">
            <a class="navbar-brand" href="index.php">Shopping List</a>
            <button class="navbar-toggler hidden-md-up float-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"></button>
            <!-- Clearfix with a utility class added to allow for better navbar responsiveness. -->
            <div class="clearfix hidden-md-up"></div>
            <div class="collapse navbar-toggleable-sm" id="navbarResponsive">
                <ul class="nav navbar-nav float-md-right">
                    <li class="nav-item">
                        <a class="nav-link" href="newlist.php">New List</a>
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
              <h1>Shopping List for <?php echo $date?></h1>
              <?php
              $con = db_connect();
              $result = mysqli_query($con, "SELECT * FROM currentlist WHERE qty > '0' GROUP BY product_group");
              print '<table class="listtable">';
              $rowcount = $result->num_rows;
              print '<th> ID# </th>';
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
              $totalprice = 0;
              $totalqty = 0;
              while($i != count($pname)) {
                $addedon = new DateTime($dateadd[$i] . ' ' . $timeadd[$i]);
                $addedon = $addedon->format('m/d/Y h:i a');
                print '<tr>';
                print '<td>' . $id[$i] . '</td>';
                print '<td>' . $qty[$i] . '</td>';
                print '<td>' . $pname[$i] . '</td>';
                print '<td>' . $price[$i] . '</td>';
                print '<td>' . $aisle[$i] . '</td>';
                print '<td>' . $pgroup[$i] . '</td>';
                print '<td>' . $addedon . '</td>';
                print '<td>' . $addedby[$i] . '</td>';
                print '<td><small><a href="#">EDIT</a>   <a href="#">DELETE</a></small></td>';
                $totalprice = $totalprice + $price[$i];
                $totalqty = $totalqty + $qty[$i];
                print '</tr>';
                $i++;
                $idcnt++;
              }
              $listcount = $i;
              $i=0;
              print '<tr style="border-style:none;">';
              print '<td style="border-style:none;"></td>';
              print '<td style="color:white;background-color:gray;border-radius:3px;">' . $totalqty . '</td>';
              print '<td style="border-style:none;"></td>';
              print '<td style="color:white;background-color:gray;border-radius:3px;">' . $totalprice . '</td>';
              print '<td style="border-style:none;"></td>';
              print '<td style="border-style:none;"></td>';
              print '<td style="border-style:none;"></td>';
              print '<td style="border-style:none;"></td>';
              print '</tr>';
              print '</table>';
               ?>

              <?php
              //$addlist = db_addlist();
              $listcount++;
              print "
              <form action=\"index.php\" method=\"get\">
              <input type=\"hidden\" name=\"addby\" value=\"$_SESSION[name]\"><br>
              <input type=\"hidden\" name=\"time\" value=\"$currtime\"><br>
              <input type=\"hidden\" name=\"id\" value=\"$listcount\"><br>
              <input type=\"hidden\" name=\"date\" value=\"$sqldate\"><br>
              <h1>Add New Item</h1>
              Quantity: <input type=\"text\" name=\"quan\"><br>
              Name: <input type=\"text\" name=\"name\"><br>
              Price: <input type=\"text\" name=\"price\"><br>
              Aisle: <input type=\"text\" name=\"aisle\"><br>
              Group: <input type=\"text\" name=\"group\"><br>
              <input type=\"submit\" name=\"submit\" value=\"Add Item\" />
            </form>";

            print "<form action=\"index.php\" method=\"get\">
            <h1>Remove List Item</h1>
            List #: <input type=\"text\" name=\"removelistid\"><br>
            <input type=\"submit\" name=\"submit\" value=\"Remove Item\" />
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
