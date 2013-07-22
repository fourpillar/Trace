<?php

// Trace Sales application. Written by James Blackburn 2013.

require('header.php');

require('connect.php');
require('setUser.php');
require('functions.php');
require('setParams.php');
require('salesInput.php');

//Visible page starts here

if ($master_access_sales == '1' ){

echo '<div id="topBlock">

<div id="traceLogo"><a href="salesContacts.php"><img src="images/trace_sales_logo.png" /></a></div>';

//View Picker

        echo '<div id="viewPicker">Go back to <a href="sales.php">Trace Sales</a></div><br /><br /></div>';

//Include grid files

require('salesgridIntroducers.php');
require('salesgridClients.php');

//Include footer
require('footer.html');
}else{
echo 'Sorry, you do not have access to this page.';
}
?>