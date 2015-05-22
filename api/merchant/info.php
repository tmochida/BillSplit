<?php
require("../config.php");
require("../functions.php");

$info = json_decode(file_get_contents('php://input'));

$returnArray = [
    'success' => false
];

if(isset($info->merchant_ID)) {
    $merchant_ID = strip_tags(trim($info->merchant_ID));
    $returnArray['merchant_ID'] = $merchant_ID;

    $merchant_ID = $db->real_escape_string($merchant_ID);
    $query = "SELECT merchant_name, wallet_addr FROM Merchants WHERE merchant_ID = '$merchant_id';";
    $result = $db->query($query);
    if ($result->num_rows == 1) {
        $result_row = $result->fetch_object();
        $name = $result_row->merchant_name;
        $wallet_addr = $result_row->wallet_addr;
        $returnArray['merchant_name'] = $name;
        $returnArray['wallet_addr'] = $wallet_addr;
        $returnArray['success'] = true;
    }
}

// Close db connection
$db->close();

printJSON($returnArray);
?>
