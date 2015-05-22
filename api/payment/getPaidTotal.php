<?php
require("../config.php");
require("../functions.php");

$returnArray = [
    'success' => false
];

$payment = json_decode(file_get_contents('php://input'));

if(!isset($payment->payment_ID)) {
    printJSON($returnArray);
    return;
}

$payment_ID = strip_tags(trim($payment->payment_ID));

$returnArray['payment_ID'] = $merchant_ID;

$paid_total = 0;

$paymentListUrl = "https://api.ripple.com/v1/accounts/" . $hot_wallet . "/payments?destination_account=" . $hot_wallet;



$merchant_ID = $db->real_escape_string($merchant_ID);
$amount = $db->real_escape_string($amount);

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

printJSON($returnArray);
?>
