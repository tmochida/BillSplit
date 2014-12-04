<?php
$host="localhost";
$user="billsplit";
$pass="ripple";
$dbname="billsplit";

// Open MySQL connection
$db=mysqli_connect($host, $user, $pass, $dbname);
if ($db->connect_error) {
  die('Connection failed: ' . $db->connect_error);
}

?>