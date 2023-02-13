<?php

$CardNumber = $_POST['CardNumber'];
$CardHolder  = $_POST['CardHolder'];
$exmonth = $_POST['exmonth'];
$exyear = $_POST['exyear'];
$CVV = $_POST['CVV'];




if (!empty($CardNumber) || !empty($CardHolder) || !empty($exmonth) || !empty($exyear) || !empty($CVV) )
{

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "creditcarddetails";




$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);

if (mysqli_connect_error()){
  die('Connect Error ('. mysqli_connect_errno() .') '
    . mysqli_connect_error());
}
else{
  $SELECT = "SELECT CVV From databasedetails Where CVV = ? Limit 1";
  $INSERT = "INSERT Into databasedetails (CardNumber , CardHolder ,exmonth, exyear,CVV )values(?,?,?,?,?)";


     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("i", $CVV);
     $stmt->execute();
     $stmt->bind_result($CVV);
     $stmt->store_result();
     $rnum = $stmt->num_rows;

     
      if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("sssss", $CardNumber,$CardHolder,$exmonth,$exyear,$CVV);
      $stmt->execute();
      echo "New record inserted sucessfully";
     } else {
      echo "Someone already register using this CVV";
     }
     $stmt->close();
     $conn->close();
    }
} else {
 echo "All field are required";
 die();
}
?>