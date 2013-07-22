<?php

$db_host = 'zerotrace.tridan.it';
$db_username = 'mgmt';
$db_password = 'UkdP~6}7|W1Xk|2A[1bx&!W.,';
$db_name = 'zero_trace';


//ini_set('display_errors', 1);
$link = mysql_connect($db_host, $db_username, $db_password);
//$link = mysqli_connect('localhost', 'mgmt', 'UkdP~6}7|W1Xk|2A[1bx&!W.,');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

//$db_selected = mysql_select_db('zero_trace', $link);
$db_selected = mysql_select_db($db_name);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}
?>
