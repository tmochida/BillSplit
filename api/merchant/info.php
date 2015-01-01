<?php
require("../dbsetup.php");

$id = $_POST['merchant_id'];

$query = "SELECT merchant_name, wallet_addr FROM Merchants WHERE merchant_ID = '$id';";
$result = $db->query($query);

$returnArray = [
    'merchant_name' => '',
    'wallet_addr' => '',
    'merchant_id' => $id,
    'success' => false
];


if ($result->num_rows == 1) {
    $result_row = $result->fetch_object();
    $name = $result_row->merchant_name;
    $wallet_addr = $result_row->wallet_addr;
    $returnArray['merchant_name'] = $name;
    $returnArray['wallet_addr'] = $wallet_addr;
    $returnArray['success'] = true;
}

echo json_encode($returnArray, JSON_PRETTY_PRINT);

// Close db connection
$db->close();
?>
