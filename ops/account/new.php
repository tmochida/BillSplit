<?php
require("../dbsetup.php");

$acct = json_decode(file_get_contents('php://input'));
$username = $acct->username;
$password = $acct->password;
$wallet_addr = $acct->wallet_addr;
$email = $acct->email;

$returnArray = [
    'username' => $username,
    'email' => $email,
    'wallet_addr' => $wallet_addr,
    'success' => false
];

// Prepare salt and hash
$salt = uniqid('bs_usr_', true);
$options = [
    'salt' => $salt,
    'cost' => 14
];
$password = password_hash($password, PASSWORD_BCRYPT, $options);


$query = "INSERT INTO Users (username, password, email, wallet_addr, salt) VALUES ('$username', '$password', '$email', '$wallet_addr', '$salt')";

if ($db->query($query) === TRUE) {
    $returnArray['success'] = true;
}

// Close db connection
$db->close();

print json_encode($returnArray, JSON_PRETTY_PRINT);
?>