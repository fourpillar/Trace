<?php

function cell ($rowname)
{
    echo '<td>' . $rowname . '</td>';
}


function historyType ($eventtype){
    if($eventtype=='0'){
        echo ' <strong>marked not sent (supplier)</strong> on ';
    }
    if($eventtype=='1'){
        echo ' <strong>marked sent (supplier)</strong> on ';
    }
    if($eventtype=='3'){
        echo ' <strong>uploaded a document</strong> on ';
    }
    if($eventtype=='4'){
        echo ' <strong>edited notes</strong> on ';
    }
    if($eventtype=='5'){
        echo ' <strong>downloaded template</strong> on ';
    }
    if($eventtype=='6'){
        echo ' <strong>deleted a document</strong> on ';
    }
        if($eventtype=='7'){
        echo ' <strong>marked not sent (client)</strong> on ';
    }
        if($eventtype=='8'){
        echo ' <strong>marked sent (client)</strong> on ';
    }
}

function days_until($date){
    return (isset($date)) ? floor((strtotime($date) - time())/60/60/24) : FALSE;
}

function opportunityStage ($stage){
    if($stage=='1'){
        echo 'No Contact';
    }
    if($stage=='2'){
        echo 'Closed. No interest';
    }
    if($stage=='3'){
        echo 'Interested';
    }
    if($stage=='4'){
        echo 'Had meeting';
    }
    if($stage=='5'){
        echo 'Trial';
    }
    if($stage=='6'){
        echo 'Proposal sent';
    }
    if($stage=='7'){
        echo 'Follow up';
    }
    if($stage=='8'){
        echo 'Agreed in principle';
    }
    if($stage=='9'){
        echo 'Contract negotiation';
    }
    if($stage=='10'){
        echo 'Close - Won';
    }
}



function sectorName ($value){

   $sector = mysql_query("SELECT id, value FROM xsales_data WHERE type=1 ORDER BY value ASC") or die ('Error: '.mysql_error ());

   while($row = mysql_fetch_array($sector)){
            $sector2[] = array("id"=>$row['id'],"value"=>$row['value']);
            }

    foreach ($sector2 as $sectorname){
        if ($sectorname['id'] == $value){
            echo $sectorname['value'];
        }
    }

}

function listSector ($value){

   $sector = mysql_query("SELECT id, value FROM xsales_data WHERE type=1 ORDER BY value ASC") or die ('Error: '.mysql_error ());

   while($row = mysql_fetch_array($sector)){
            $sector2[] = array("id"=>$row['id'],"value"=>$row['value']);
            }

   foreach ($sector2 as $sectorname){
       echo '<option'.($sectorname['id']==$value? ' selected' : '').' value='.$sectorname['id'].'>'; echo $sectorname['value']; echo '</option>';
       //echo '<option value="'; echo $sectorname['id']; echo '">'; echo $sectorname['value']; echo '</option>';
       }
}

function introducerName ($value){

   $query = mysql_query("SELECT id, name FROM xsales_introducer WHERE active=1 ORDER BY name ASC") or die ('Error: '.mysql_error ());

   while($row = mysql_fetch_array($query)){
            $introducer[] = array("id"=>$row['id'],"value"=>$row['name']);
            }

    foreach ($introducer as $introducername){
        if ($introducername['id'] == $value){
            echo $introducername['value'];
        }
    }

}

function listIntroducer ($value){

   $query = mysql_query("SELECT id, name FROM xsales_introducer WHERE active=1 ORDER BY name ASC") or die ('Error: '.mysql_error ());

   while($row = mysql_fetch_array($query)){
            $introducer[] = array("id"=>$row['id'],"value"=>$row['name']);
            }

   foreach ($introducer as $introducername){
       echo '<option'.($introducername['id']==$value? ' selected' : '').' value='.$introducername['id'].'>'; echo $introducername['value']; echo '</option>';
       //echo '<option value="'; echo $sectorname['id']; echo '">'; echo $sectorname['value']; echo '</option>';
       }
}

function dateCountdown($value, $type){

    if (isset ($value)){
        
        $date1 = new DateTime($value);
        $date2 = new DateTime($today);

            $diff = $date2->diff($date1)->format("%a");
            
    if ($type == 'COT' || $type == 'LOA' || $type == 'proc'){
        if ($date2 > $date1){
            echo'-';
        }echo $diff;
     }
    
            
   if ($type == 'NOT'){
        if ($date2 > $date1){
            echo'-';
        }echo $diff - 30;
     }
            
   }
}
   
function setWarning($date, $ambercount, $grid){

    $now = strtotime("-0 days");
    $amber_date = strtotime("-$ambercount days", strtotime($date));
    
    $red_date = strtotime("+5 days", strtotime($date));

    if ($grid == 'todo'){
        if ($now <= strtotime($date) && $now >= $amber_date){
        echo '<div class="'; echo $grid; echo'_amber_warning" title="Due within 7 days"><img src="images/orange_icon.png" /></div>';
        } else if ($now >= strtotime($date)){
        echo '<div class="'; echo $grid; echo'_red_warning" title="Overdue"><img src="images/red_icon.png" /></div>';
        } else {
            echo '<div class="'; echo $grid; echo'_green_warning"></div>';
        }
    }
    
        if ($grid == 'COT'){
        if ($now <= $red_date && $now >= $amber_date){
        echo '<div class="'; echo $grid; echo'_amber_warning" title="Within 10 days prior / 5 days following handover"><img src="images/orange_icon.png" /></div>';
        } else if ($now >= $red_date){
        echo '<div class="'; echo $grid; echo'_red_warning" title="Overdue (More than 5 days after handover)"><img src="images/red_icon.png" /></div>';
        } else {
            echo '<div class="'; echo $grid; echo'_green_warning"></div>';
        }
    }
    
//        if ($grid = 'LOA'){
//        if ($now <= strtotime($date) && $now >= $amber_date){
//        echo '<div class="'; echo $grid; echo'_amber_warning" title="Task older than 14 days"><img src="images/orange_icon.png" /></div>';
//        } else if ($now >= strtotime($date)){
//        echo '<div class="'; echo $grid; echo'_red_warning" title="Task older than 28 days"><img src="images/red_icon.png" /></div>';
//        } else {
//            echo '<div class="'; echo $grid; echo'_green_warning"></div>';
//        }
//    }
//    
//        if ($grid = 'NOT'){
//        if ($now <= strtotime($date) && $now >= $amber_date){
//        echo '<div class="'; echo $grid; echo'_amber_warning" title="Task older than 7 days"><img src="images/orange_icon.png" /></div>';
//        } else if ($now >= strtotime($date)){
//        echo '<div class="'; echo $grid; echo'_red_warning" title="Task older than 14 days"><img src="images/red_icon.png" /></div>';
//        } else {
//            echo '<div class="'; echo $grid; echo'_green_warning"></div>';
//        }
//    }
//    
//        if ($grid = 'invoicing'){
//        if ($now <= strtotime($date) && $now >= $amber_date){
//        echo '<div class="'; echo $grid; echo'_amber_warning" title="Task older than 7 days"><img src="images/orange_icon.png" /></div>';
//        } else if ($now >= strtotime($date)){
//        echo '<div class="'; echo $grid; echo'_red_warning" title="Task older than 14 days"><img src="images/red_icon.png" /></div>';
//        } else {
//            echo '<div class="'; echo $grid; echo'_green_warning"></div>';
//        }
//    }
//    
//        if ($grid = 'procurement'){
//        if ($now <= strtotime($date) && $now >= $amber_date){
//        echo '<div class="'; echo $grid; echo'_amber_warning" title="Task older than 14 days"><img src="images/orange_icon.png" /></div>';
//        } else if ($now >= strtotime($date)){
//        echo '<div class="'; echo $grid; echo'_red_warning" title="Task older than 28 days"><img src="images/red_icon.png" /></div>';
//        } else {
//            echo '<div class="'; echo $grid; echo'_green_warning"></div>';
//        }
//    }
//    
//        if ($grid = 'procurement_conf'){
//        if ($now <= strtotime($date) && $now >= $amber_date){
//        echo '<div class="'; echo $grid; echo'_amber_warning" title="Task older than 7 days"><img src="images/orange_icon.png" /></div>';
//        } else if ($now >= strtotime($date)){
//        echo '<div class="'; echo $grid; echo'_red_warning" title="Task older than 14 days"><img src="images/red_icon.png" /></div>';
//        } else {
//            echo '<div class="'; echo $grid; echo'_green_warning"></div>';
//        }
//    }
}

function listManager ($value){

   $query = mysql_query("SELECT id, username FROM auth_user WHERE is_active=1 AND is_staff=1 ORDER BY username ASC") or die ('Error: '.mysql_error ());

   while($row = mysql_fetch_array($query)){
            $manager[] = array("id"=>$row['id'],"value"=>$row['username']);
            }

   foreach ($manager as $managername){
       echo '<option'.($managername['id']==$value? ' selected' : '').' value='.$managername['id'].'>'; echo $managername['value']; echo '</option>';
       //echo '<option value="'; echo $sectorname['id']; echo '">'; echo $sectorname['value']; echo '</option>';
       }
}

function managerName ($value){

   $query = mysql_query("SELECT id, username FROM auth_user WHERE is_active=1 AND is_staff=1 ORDER BY username ASC") or die ('Error: '.mysql_error ());

   while($row = mysql_fetch_array($query)){
            $manager[] = array("id"=>$row['id'],"value"=>$row['username']);
            }

   foreach ($manager as $managername){
        if ($managername['id'] == $value){
            echo $managername['value'];
        }
    }

}

function isCheckedClientAccess($client_id, $trace_user_id) {

global $user_access_list;

    foreach($user_access_list as $user){
        if($user['client_id'] == $client_id && $user['trace_user_id'] == $trace_user_id ){
            echo 'checked="yes"';
        }else{
            echo '';
        }
    }
}

function isCheckedUserAdmin($field){
    if ($field == '1'){
        echo 'checked="yes" ';
    }else{
        echo '';
    }
}


?>
