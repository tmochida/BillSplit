<?php

$returnArray = [
    'success' => false
];

session_start();
if( isset($_SESSION['uid'])) {
    $returnArray['success'] = true;
}
print json_encode($returnArray, JSON_PRETTY_PRINT);
?>
