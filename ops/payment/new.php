<?php
require("../dbsetup.php");

$payment = json_decode(file_get_contents('php://input'));
$merchant_ID = $payment->merchant_ID;
$amount = $payment->amount;
$unique_id = uniqid("pymnts_", true);


$returnArray = [
    'payment_ID' => -1,
    'merchant_ID' => $merchant_ID,
    'amount' => $amount,
    'success' => false
];

$query = "INSERT INTO Payments (merchant_ID, payment_amount, payment_unique_id) VALUES ('$merchant_ID', '$amount', '$unique_id')";

if ($db->query($query) === TRUE) {
    $query = "SELECT payment_ID FROM Payments WHERE merchant_ID = '$merchant_ID' AND payment_amount = '$amount' AND payment_unique_id = '$unique_id' ORDER BY payment_ID DESC";
    $result = $db->query($query);
    if ($result->num_rows > 0) {
        $result_row = $result->fetch_object();
        $returnArray['payment_ID'] = $result_row->payment_ID;
        $returnArray['success'] = true;
    }
}

// Close db connection
$db->close();

print json_encode($returnArray, JSON_PRETTY_PRINT);
?>