<?php
require("../dbconfig.php");

$acct = json_decode(file_get_contents('php://input'));
$acctType = $acct->acctType;
$username = $acct->username;
$password = $acct->password;
$wallet_addr = $acct->wallet_addr;
$email = $acct->email;
$merch_name = $acct->merch_name;

$returnArray = [
    'acctType' => $acctType,
    'username' => $username,
    'email' => $email,
    'wallet_addr' => $wallet_addr,
    'success' => false
];

if($acctType == 'merchant') {
    $returnArray['merch_name'] = $merch_name;
}

// Prepare salt and hash
$salt = uniqid('bs_usr_', true);
$options = [
    'salt' => $salt,
    'cost' => 14
];
$password = password_hash($password, PASSWORD_BCRYPT, $options);

if ($acctType == "user") {
    $query = "INSERT INTO Users (username, password, email, wallet_addr, salt) VALUES ('$username', '$password', '$email', '$wallet_addr', '$salt')";
}
else if ($acctType == "merchant") {
    $query = "INSERT INTO Merchants (username, password, email, wallet_addr, salt, merchant_name) VALUES ('$username', '$password', '$email', '$wallet_addr', '$salt', '$merch_name')";
}
else {
    $query = "";
}

if ($db->query($query) === TRUE) {
    $returnArray['success'] = true;
}

// Close db connection
$db->close();

print json_encode($returnArray, JSON_PRETTY_PRINT);
?>
