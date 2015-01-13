<?php
// Configures database connections.
// Used by /api PHP code

$dbhost="localhost";
$dbname="billsplit";
$dbuser="billsplit";
$dbpass="ripple";

// Open MySQL connection
$db=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if ($db->connect_error) {
  die('Connection failed: ' . $db->connect_error);
}

?>
