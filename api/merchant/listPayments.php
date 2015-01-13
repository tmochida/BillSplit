<?php
require("../dbsetup.php");
require("../functions.php");

$info = json_decode(file_get_contents('php://input'));

$returnArray = [
    'payments' => [],
    'success' => false
];

if(isset($info->merchant_ID)) {
    $merchant_ID = strip_tags(trim($info->merchant_ID));
    $returnArray['merchant_ID'] = $merchant_ID;
}

$merchant_ID = $db->real_escape_string($merchant_ID);

$query = "SELECT payment_ID, payment_amount, payment_complete FROM Payments WHERE merchant_ID = '$merchant_ID';";
$result = $db->query($query);

while ($row = $result->fetch_object()) {
    $payment = [
        'id' => $row->payment_ID,
        'amount' => $row->payment_amount,
        'complete' => $row->payment_complete
    ];
    array_push($returnArray['payments'], $payment);
}

// Close db connection
$db->close();

printJSON($returnArray);
?>
