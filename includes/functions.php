<?php
  session_start();
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
function prodortest(){
  if($_SERVER['HTTP_HOST'] == 'localhost'){
    return 'test';
  }else{
    return 'live';
  }
}

function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
function logout() {
unset($_SESSION['user']);
session_unset();
session_destroy();
unset($_SESSION['usergroup']);
}
 ?>
