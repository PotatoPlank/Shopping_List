<?php
require("mysqli.php");
require("functions.php");
if(!isset($_POST['name'])||$_POST['name']==''||$_POST['name']==' '){return;header("Location: " . redirecturl() ."/index.php");}
$name=$_POST['name'];
$sqlgroup="INSERT INTO shop_pgroups (name) VALUES ('$name')";
$result = db_query_update($sqlgroup);
if($result != true){echo 'died '.$result;}else{echo $result;}

header("Location: " . redirecturl() ."/index.php");
 ?>
