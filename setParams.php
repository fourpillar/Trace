<?php
//full_client_list

       $full_client_list_a = mysql_query("SELECT * FROM company_company ORDER BY name ASC

        ")or die ('Error: '.mysql_error ());

               while($row = mysql_fetch_array($full_client_list_a)){
            $full_client_list_b[] = array("id"=>$row['id'],"name"=>$row['name']
                            );
        }


//Set user access

//if superuser ..
//        if ($simulate_view == '1'){
//            $client_access_a = mysql_query("SELECT client_id AS id FROM xadmin_user_access WHERE trace_user_id=$simulation_id") or die ('Error: '.mysql_error ());
//            }else
                if ($_SESSION['mode'] == 'sim'){
            $client_access_a = mysql_query("SELECT client_id AS id FROM xadmin_user_access WHERE trace_user_id='" . $_SESSION['sim_id'] . "'") or die ('Error: '.mysql_error ());
            }else
        if ($master_mgnt_super_user == '1'){
        $client_access_a = mysql_query("SELECT id FROM company_company WHERE id LIKE '%'");
        }else
        if ($master_access_mgnt == '1'){
        
        $client_access_a = mysql_query("SELECT client_id AS id FROM xadmin_user_access WHERE trace_user_id=$master_user_id");
        }
            
// Build array
        $client_access_b = array();
        while($row = mysql_fetch_array($client_access_a)){
            $client_access_b[] = $row['id'];
}

//if superuser ..
        $client_access_names_a = mysql_query("SELECT name FROM company_company WHERE id LIKE '%'");

// Build array
        $client_access_names_b = array();
        while($row = mysql_fetch_array($client_access_names_a)){
            $client_access_names_b[] = $row['name'];
}

        $introducer_a = mysql_query("SELECT * FROM xsales_introducer WHERE active=1");

// Build array
        $introducer_b = array();
        while($row = mysql_fetch_array($introducer_a)){
            $introducer_b[] = $row['name'];
}

        $account_manager_a = mysql_query("SELECT * FROM xadmin_user");

// Build array
        $account_manager_b = array();
        while($row = mysql_fetch_array($account_manager_a)){
            $account_manager_b[] = $row['username'];
}

        $new_client_a = mysql_query("SELECT * FROM xsales_client WHERE active=1");

// Build array
        $new_client_b = array();
        while($row = mysql_fetch_array($new_client_a)){
            $new_client_b[] = $row['name'];
}


//Create array with comma values, ready for query.
        $client_access_c = implode("', '", $client_access_b);

//colliers
       //$client_access_c = 7;
//GVA
       //$client_access_c = 4;

//Set standard date format

$date_format = 'Y-m-d';
$today = date ( $date_format, strtotime ( '-0 days' ) );
$now = time();

// date parameters

$procurement_contract_deadline = date ( $date_format, strtotime ( '+120 days' ) );
$procurement_contract_amber = date ( $date_format, strtotime ( '+14 days' ) );
$procurement_contract_red = date ( $date_format, strtotime ( '+7 days' ) );

 $from = strtotime($procurement_contract_amber);
 $to = strtotime($procurement_contract_red);

// Set NOT date parameters

$NOT_contract_deadline = date ( $date_format, strtotime ( '+120 days' ) );

// Set NOT date parameters

$LOA_deadline = date ( $date_format, strtotime ( '+120 days' ) );

//Set invoice date parameters
$invoice_retrieve_quarterly = date ( $date_format, strtotime ( '-98 days' ) );
$invoice_retrieve_monthly = date ( $date_format, strtotime ( '-35 days' ) );

//Set invoice date parameters
//$invoice_retrieve_quarterly = date ( $date_format, strtotime ( '-0 days' ) );
//$invoice_retrieve_monthly = date ( $date_format, strtotime ( '-0 days' ) );

//$invoice_amber_monthly = date ( $date_format, strtotime ( '-35 days' ) );
//$invoice_red_monthly = date ( $date_format, strtotime ( '-35 days' ) );

//$invoice_amber_annually = date ( $date_format, strtotime ( '+7 days' ) );
//$invoice_red_annually = date ( $date_format, strtotime ( '+7 days' ) );

$proc_conf_contract_future = date ( $date_format, strtotime ( '+120 days' ) );
$proc_conf_contract_past = date ( $date_format, strtotime ( '-30 days' ) );

?>
