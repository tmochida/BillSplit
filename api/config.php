<?php
// Configures database connections and ripple hot wallet address.
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

// Ripple wallet config
$hot_wallet="raMTQhyX2X9JkoGxZ8LBagrBLnTUSMvfgQ";
?>
