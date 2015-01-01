<?php
require("../dbsetup.php");

//$info = json_decode(file_get_contents('php://input'));
//$merchant_ID = $user->merchant_ID;
$merchant_ID = 1;

$returnArray = [
    'merchant_ID' => $merchant_ID,
    'payments' => [],
];

$query = "SELECT payment_ID, payment_amount, payment_complete FROM Payments WHERE merchant_ID = '$merchant_ID';";
$result = $db->query($query);

while ($row = $result->fetch_object()) {
    $payment = array($row->payment_ID, $row->payment_amount, $row->payment_complete);
    array_push($returnArray['payments'], $payment);
}

// Close db connection
$db->close();

print json_encode($returnArray, JSON_PRETTY_PRINT);
?>