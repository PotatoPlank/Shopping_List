<?php
function db_connect(){
$con = mysqli_connect('localhost', '***REMOVED***', '***REMOVED***', '***REMOVED***');
return $con;
/* check connection */
if (!$con) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    return mysqli_connect_error;
    exit();
}
}

function db_addlist($id, $qty, $name, $price, $aisle, $pgroup, $addby, $timeadd, $dateadd){
  $conn = db_connect();
  $updatequery =
  "INSERT INTO currentlist (id, qty, name, price, aisle, product_group, add_by, time_add, date_add) VALUES ('$id','$qty','$name','$price','$aisle','$pgroup','$addby','$timeadd','$dateadd')";
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
  $insertquery = "INSERT INTO list_cart (id, qty, name, price, aisle, product_group, add_by, time_add, date_add) VALUES ('$id','$qty','$name','$price','$aisle','$pgroup','$addby','$timeadd','$dateadd')";

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
  $insertquery = "INSERT INTO currentlist (id, qty, name, price, aisle, product_group, add_by, time_add, date_add) VALUES ('$id','$qty','$name','$price','$aisle','$pgroup','$addby','$timeadd','$dateadd')";

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
 ?>
