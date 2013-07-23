<?php

//require('header.php');

require('connect.php');

//$host="localhost"; // Host name
//$username=""; // Mysql username
//$password=""; // Mysql password
//$db_name="test"; // Database name
//$tbl_name="xadmin_user"; // Table name
$tbl_name="xadmin_user"; // Table name

// Connect to server and select databse.
//mysql_connect("$host", "$username", "$password")or die("cannot connect");
//mysql_select_db("$db_name")or die("cannot select DB");

// username and password sent from form
$myusername=$_POST['myusername'];
$mypassword=$_POST['mypassword'];

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$encrypted_mypassword=md5($mypassword);

$sql="SELECT * FROM $tbl_name WHERE email='$myusername' and password='$encrypted_mypassword'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);

while ($row = mysql_fetch_array($result)) {
    $myuserid = $row['trace_user_id'];
    $realusername = $row['username'];
}

// If result matched $myusername and $mypassword, table row must be 1 row

if($count==1){


//session_save_path('Applications/MAMP/htdocs/Trace/sessions');

//session_save_path('/home/mgmt/httpdocs/sessions');

session_start();

// Register $myusername, $mypassword and redirect to file "login_success.php"
//session_register("myusername");
//session_register("mypassword");
$_SESSION['myusername'] = $realusername;
//$_SESSION['mypassword'] = $mypassword;

//$_SESSION['myusername'] = 'AlexHill';

//and trace_user_id
//session_register("myuserid");

$_SESSION['myuserid'] = $myuserid;
//$_SESSION['myuserid'] = '2';
header("location:mgnt.php");
}
else {
echo 'Wrong Username or Password. <a href="index.php">Try Again</a>';
}

//require('footer.php');
?>
