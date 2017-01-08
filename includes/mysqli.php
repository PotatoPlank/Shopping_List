<?php
session_start();
function db_connect(){
$con = mysqli_connect('localhost', '', '', '');
return $con;
/* check connection */
if (!$con) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    return mysqli_connect_error;
    exit();
}
}

function db_addlist($qty, $name, $price, $aisle, $pgroup, $addby, $timeadd, $dateadd){
  $conn = db_connect();
  $updatequery =
  "INSERT INTO currentlist (qty, name, price, aisle, product_group, add_by, time_add, date_add) VALUES ('$qty','$name','$price','$aisle','$pgroup','$addby','$timeadd','$dateadd')";
//  $result = mysqli_query($con, "SELECT * FROM currentlist WHERE qty > '0' GROUP BY name");
  if ($conn->query($updatequery) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $updatequery . "<br>" . $conn->error;
}
  //return var_dump($result);
}

function db_remitem($id){
  $conn = db_connect();
  $updatequery =
  "DELETE FROM currentlist WHERE id=$id";
//  $result = mysqli_query($con, "SELECT * FROM currentlist WHERE qty > '0' GROUP BY name");
  if ($conn->query($updatequery) === TRUE) {
    echo "Record removed successfully";
} else {
    echo "Error: " . $updatequery . "<br>" . $conn->error;
}
  //return var_dump($result);
}

function db_updatelist($id, $qty, $name, $price, $aisle, $pgroup, $addby, $timeadd, $dateadd){
  $conn = db_connect();
  $newquery = "UPDATE currentlist
              SET id='$id',qty='$qty',name='$name',price='$price',aisle='$aisle',product_group='$pgroup',add_by='$addby',time_add='$timeadd',date_add='$dateadd'
               WHERE
                    id=$id";
                    if ($conn->query($newquery) === TRUE) {
                      echo "Record updated successfully";
                    } else {
                      echo "Error: " . $newquery . "<br>" . $conn->error;
                    }
}

function db_movetocart($id){
  $qty;
  $name;
  $price;
  $aisle;
  $pgroup;
  $addby;
  $timeadd;
  $dateadd;
  $conn = db_connect();
  $getvaluequery="SELECT * FROM currentlist WHERE id = $id ORDER BY aisle";
  $result = mysqli_query($conn, $getvaluequery);
  $rowcount = $result->num_rows;
  $i=0;
  while($row = $result->fetch_assoc()){
      $qty = $row['qty'];
      $name = $row['name'];
      $price = $row['price'];
      $aisle = $row['aisle'];
      $pgroup = $row['product_group'];
      $addby = $row['add_by'];
      $timeadd = $row['time_add'];
      $dateadd = $row['date_add'];
  }


  $removequery = "DELETE FROM currentlist WHERE id=$id";
  $insertquery = "INSERT INTO list_cart (qty, name, price, aisle, product_group, add_by, time_add, date_add) VALUES ('$qty','$name','$price','$aisle','$pgroup','$addby','$timeadd','$dateadd')";

                    if ($conn->query($insertquery) === TRUE) {
                      if ($conn->query($removequery) === TRUE) {
                        echo "Record moved to in cart successfully";
                      } else {
                        echo "Error: " . $removequery . "<br>" . $conn->error;
                      };
                    } else {
                      echo "Error: " . $insertquery . "<br>" . $conn->error;
                    }
}
function db_movetolist($id){
  $qty;
  $name;
  $price;
  $aisle;
  $pgroup;
  $addby;
  $timeadd;
  $dateadd;
  $conn = db_connect();
  $getvaluequery="SELECT * FROM list_cart WHERE id = $id ORDER BY aisle";
  $result = mysqli_query($conn, $getvaluequery);
  $rowcount = $result->num_rows;
  $i=0;
  while($row = $result->fetch_assoc()){
      $qty = $row['qty'];
      $name = $row['name'];
      $price = $row['price'];
      $aisle = $row['aisle'];
      $pgroup = $row['product_group'];
      $addby = $row['add_by'];
      $timeadd = $row['time_add'];
      $dateadd = $row['date_add'];
  }


  $removequery = "DELETE FROM list_cart WHERE id=$id";
  $insertquery = "INSERT INTO currentlist (qty, name, price, aisle, product_group, add_by, time_add, date_add) VALUES ('$qty','$name','$price','$aisle','$pgroup','$addby','$timeadd','$dateadd')";

                    if ($conn->query($insertquery) === TRUE) {
                      if ($conn->query($removequery) === TRUE) {
                        echo "Record moved to current list successfully";
                      } else {
                        echo "Error: " . $removequery . "<br>" . $conn->error;
                      };
                    } else {
                      echo "Error: " . $insertquery . "<br>" . $conn->error;
                    }
}

function db_nextid(){
  $conn = db_connect();
  $nextqry = "SELECT max(greatest(list_cart.id,currentlist.id)) + 1 as next_id FROM `list_cart`, currentlist";
  $result = mysqli_query($conn, $nextqry);
  $row = $result->fetch_assoc();
  if (isset($row['next_id'])){
    return $row['next_id'];
  }else{
    return 1;
  }
}

function reg_email($email){
  $conn = db_connect();
  $nextqry = "SELECT email FROM Users WHERE email='$email'";
  $result = mysqli_query($conn, $nextqry);
  $rowcount = $result->num_rows;
  if ($rowcount >0){
    return false;
  }else{
    return true;
  }
}

function reg_user($user){
  $conn = db_connect();
  $nextqry = "SELECT user FROM Users WHERE user='$user'";
  $result = mysqli_query($conn, $nextqry);
  $rowcount = $result->num_rows;
  if ($rowcount >0){
    return false;
  }else{
    return true;
  }
}

function reg_pass($pass){
  return true;
}
function register_qry($user,$pass,$email){
  $conn = db_connect();
  $newuserquery = "INSERT INTO Users(user,email,pass,usergroup) VALUES('$user','$email','$pass','1')";
//  $result = mysqli_query($con, "SELECT * FROM currentlist WHERE qty > '0' GROUP BY name");
  if ($conn->query($newuserquery) === TRUE) {
    echo "<center><b>You were successfully registered!</b></center>";
} else {
    echo "Error: " . $newuserquery . "<br>" . $conn->error;
}
}

function login_user($user,$pass){
  $conn = db_connect();
  $newuserquery = "SELECT user, pass, usergroup, name FROM Users WHERE user='$user'";
//  $result = mysqli_query($con, "SELECT * FROM currentlist WHERE qty > '0' GROUP BY name");
  $result = mysqli_query($conn, $newuserquery);
  $row = $result->fetch_assoc();
  if ($row['pass'] == $pass){
    $_SESSION['user'] = $row['user'];
    $_SESSION['usergroup'] = $row['usergroup'];
    $_SESSION['name'] = $row['name'];
    return true;
  }else{
    print '<center><b></b>Login failed</b></center>';
    return false;
  }
}

function createnewlist($listname){
  $todaydate = date('Y-m-d');
  $conn = db_connect();
  $createlistgrp = "INSERT INTO lists(name,list_date) VALUES('$listname','$todaydate')";
  $getlistid = "SELECT id FROM lists WHERE name='$listname' and list_date='$todaydate'";
  $getallitemscart = "SELECT * FROM `list_cart`";
  $getallitemslist = "SELECT * FROM currentlist";
  if ($conn->query($createlistgrp) === TRUE) {
} else {
    echo "Error: " . $createlistgrp . "<br>" . $conn->error;
}
$listidres = mysqli_query($conn, $getlistid);
$row_id = $listidres->fetch_assoc();
$list_id = $row_id['id'];

$resultcart = mysqli_query($conn, $getallitemscart);
$rowcount = $resultcart->num_rows;
if ($rowcount != 0){
while($row = $resultcart->fetch_assoc()){
    $itemid = $row['id'];
    $qty = $row['qty'];
    $name = $row['name'];
    $price = $row['price'];
    $aisle = $row['aisle'];
    $pgroup = $row['product_group'];
    $addby = $row['add_by'];
    $timeadd = $row['time_add'];
    $dateadd = $row['date_add'];
    $insertquery = "INSERT INTO list_details (id, list_id, qty, name, price, aisle, product_group, add_by, time_add, date_add) VALUES ('$itemid','$list_id' ,'$qty','$name','$price','$aisle','$pgroup','$addby','$timeadd','$dateadd')";
    $removequery = "DELETE FROM list_cart WHERE id=$itemid";
    if ($conn->query($insertquery) === TRUE) {
      if ($conn->query($removequery) === TRUE) {
        //good
      } else {
        exit();
      }
      //good
    } else {
      exit();
    }
}
}
$resultlist = mysqli_query($conn, $getallitemslist);
$rowcount = $resultlist->num_rows;
if ($rowcount != 0){
while($row = $resultlist->fetch_assoc()){
    $itemid = $row['id'];
    $qty = $row['qty'];
    $name = $row['name'];
    $price = $row['price'];
    $aisle = $row['aisle'];
    $pgroup = $row['product_group'];
    $addby = $row['add_by'];
    $timeadd = $row['time_add'];
    $dateadd = $row['date_add'];
    $insertquery = "INSERT INTO list_details (id, list_id, qty, name, price, aisle, product_group, add_by, time_add, date_add) VALUES ('$itemid','$list_id' ,'$qty','$name','$price','$aisle','$pgroup','$addby','$timeadd','$dateadd')";
    $removequery = "DELETE FROM currentlist WHERE id=$itemid";
    if ($conn->query($insertquery) === TRUE) {
      if ($conn->query($removequery) === TRUE) {
        //good
      } else {
        exit();
      }
      //good
    } else {
      exit();
    }
}
}
return true;
}
 ?>
