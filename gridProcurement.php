<?php
// Procurement Grid       ----------------------------------------
        echo '<div id="procurement-grid">';
        echo '<div class="sectionHeader">Procurement</div>';

          $procurement_a = mysql_query("SELECT
                                        company_company.name AS companyName,
                                        company_portfolio.title AS portfolioName,
                                        building_site.site_ref AS siteReference,
                                        building_site.line1 AS line1,
                                        building_site.line2 AS line2,
                                        building_site.city AS city,
                                        building_site.county AS county,
                                        building_site.postcode AS postcode,
                                        statistics_meter.mpan_number AS mpanNumber,
                                        statistics_meter.alias AS meterAlias,
                                        statistics_meter.profile_type AS profileType,
                                        statistics_meter.meter_time_switch_code AS MTC,
                                        statistics_meter.line_loss_factor AS LLF,
                                        statistics_contract.supplier AS supplierName,
                                        statistics_contract.account_reference AS accountRef,
                                        statistics_contract.has_amr AS hasAMR,
                                        statistics_contract.is_hh AS isHH,
                                        statistics_contract.id AS contractId,
                                        statistics_contract.kva_charge_type AS kvaChargeType,
                                        xmgnt_task.notes AS taskNotes,
                                        MAX(statistics_contract.contract_end_date) AS contractEndDate
                                        FROM statistics_contract
                                        LEFT JOIN xmgnt_task ON xmgnt_task.procurement_contract_id=statistics_contract.id
                                        INNER JOIN statistics_meter ON statistics_meter.id=statistics_contract.meter_id
                                        INNER JOIN building_site ON building_site.id=statistics_meter.building_id
                                        INNER JOIN company_portfolio ON company_portfolio.id=building_site.portfolio_id
                                        INNER JOIN company_company ON company_company.id=company_portfolio.company_id
                                        WHERE
                                        company_portfolio.company_id IN ('$client_access_c')
                                        AND building_site.status=1
                                        AND building_site.is_procuring=1
                                        AND statistics_contract.contract_end_date between '" . $today . "' and '" . $procurement_contract_deadline . "'
                                        GROUP BY statistics_contract.meter_id
                                        ORDER BY statistics_contract.contract_end_date ASC
                                        ") or die ('Error: '.mysql_error ());

        
        echo '<table class="grid tablesorter"><thead>
              <tr><th>Client</th><th>Site Name</th><th>Account Ref.</th><th>Supplier</th><th>MPAN/MPRN</th><th>Meter</th>
              <th>Profile</th><th>MTC</th><th>LLF</th><th>Contract End Date</th><th>..Countdown</th><th>Confirmed</th>
              <th>HH/AMR/NHH</th><th>KVA (agreed cpacity)</th>';
              echo '<th>Site Address 1</th><th>Site Address 2</th><th>City</th><th>County</th><th>Postcode</th>
              <th class="not-sortable"></th><th class="not-sortable"></th></tr></thead>';

        echo '<tbody>';
        $i = 1;
        while($row = mysql_fetch_array($procurement_a))
        {
        echo '<tr>';

        echo '<td>'; echo $row['companyName'];echo '</td>';
        echo '<td>'; echo $row['siteReference'];echo '</td>';
        echo '<td>'; echo $row['accountRef'];echo '</td>';
        echo '<td>'; echo $row['supplierName'];echo '</td>';
        echo '<td>'; echo $row['mpanNumber'];echo '</td>';
        echo '<td>'; echo $row['meterAlias'];echo '</td>';
        echo '<td>'; echo $row['profileType'];echo '</td>';
        echo '<td>'; echo $row['MTC'];echo '</td>';
        echo '<td>'; echo $row['LLF'];echo '</td>';
        echo '<td>'; echo $row['contractEndDate'];echo '</td>';
        echo '<td>'; echo dateCountdown($row['contractEndDate'], 'proc'); echo'</td>';
        
        if(isset($row['docPath'])){
        echo '<td>Y</td>';
        }else{
        echo '<td>N</td>';
        }

        if ($row['hasAMR'] == '1'){
            echo '<td>AMR</td>';
        }else if($row['isHH'] == '1'){
            echo '<td>HH</td>';
        }else{
            echo '<td>NHH</td>';
        }

         echo '<td>'; echo $row['kvaChargeType']; echo'</td>';
         echo '<td>'; echo $row['line1']; echo'</td>';
         echo '<td>'; echo $row['line2']; echo'</td>';
         echo '<td>'; echo $row['city']; echo'</td>';
         echo '<td>'; echo $row['county']; echo'</td>';
         echo '<td>'; echo $row['postcode']; echo'</td>';
         echo '<td><a href="#" class="show_hide smallButton" rel="#sliding_procurement_div_'; echo $i; echo'">+</a></td>';

          $proc_task_created_date = strtotime("-120 days", strtotime($row['contractEndDate']));
          $proc_task_amber_date = strtotime("-106 days", strtotime($row['contractEndDate']));
          $proc_task_red_date = strtotime("-92 days", strtotime($row['contractEndDate']));

        if ($now <= $proc_task_red_date && $now >= $proc_task_amber_date){
            echo '<td><div class="procurement_amber_warning"  title="Task older than 14 days"><img src="images/orange_icon.png" /></div></td>';
        } else if ($now >= $proc_task_red_date){
            echo '<td><div class="procurement_red_warning"  title="Task older than 28 days"><img src="images/red_icon.png" /></div></td>';
        } else {
            echo '<td><div class="procurement_green_warning"></div></td>';
        }
        echo '</tr>';

        echo '<tr class="row-details expand-child"><td colspan="21"><style>#sliding_procurement_div_'; echo $i;

        //Make sure the last edited div remains open on refresh

//        if($loa_div_to_open == $row['siteId']){
//
//        //normally block
//        echo'{display:block;}</style>
//              <div id="sliding_proc_div_'; echo $i; echo'">';
//        }else{
            echo '{display:none;}</style>
              <div id="sliding_procurement_div_'; echo $i; echo'">';
//        }

echo'
<div id="addNotes">


<form action="mgnt.php?form=addnote&type=procurement&id='; echo $row['contractId']; echo'" method="post">
        <textarea rows="10" cols="50" name="notes">'; echo $row ['taskNotes']; echo' </textarea><br />
                <input type="submit" name="submit" value="Save" class="formButton">
                </form>';        echo '<br /></div>';

echo '<div id="history"><strong> Task History: </strong><br />';

          foreach($procurement_f as $procurementtaskhistory){
              if ($procurementtaskhistory['contractId'] == $row['contractId']){
                  echo $procurementtaskhistory['user']; historyType($procurementtaskhistory['eventType']); echo '<i>'; echo $procurementtaskhistory['eventTime']; echo '</i>'; echo '<br />';
              }

              }
echo '</div>';

        $i ++; }
        
        echo '</tbody></table>';
        echo '</div>';
        // End Procurement grid     --------------------------

?>

