<?php

// Trace Sales application. Written by James Blackburn 2013.

require('header.php');

require('connect.php');
require('setUser.php');
require('functions.php');
require('setParams.php');
require('salesInput.php');

if ($master_access_sales == '1' ){

$mode = $_GET['mode'];

//Visible page starts here

echo '<div id="topBlock">

<div id="traceLogo"><a href="sales.php"><img src="images/trace_sales_logo.png" /></a></div>';

//View Picker

        echo '<div id="viewPicker">';
        if ($mode != 'archive'){
        echo '<a href="sales.php?mode=archive">Sales Archive</a> | ';
        }else{
        echo '<a href="sales.php">Exit Archive</a> | ';
        }
        echo 'Go to <a href="salesContacts.php">Sales Contact Manager</a> |  ';

        echo 'Go to <a href="mgnt.php">Trace Management</a></div><br /><br /></div>';

//Include grid files

require('salesgridTask.php');
require('salesgridOpp.php');

//Include footer
require('footer.html');
}else{
echo 'Sorry, you do not have access to this page.';
}
?>