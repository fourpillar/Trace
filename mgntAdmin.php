<?php

// Trace Management application. Written by James Blackburn 2013.

require('header.php');

require('connect.php');
require('setUser.php');
require('functions.php');
require('setParams.php');
require('input.php');


//Visible page starts here

echo '<div id="topBlock">

<div id="traceLogo"><a href="mgntAdmin.php"><img src="images/trace_mgnt_logo.png" /></a><br /></div>';

echo '<div id="viewPicker">

Go back to <a href="mgnt.php">Trace Management</a>

</div></div>';


//Include grid files
require ('gridUsers.php');

//echo '<br /><strong>Management System Staff Tree</strong><br />';
//
//$tree1 = mysql_query("SELECT trace_user_id, username FROM xadmin_user WHERE tier=1 ");
//$tree2 = mysql_query("SELECT trace_user_id, username, manager FROM xadmin_user WHERE tier=2 ");
//$tree3 = mysql_query("SELECT trace_user_id, username, manager FROM xadmin_user WHERE tier=3 ");
//
//while ($row1 = mysql_fetch_array($tree1)) {
//    echo $row1['username']; echo '<br />';
//    while($row2 = mysql_fetch_array($tree2)) {
//        if ($row2['manager'] == $row1['trace_user_id']){
//            echo '_'; echo $row2['username']; echo '<br />';
//        }
//        while($row3 = mysql_fetch_array($tree3)) {
//        if ($row3['manager'] == $row2['trace_user_id']){
//            echo '___'; echo $row3['username']; echo '<br />';
//        }
//      }
//    }
//}

//Include footer
require('footer.html');
?>

