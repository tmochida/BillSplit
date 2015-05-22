<?php
require("../config.php");
require("../functions.php");

$returnArray = [
    'success' => false
];

$acct = json_decode(file_get_contents('php://input'));

if(!isset($acct->acctType) || !isset($acct->username) || !isset($acct->password) || !isset($acct->wallet_addr) || !isset($acct->email)) {
    printJSON($returnArray);
    return;
}

$acctType = strip_tags(trim($acct->acctType));
$username = strip_tags(trim($acct->username));
$password = strip_tags(trim($acct->password));
$wallet_addr = strip_tags(trim($acct->wallet_addr));
$email = trim($acct->email);

$returnArray['acctType'] = $acctType;
$returnArray['username'] = $username;
$returnArray['wallet_addr'] = $wallet_addr;
$returnArray['email'] = $email;

if($acctType == 'merchant') {
    if(!isset($acct->merch_name)) {
        printJSON($returnArray);
        return;
    } else {
        $merch_name = strip_tags(trim($acct->merch_name));
        $returnArray['merch_name'] = $merch_name;
    }
}

// Prepare salt and hash
$salt = uniqid('bs_', true);
$options = [
    'salt' => $salt,
    'cost' => 14
];
$password = password_hash($password, PASSWORD_BCRYPT, $options);

$username = $db->real_escape_string($username);
$password = $db->real_escape_string($password);
$email = $db->real_escape_string($email);
$wallet_addr = $db->real_escape_string($wallet_addr);
if(isset($merch_name)) {
    $merch_name = $db->real_escape_string($merch_name);
}

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

printJSON($returnArray);
?>
