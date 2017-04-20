<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<?php
require("includes/mysqli.php");
require("includes/functions.php");
date_default_timezone_set('America/New_York');
$date = date('m/d/Y', time());
$sqldate = date('Y-m-d',time());
$listcount =0;
$currtime = date('H:i:s', time());
$platform;
if (!isset($_SESSION['user']) or $_SESSION['user']==''){
  header("Location: " . redirecturl() ."/welcome.php");
}
if (isset($_REQUEST['view'])){
  $platform = $_SESSION['view'];
}else{
  $platform='desktop';
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

    <div class="navbar navbar-inverse">
      <div class="navbar-inner">
        <a class="brand" href="#">Shopping List</a>
        <ul class="nav">
          <li class="active"><a href="#">Home</a></li>
          <li><a href="" data-toggle="modal" data-target="#NewList">New List</a></li>
          <li><a href="index.php">Desktop View</a></li>
          <li><a href="mobile.php">Mobile View</a></li>
        </ul>
      </div>
    </div>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-xs-center">
              <?php
              $con = db_connect();
              $result = mysqli_query($con, "SELECT * FROM list_cart WHERE qty > '0' ORDER BY aisle");
              $rowcount = $result->num_rows;
              if($rowcount!=0){
              print '<h1>Shopping List for'. $date . '</h1>';
              print '<table class="listtable">';
              print '<th> Qty </th>';
              print '<th> Name </th>';
              print '<th> Price </th>';
              print '<th> Aisle </th>';
              print '<th> Edit </th>';
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
                print '<td>' . $qty[$i] . '</td>';
                print '<td><small>' . $pname[$i] . '</small></td>';
                print '<td>$' . $price[$i] . '</td>';
                print '<td>' . $aisle[$i] . '</td>';
                print '<td><small><a href="includes/updates.php?list=cart&view=' . $platform . '&function=addtocart&id=' . $id[$i] . '">TO LIST</a><br /><br /><a href="edit.php?list=cart&view=desktop&id=' . $id[$i] . '">EDIT</a> </small></td>';
                $totalprice = $totalprice + $price[$i];
                $totalqty = $totalqty + $qty[$i];
                $taxedprice = $totalprice * 1.06;
                print '</tr>';
                $i++;
              }
              $listcount = $i;
              $i=0;
              print '<tr style="border-style:none;">';
              print '<td style="color:white;background-color:gray;border-radius:3px;">' . $totalqty . '</td>';
              print '<td style="border-style:none;"></td>';
              print '<td style="color:white;background-color:gray;border-radius:3px;">$' . $totalprice . '</td>';
              print '<td style="border-style:none;"></td>';
              print '</tr>';
              print '<tr style="border-style:none;">';
              print '<td style="border-style:none;"></td>';
              print '<td style="border-style:solid;border-width:1px;">Taxed Total: </td>';
              print '<td style="color:white;background-color:gray;border-radius:3px;">$' . round($taxedprice,2) . '</td>';
              print '<td style="border-style:none;"></td>';
              print '</tr>';
              print '</table>';
            }else{
              print '<h1>Nothing is in the cart currently!</h1>';
            }
               ?>

              <?php

          //  print "<form action=\"index.php\" method=\"get\"><h1>Remove List Item</h1>List #: <input type=\"text\" name=\"removelistid\"><br><input type=\"submit\" name=\"submit\" value=\"Remove Item\" /></form>";
               ?>
            </div>
        </div>
    </div>
    <script>
    function confirmDelete(){
      var conf = confirm("Press a button!");
      if (conf == true) {
        alert('ok!');
      } else {
        alert('cancel!')
      }
    }
    </script>
    <script src="js/jquery.js"></script>
    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
