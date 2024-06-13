<?php
$servername='localhost';
$username='root';
$password='';
$dbname = "savoy_db2024";
$conn=mysqli_connect($servername,$username,$password,"$dbname");
if(!$conn){
   die('Could not Connect My Sql:' .mysqli_error());
}
?>