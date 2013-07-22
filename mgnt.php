<?php

// Trace Management application. Written by James Blackburn 2013.
        
require('header.php');

require('connect.php');
require('setUser.php');
require('processpdf.php');
require('functions.php');
require ('input.php');
require ('upload.php');
require ('setParams.php');
require ('buildHistory.php');

//Visible page starts here
//echo $_SESSION['mode'];
echo '<div id="topBlock">';

echo '
   

<div id="traceLogo"><a href="mgnt.php"><img src="images/trace_mgnt_logo.png" /></a></div>

<div id="warningSummary">
<div id="todo_red_counter" class="warningCounter"><a href="#todo-grid" style="color:green;">Tasks: </a> <img src="images/red_icon.png" /> </div>
<div id="todo_amber_counter" class="warningCounter"> <img src="images/orange_icon.png" /> </div>
<div id="todo_green_counter" class="warningCounter"> <img src="images/green_icon.png" /> </div>
<br />
<div id="COT_red_counter" class="warningCounter"><a href="#COT-grid" style="color:green;">COT: </a> <img src="images/red_icon.png" /> </div>
<div id="COT_amber_counter" class="warningCounter"> <img src="images/orange_icon.png" /> </div>
<div id="COT_green_counter" class="warningCounter"> <img src="images/green_icon.png" /> </div>
<br />
<div id="LOA_red_counter" class="warningCounter"><a href="#LOA-grid" style="color:green;">LOA: </a> <img src="images/red_icon.png" /> </div>
<div id="LOA_amber_counter" class="warningCounter"> <img src="images/orange_icon.png" /> </div>
<div id="LOA_green_counter" class="warningCounter"> <img src="images/green_icon.png" /> </div>
<br />
<div id="NOT_red_counter" class="warningCounter"><a href="#NOT-grid" style="color:green;">NOT: </a> <img src="images/red_icon.png" /> </div>
<div id="NOT_amber_counter" class="warningCounter"> <img src="images/orange_icon.png" /> </div>
<div id="NOT_green_counter" class="warningCounter"> <img src="images/green_icon.png" /> </div>
<br />
</div>
<div id="warningSummary2">
<div id="invoicing_red_counter" class="warningCounter"><a href="#invoicing-grid" style="color:green;">Invoicing: </a> <img src="images/red_icon.png" /> </div>
<div id="invoicing_amber_counter" class="warningCounter"> <img src="images/orange_icon.png" /> </div>
<div id="invoicing_green_counter" class="warningCounter"> <img src="images/green_icon.png" /> </div>
<br />
<div id="procurement_red_counter" class="warningCounter"><a href="#procurement-grid" style="color:green;">Procurement: </a> <img src="images/red_icon.png" /> </div>
<div id="procurement_amber_counter" class="warningCounter"> <img src="images/orange_icon.png" /> </div>
<div id="procurement_green_counter" class="warningCounter"> <img src="images/green_icon.png" /> </div>
<br />
<div id="procurement_conf_red_counter" class="warningCounter"><a href="#procurementconf-grid" style="color:green;">Proc. Conf.: </a> <img src="images/red_icon.png" /> </div>
<div id="procurement_conf_amber_counter" class="warningCounter"> <img src="images/orange_icon.png" /> </div>
<div id="procurement_conf_green_counter" class="warningCounter"> <img src="images/green_icon.png" /> </div>
</div>';


//View Picker

if ($master_tier == '1'){
        $get_staff = mysql_query("SELECT trace_user_id, username FROM xadmin_user WHERE tier!=1");
}else if ($master_tier == '2'){
    $get_staff = mysql_query("SELECT trace_user_id, username FROM xadmin_user WHERE manager=$master_user_id");
}
    

       // $staff=array("Select","Alex Hill","Joe Warren","John Smith");

        echo '<div id="viewPicker"><form action="simulation.php?form=simulateview" method="post">';

        if ($master_tier == '1'){
        echo '<a href="mgntAdmin.php">Admin</a> | ';}
        
        echo '<a href="mgntArchive.php">Archive</a> | ';
        
        if ($master_access_sales == '1'){
        echo '<a href="sales.php">Trace Sales</a> | ';}

        if ($master_tier == '1' or $master_tier == '2'){
        echo '<i>'; if ($_SESSION['mode']=='sim'){ echo 'Simulating ';}else {echo 'Viewing ';} echo 'as</i> <strong>'; if ($_SESSION['mode'] == 'sim'){echo $_SESSION['sim_username'];}else{echo $master_username;} echo '</strong> | View as
            <select name="id">';

//        foreach ($staff as $person){
//        echo '<option value="'; echo $person; echo '">'; echo $person; echo '</option>';
//                  }
        echo '<option value="">Select</option>';
        echo '<option name="id" value="'; echo $master_user_id; echo '">Me</option>';
    while ($row = mysql_fetch_array($get_staff)) {
        echo '<option name="id" value="'; echo $row['trace_user_id']; echo '">'; echo $row['username']; echo '</option>';
    }
 
    echo '</select>
        <input type="hidden" name="username" value="'; echo $row['username']; echo'" ><input type="submit" value="Go" label="Go"></form>';}echo '<a href="logout.php">Logout</a>';

        

        echo' </div><br /><br /></div>';

//Include grid files
require ('gridTodo.php');
require ('gridCOT.php');
require ('gridLOA.php');
require ('gridNOT.php');
require ('gridInvoice.php');
require ('gridProcurement.php');
require ('gridProcurementConf.php');


//Include footer
require('footer.html');
?>

