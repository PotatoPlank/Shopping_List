<?php
function dbconf(){
  if (isproduction() == true){
    //live url
    $dburl = 'url';
    $dbusername = 'db user';
    $dbname = 'db name';
    $dbpassword = 'password to db';
  }else{
    //test server
    $dburl = 'url';
    $dbusername = 'db user';
    $dbname = 'db name';
    $dbpassword = 'password to db';
  }

    return array($dburl,$dbusername,$dbpassword,$dbname);
}
function isproduction(){
  if($_SERVER['HTTP_HOST'] != 'localhost'){
    return true;
  }else{
    return false;
  }
}
date_default_timezone_set('America/New_York');
$date = date('m/d/Y', time());
$sqldate = date('Y-m-d',time());
$listcount =0;
$currtime = date('H:i:s', time());
 ?>
