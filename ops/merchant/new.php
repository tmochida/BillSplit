<?php
require("../dbsetup.php");

$acct = json_decode(file_get_contents('php://input'));
$username = $acct->username;
$password = $acct->password;
$wallet_addr = $acct->wallet_addr;
$email = $acct->email;
$merchant_name = $acct->merchant_name;

$returnArray = [
    'username' => $username,
    'email' => $email,
    'wallet_addr' => $wallet_addr,
    'merchant_name' => $merchant_name,
    'merchant_ID' => '-1',
    'success' => false
];

// Prepare salt and hash
$salt = uniqid('bs_usr_', true);
$options = [
    'salt' => $salt,
    'cost' => 14
];
$password = password_hash($password, PASSWORD_BCRYPT, $options);

$query = "INSERT INTO Merchants (username, password, email, wallet_addr, salt, merchant_name) VALUES ('$username', '$password', '$email', '$wallet_addr', '$salt', '$merchant_name')";

if ($db->query($query) === TRUE) {
    $query = "SELECT Merchant_ID FROM Merchants WHERE username = '$username'";
    $result = $db->query($query);
    if ($result->num_rows == 1) {
        $result_row = $result->fetch_object();
        $returnArray['merchant_ID'] = $result_row->Merchant_ID;
        $returnArray['success'] = true;
    }
}

// Close db connection
$db->close();

print json_encode($returnArray, JSON_PRETTY_PRINT);
?>