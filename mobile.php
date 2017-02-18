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
if (!isset($_SESSION['user']) or $_SESSION['user']==''){
  header("Location: " . redirecturl() ."/welcome.php");
}
$platform = 'mobile';
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
    #container-topbtn{
      text-align:center;
      margin:auto
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
                        <a class="nav-link" data-toggle="modal" data-target="#NewList" href="#">New List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Desktop View</a>
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
      <div id="container-topbtn">
      <button type="button" class="btn btn-primary btn-lg" id="item-new" data-toggle="modal" data-target="#newItem">Add New Item</button>
      </div>
        <div class="row">
            <div class="col-lg-12 text-xs-center">
              <h1>Shopping List for <?php echo $date?></h1>
              <?php
              $con = db_connect();
              $result = mysqli_query($con, "SELECT * FROM currentlist WHERE qty > '0' ORDER BY aisle");
              print '<table class="listtable">';
              $rowcount = $result->num_rows;
              if ($rowcount != 0){
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
                print '<td><small><a href="includes/updates.php?list=current&view=' . $platform .'&function=addtocart&id=' . $id[$i] . '">IN CART</a><br /><br /><a href="edit.php?list=current&view=' . $platform .'&id=' . $id[$i] . '">EDIT</a> </small></td>';
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
              echo '<h2>No items need to be bought currently!</h2>';
            }
               ?>
               <div id="newItem" class="modal fade" role="dialog">
                <div class="modal-dialog modal-sm">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Add Item</h4>
                    </div>
                    <div class="modal-body">
                      <?php
                      //$addlist = db_addlist();
                      $listcount++;
                      print "
                      <form action=\"index.php\" method=\"get\">
                      <input type=\"text\" class=\"form-control input-text input-sm\" placeholder=\"Quantity\" name=\"quan\"><br>
                      <input type=\"text\" class=\"form-control input-text input-sm\" placeholder=\"Name\" name=\"name\"><br>
                      <input type=\"text\" class=\"form-control input-text input-sm\" placeholder=\"Price\" name=\"price\"><br>
                      <input type=\"text\" class=\"form-control input-text input-sm\" placeholder=\"Aisle\" name=\"aisle\"><br>
                      <input type=\"text\" class=\"form-control input-text input-sm\" placeholder=\"Product Type\" name=\"group\"><br>
                      <input type=\"submit\" name=\"submit\" class=\"btn btn-primary btn\" value=\"Add Item\" />
                      <input type=\"hidden\" name=\"addby\" value=\"$_SESSION[name]\"><br>
                      <input type=\"hidden\" name=\"time\" value=\"$currtime\"><br>
                      <input type=\"hidden\" name=\"id\" value=\"" . db_nextid() . "\"><br>
                      <input type=\"hidden\" name=\"date\" value=\"$sqldate\"><br>
                    </form>";

                    //  print "<form action=\"index.php\" method=\"get\"><h1>Remove List Item</h1>List #: <input type=\"text\" name=\"removelistid\"><br><input type=\"submit\" name=\"submit\" value=\"Remove Item\" /></form>";
                         ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
  
                  </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div id="NewList" class="modal fade" role="dialog">
   <div class="modal-dialog modal-sm">

     <!-- Modal content-->
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Create New List</h4>
       </div>
       <div class="modal-body">
         <?php
         print "<form action=\"includes/newlist.php\" method=\"post\">
         <input type=\"text\" class=\"form-control input-text input-sm\" name=\"name\" placeholder=\"Listname\"><br>
         <input type=\"submit\" class=\"btn btn-primary btn\" name=\"newlist\" value=\"Store List\"><br>
       </form>";
       ?>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       </div>
     </div>

   </div>
 </div>
    <div class="navbar navbar-default navbar-fixed-bottom">
        <div class="container">
          <div class='copy-text'>
          <p class="navbar-text pull-left">© <?php print date('Y'); ?> - <a href="http://sugarbombed.com" target="_blank" >SugarBombed</a>
          </p>
          </div>
          <div class='footer-nav'>?>
            <?php build_footer();?>
          </div>
        </div>
      </div>
    <!-- jQuery Version 4.x.x -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
