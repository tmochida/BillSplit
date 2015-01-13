<?php
require("../dbconfig.php");

$user = json_decode(file_get_contents('php://input'));
$acctType = $user->acctType;
$username = $user->username;
$password = $user->password;

$returnArray = [
    'acctType' => $acctType,
    'username' => $username,
    'email' => "",
    'wallet_addr' => "",
    'uid' => "",
    'success' => false
];

if ($acctType == "user") {
    $table_name = 'Users';
}
else if ($acctType == "merchant") {
    $table_name = 'Merchants';
}
else {
    $table_name = '';
}

if (!empty($table_name)) {
    $query = "SELECT username, password, email, wallet_addr FROM " . $table_name . " WHERE username = '$username';";
    $result = $db->query($query);
    
    if ($result->num_rows == 1) {
        $result_row = $result->fetch_object();
        if (password_verify($password, $result_row->password)) {
            session_start();
            $_SESSION['uid'] = uniqid('bs_');
            $returnArray['uid'] = $_SESSION['uid'];
            $returnArray['email'] = $result_row->email;
            $returnArray['wallet_addr'] = $result_row->wallet_addr;
            $returnArray['success'] = true;
        }
    }
}

// Close db connection
$db->close();

print json_encode($returnArray, JSON_PRETTY_PRINT);
?>
