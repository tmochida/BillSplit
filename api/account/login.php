<?php
require("../config.php");
require("../functions.php");

$returnArray = [
    'success' => false
];

$acct = json_decode(file_get_contents('php://input'));

if(!isset($acct->acctType) || !isset($acct->username) || !isset($acct->password)) {
    printJSON($returnArray);
    return;
}

$acctType = strip_tags(trim($acct->acctType));
$username = strip_tags(trim($acct->username));
$password = strip_tags(trim($acct->password));

$returnArray['acctType'] = $acctType;
$returnArray['username'] = $username;

if ($acctType == "user") {
    $table_name = 'Users';
}
else if ($acctType == "merchant") {
    $table_name = 'Merchants';
}
else {
    $table_name = '';
}

$username = $db->real_escape_string($username);
$password = $db->real_escape_string($password);

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

printJSON($returnArray);
?>
