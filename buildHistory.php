<?php
//Build history array

//NOT history array
         $not_b = mysql_query("SELECT
                                        statistics_contract.id AS contractId
                                        FROM statistics_contract
                                        INNER JOIN statistics_meter ON statistics_meter.id=statistics_contract.meter_id
                                        INNER JOIN building_site ON building_site.id=statistics_meter.building_id
                                        INNER JOIN company_portfolio ON company_portfolio.id=building_site.portfolio_id
                                        INNER JOIN company_company ON company_company.id=company_portfolio.company_id
                                        WHERE company_portfolio.company_id IN ('$client_access_c')
                                        ") or die ('Error: '.mysql_error ());

         $not_c = array();
        while($row = mysql_fetch_array($not_b)){
            $not_c[] = $row['contractId'];
        }

        $not_d= implode("', '", $not_c);


        $not_e = mysql_query("SELECT * FROM xmgnt_task_history WHERE contract_id IN ('$not_d') ORDER BY datetime DESC
                             ") or die ('Error: '.mysql_error ());


        while($row = mysql_fetch_array($not_e)){
            $not_f[] = array("contractId"=>$row['contract_id'],"eventType"=>$row['event_type'],
                             "user"=>$row['user'], "eventTime"=>$row['datetime']
                            );
        }

  //LOA history array

         $loa_b = mysql_query("SELECT
                                        building_site.id AS buildingId
                                        FROM building_site
                                        INNER JOIN company_portfolio ON company_portfolio.id=building_site.portfolio_id
                                        INNER JOIN company_company ON company_company.id=company_portfolio.company_id
                                        WHERE company_portfolio.company_id IN ('$client_access_c')
                                        ") or die ('Error: '.mysql_error ());

         $loa_c = array();
        while($row = mysql_fetch_array($loa_b)){
            $loa_c[] = $row['buildingId'];
        }

        $loa_d= implode("', '", $loa_c);


        $loa_e = mysql_query("SELECT * FROM xmgnt_task_history WHERE site_id IN ('$loa_d') ORDER BY datetime DESC
                             ") or die ('Error: '.mysql_error ());


        while($row = mysql_fetch_array($loa_e)){
            $loa_f[] = array("siteId"=>$row['site_id'],"eventType"=>$row['event_type'],
                             "user"=>$row['user'], "eventTime"=>$row['datetime']
                            );
        }

   //COT history array

         $cot_b = mysql_query("SELECT
                                        building_changeoftenancy.site_id AS buildingId,
                                        building_changeoftenancy.id AS cotId
                                        FROM building_changeoftenancy
                                        INNER JOIN building_site ON building_site.id=building_changeoftenancy.site_id
                                        INNER JOIN company_portfolio ON company_portfolio.id=building_site.portfolio_id
                                        INNER JOIN company_company ON company_company.id=company_portfolio.company_id
                                        WHERE company_portfolio.company_id IN ('$client_access_c')
                                        ") or die ('Error: '.mysql_error ());

         $cot_c = array();
        while($row = mysql_fetch_array($cot_b)){
            $cot_c[] = $row['cotId'];
        }

        $cot_d= implode("', '", $cot_c);


        $cot_e = mysql_query("SELECT * FROM xmgnt_task_history WHERE cot_id IN ('$cot_d') ORDER BY datetime DESC
                             ") or die ('Error: '.mysql_error ());


        while($row = mysql_fetch_array($cot_e)){
            $cot_f[] = array("cotId"=>$row['cot_id'],"eventType"=>$row['event_type'],
                             "user"=>$row['user'], "eventTime"=>$row['datetime']
                            );
        }
        
        //Proc conf history array
         $proc_b = mysql_query("SELECT
                                        statistics_contract.id AS contractId
                                        FROM statistics_contract
                                        INNER JOIN statistics_meter ON statistics_meter.id=statistics_contract.meter_id
                                        INNER JOIN building_site ON building_site.id=statistics_meter.building_id
                                        INNER JOIN company_portfolio ON company_portfolio.id=building_site.portfolio_id
                                        INNER JOIN company_company ON company_company.id=company_portfolio.company_id
                                        WHERE company_portfolio.company_id IN ('$client_access_c')
                                        ") or die ('Error: '.mysql_error ());

         $proc_b = array();
        while($row = mysql_fetch_array($proc_b)){
            $proc_c[] = $row['contractId'];
        }

        $proc_d= implode("', '", $proc_c);


        $proc_e = mysql_query("SELECT * FROM xmgnt_task_history WHERE proc_contract_id IS NOT NULL

                             ") or die ('Error: '.mysql_error ());

//IN ('$proc_d') ORDER BY datetime DESC
        while($row = mysql_fetch_array($proc_e)){
            $proc_f[] = array("contractId"=>$row['proc_contract_id'],"eventType"=>$row['event_type'],
                             "user"=>$row['user'], "eventTime"=>$row['datetime']
                            );
        }

?>
