<?php
session_start();
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
if (isset($_REQUEST['logout']) and $_REQUEST['logout'] == 'y'){
  logout();
}
nav_check();
 ?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Shopping List</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/stylesheet.css" rel="stylesheet">
    <style>

        #container-topbtn{text-align:center;margin:auto;}
        .navbar-inverse{margin-top:none;}
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
    db_addlist($newquan,$newname,$newprice,$newaisle,$newgroup,$newaddby,$newtime,$newdate);
    header("Location: " . redirecturl() ."/index.php");
  }elseif ($submittype =='Remove Item'){
    $remitemid=$_GET['removelistid'];
    db_remitem($remitemid);
    header("Location: " . redirecturl() ."/index.php");
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
          <li><a href="" data-toggle="modal" data-target="#NewGroup">New Group</a></li>
          <li><a href="mobile.php">Mobile View</a></li>
          <li><a href="cart.php">Manage Cart</a></li>
          <li><a href="index.php?logout=y">Logout</a></li>
        </ul>
      </div>
    </div>

    <!-- Page Content -->
    <div id="container-topbtn">
    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#newItem">Add New Item</button>
    </div>
    <div class="container">
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
              print '<th> Added On </th>';
              print '<th> Added By </th>';
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
                print '<td>' . $pname[$i] . '</td>';
                print '<td>$' . $price[$i] . '</td>';
                print '<td>' . $aisle[$i] . '</td>';
                print '<td>' . $addedon . '</td>';
                print '<td>' . $addedby[$i] . '</td>';
                print '<td><small><a href="includes/updates.php?list=current&function=addtocart&id=' . $id[$i] . '">IN CART </a><a href="edit.php?list=current&id=' . $id[$i] . '">EDIT</a>   <a onclick="confirmDelete('.$id[$i] .',\'' . $pname[$i] . '\')" href="#">DELETE</a></small></td>';
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
              print '<td style="border-style:none;"></td>';
              print '<td style="border-style:none;"></td>';
              print '</tr>';
              print '<tr style="border-style:none;">';
              print '<td style="border-style:none;"></td>';
              print '<td style="border-style:solid;border-width:1px;">Taxed Total: </td>';
              print '<td style="color:white;background-color:gray;border-radius:3px;">$' . round($taxedprice,2) . '</td>';
              print '<td style="border-style:none;"></td>';
              print '<td style="border-style:none;"></td>';
              print '<td style="border-style:none;"></td>';
              print '</tr>';
              print '</table>';
            }else{
              echo '<h2>No items need to be bought currently!</h2>';
            }
               ?>
            </div>
        </div>
    </div>
    <div id="newItem" class="modal hide fade" role="dialog">
     <div class="modal-dialog modal-sm">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title">Add Item</h4>
         </div>
         <div class="modal-body">
           <?php
           //$addlist = db_addlist();
           $listcount++;
           $sqlgetgroups="SELECT * FROM shop_pgroups";
           $resultgrp = db_query($sqlgetgroups);
           if($resultgrp  != true){echo $resultgrp;}
           print "
           <form action=\"index.php\" method=\"get\">
           <input type=\"number\" class=\"form-control input-text input-sm\" placeholder=\"Quantity\" value=\"1\" name=\"quan\"><br>
           <input type=\"text\" class=\"form-control input-text input-sm\" placeholder=\"Name\" name=\"name\"><br>
           <input type=\"number\" step=\"any\" class=\"form-control input-text input-sm\" placeholder=\"Price\" name=\"price\"><br>
           <select class=\"form-control\" name=\"aisle\" placeholder=\"Aisle\">
           <option></option>
           <option>1A</option>
           <option>2A</option>
           <option>3A</option>
           <option>4A</option>
           <option>4B</option>
           <option>5A</option>
           <option>6A</option>
           <option>7A</option>
           <option>13A</option>
           <option>13B</option>
           <option>14A</option>
           <option>14B</option>
           <option>15A</option>
           <option>15B</option>
           <option>16A</option>
           <option>16B</option>
           <option>17A</option>
           <option>17B</option>
           <option>18A</option>
           <option>18B</option>
           <option>19A</option>
           <option>19B</option>
           <option>20</option>
           <option>21</option>
           <option>22</option>
           <option>Beverage Center</option>
           <option>Frozen</option>
           <option>Deli</option>
           <option>Dairy</option>
           <option>Bakery</option>
           <option>Seafood</option>
           <option>Meat</option>
           <option>Alcohol</option>
           <option>Produce</option>
           </select><br />
           <select class=\"form-control\" name=\"group\" placeholder=\"Product Type\">
           <option></option>";
           while($rowgrp=$resultgrp->fetch_assoc()){
             echo "<option value='$rowgrp[name]'>$rowgrp[name]</option>";
           }
           echo"
           </select><br />
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
          <input type=\"text\" class=\"form-control input-text input-sm\" name=\"name\" placeholder=\"List Name\"><br>
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
  <div id="NewGroup" class="modal fade" role="dialog">
   <div class="modal-dialog modal-sm">
     <!-- Modal content-->
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Create New Group</h4>
       </div>
       <div class="modal-body">
         <?php
         print "<form action=\"includes/creategroup.php\" method=\"post\">
         <input type=\"text\" class=\"form-control input-text input-sm\" name=\"name\" placeholder=\"Group Name\"><br>
         <input type=\"submit\" class=\"btn btn-primary btn\" name=\"newlist\" value=\"Create\"><br>
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
          <div class='footer-nav'>
            <?php build_footer();?>
          </div>
        </div>
      </div>
    <script>
    function confirmDelete(del_id,name){
      var conf = confirm("Are you sure you want to delete " + name +"?");
      if (conf == true) {
        window.location.replace('<?php echo redirecturl(); ?>/includes/updates.php?list=current&function=delete&id=' + del_id)
      } else {
      }
    }
    </script>
    <script src="js/jquery.js"></script>
    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
