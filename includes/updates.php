<?php
session_start();
ob_start();
require("mysqli.php");
require("functions.php");
$id = $_GET['id'];
$qty = $_GET['qty'];
$name = $_GET['name'];
$price = $_GET['price'];
$aisle = $_GET['aisle'];
$pgroup = $_GET['group'];
$addby = $_GET['addby'];
$timeadd = $_GET['time'];
$dateadd = $_GET['date'];
$ismobile = $_SESSION['mobile'];
//DELETE ITEM FROM LIST
if ($_GET['function'] == 'delete'){
  if ($_GET['list'] == 'current'){
    db_remitem($id);
  }else{
    //Later
  }
  if($ismobile==false){
  header("Location: " . redirecturl() ."/index.php");
  }else{
  header("Location: " . redirecturl() ."/mobile.php");
  }
}

//ADD ITEM TO CART
if ($_GET['function'] == 'addtocart'){
  if ($_GET['list'] == 'current'){
    db_movetocart($id);
  }elseif($_GET['list'] == 'cart'){
    db_movetolist($id);
  }
  if($ismobile==false){
  header("Location: " . redirecturl() ."/index.php");
  }else{
  header("Location: " . redirecturl() ."/mobile.php");
  }
}

//EDIT ITEM
if ($_GET['edit'] == 'Save'){
    db_updatelist($id, $qty, $name, $price, $aisle, $pgroup, $addby, $timeadd, $dateadd);
  }else{
    //Later
  }
  if($ismobile==false){
 header("Location: " . redirecturl() ."/index.php");
}else{
  header("Location: " . redirecturl() ."/mobile.php");
}

?>
