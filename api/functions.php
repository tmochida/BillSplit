<?php
// functions that will be used by API code

// returns JSON data to client
function printJSON($array) {
    print json_encode($array, JSON_PRETTY_PRINT);
}


?>
