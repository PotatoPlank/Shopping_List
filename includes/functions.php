<?php
Function cleanup($input){
$input = strip_tags(trim($input));
$clean = htmlspecialchars($input);
return $clean;
}

Function redirecturl(){
  if($_SERVER['HTTP_HOST'] == 'localhost'){
    return 'http://localhost/shopping_list';
  }else{
    return 'http://shop.sugarbombed.com';
  }
}
Function prodortest(){
  if($_SERVER['HTTP_HOST'] == 'localhost'){
    return 'test';
  }else{
    return 'live';
  }
}

Function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
Function logout() {
unset($_SESSION['user']);
session_unset();
session_destroy();
unset($_SESSION['usergroup']);
header("Location: " . redirecturl() ."/welcome.php");
}
Function nav_check(){
  if(deny()!=false){
    require_once('mysqli.php');
    //return deny();
    exit(deny() . '<br /><a href="index.php?logout=y">Logout</a>');
  }
  if (isMobile()){
    $_SESSION['mobile'] = true;
  }else{
    $_SESSION['mobile'] = false;
  }
  if (!isset($_SESSION['user']) or $_SESSION['user']==''){
    header("Location: " . redirecturl() ."/welcome.php");
  }
}
Function build_footer(){
  if ($_SESSION['usergroup'] == '99'){
    echo '<a href="portal/admin.php" class="navbar-btn btn-danger btn pull-right"><span class="glyphicon glyphicon-star"></span>*Admin Panel*</a>   ';
    echo '<a href="mobile.php" class="navbar-btn btn-danger btn pull-right"><span class="glyphicon glyphicon-star"></span>*Mobile*</a>   ';
  }
  if (ismobile()){
    echo '<a href="index.php?desktop=y" class="navbar-btn btn-danger btn pull-right"><span class="glyphicon glyphicon-star"></span>Desktop</a>   ';
  }
}
 ?>
