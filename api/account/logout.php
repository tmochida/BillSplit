<?php
require("../functions.php");

session_id('uid');
session_start();
session_unset();
session_destroy();

$returnArray = [
    'success' => false
];

if ( session_status() === PHP_SESSION_NONE) {
    $returnArray['success'] = true;
}

printJSON($returnArray);
?>
