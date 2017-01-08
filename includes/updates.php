<?php
session_start();
ob_start();
require("mysqli.php");
$id = $_GET['id'];
$qty = $_GET['qty'];
$name = $_GET['name'];
$price = $_GET['price'];
$aisle = $_GET['aisle'];
$pgroup = $_GET['group'];
$addby = $_GET['addby'];
$timeadd = $_GET['time'];
$dateadd = $_GET['date'];
$viewtype = $_GET['view'];
//DELETE ITEM FROM LIST
if ($_GET['function'] == 'delete'){
  if ($_GET['list'] == 'current'){
    db_remitem($id);
  }else{
    //Later
  }
  if($viewtype!='mobile'){
  header("Location: http://shop.sugarbombed.com/index.php");
  }else{
  header("Location: http://shop.sugarbombed.com/mobile.php");
  }
}

//ADD ITEM TO CART
if ($_GET['function'] == 'addtocart'){
  if ($_GET['list'] == 'current'){
    db_movetocart($id);
  }elseif($_GET['list'] == 'cart'){
    db_movetolist($id);
  }
  if($viewtype!='mobile'){
  header("Location: http://shop.sugarbombed.com/index.php");
  }else{
  header("Location: http://shop.sugarbombed.com/mobile.php");
  }
}

//EDIT ITEM
if ($_GET['edit'] == 'Save'){
    db_updatelist($id, $qty, $name, $price, $aisle, $pgroup, $addby, $timeadd, $dateadd);
  }else{
    //Later
  }
  if($viewtype!='mobile'){
header("Location: http://shop.sugarbombed.com/index.php");
}else{
  header("Location: http://shop.sugarbombed.com/mobile.php");
}

?>
