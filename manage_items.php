<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<?php
require("includes/mysqli.php");
require("includes/functions.php");
if (!isset($_SESSION['user']) or $_SESSION['user']==''){
  header("Location: " . redirecturl() ."/welcome.php");
}
$platform='';
 ?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">
    <meta name="author" content="">
    <title>Manage Items</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/stylesheet.css" rel="stylesheet">
    <style>
    </style>
</head>
<body>
    <div class="navbar navbar-inverse">
      <div class="navbar-inner">
        <a class="brand" href="#">Shopping List</a>
        <ul class="nav">
          <li class="active"><a href="index.php">Home</a></li>
          <li><a href="cart.php">Manage Cart</a></li>
        </ul>
      </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="">
              <h1>Manage Items</h1>
              <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  Dropdown
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="#">Separated link</a></li>
                </ul>
              </div>
              <?php
              $sqlStores = "SELECT * FROM stores";
              $result = db_query($sqlStores);
              if($result != true){echo $result;}
              while ($row=$result->fetch_assoc()) {

              }
               ?>
               <div id="newItem" class="modal hide fade" role="dialog">
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

    <script src="js/jquery.js"></script>
    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
