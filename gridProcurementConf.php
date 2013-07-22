<?php
// Procurement Grid       ----------------------------------------
        echo '<div id="procurementconf-grid">';
        echo '<div class="sectionHeader">Procurement Confirmation</div>';

          $procurement_conf_a = mysql_query("SELECT
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
                                        xmgnt_task.doc_path AS docPath,
                                        xmgnt_task.notes AS taskNotes,
                                        statistics_contract.contract_start_date AS contractStartDate,
                                        MAX(statistics_contract.contract_end_date) AS contractEndDate
                                        FROM statistics_contract
                                        LEFT JOIN xmgnt_task ON xmgnt_task.proc_contract_id=statistics_contract.id
                                        INNER JOIN statistics_meter ON statistics_meter.id=statistics_contract.meter_id
                                        INNER JOIN building_site ON building_site.id=statistics_meter.building_id
                                        INNER JOIN company_portfolio ON company_portfolio.id=building_site.portfolio_id
                                        INNER JOIN company_company ON company_company.id=company_portfolio.company_id
                                        WHERE
                                        company_portfolio.company_id IN ('$client_access_c')
                                        AND building_site.status=1
                                        AND (xmgnt_task.task_status IS NULL OR xmgnt_task.task_status = 0)
                                        AND building_site.is_procuring=1
                                        AND(
                                        (statistics_contract.contract_start_date between '" . $proc_conf_contract_past . "' and '" . $today . "')OR
                                        (statistics_contract.contract_start_date between '" . $today . "' and '" . $proc_conf_contract_future . "')
                                        )
                                        GROUP BY statistics_contract.meter_id
                                        ORDER BY statistics_contract.contract_end_date ASC
                                        ") or die ('Error: '.mysql_error ());


//	contract page --> HH/AMR/NHH	KVA (agreed capacity)	NOT Accepted 	Annual Usage	Day Usage	Night Usage	Site Address 1	Site Address 2	City	County	Postcode


        echo '<table class="grid tablesorter"><thead>
              <tr><th>Client</th><th>Site Name</th><th>Account Ref.</th><th>Supplier</th><th>MPAN/MPRN</th><th>Meter</th>
              <th>Profile</th><th>MTC</th><th>LLF</th><th>Contract End Date</th><th>Contract Start Date</th><th>Confirmed</th>
              <th>HH/AMR/NHH</th><th>KVA (agreed cpacity)</th>';
          //<th>Annual Usage</th><th>Day Usage</th><th>Night Usage</th>
              echo '<th>Site Address 1</th><th>Site Address 2</th><th>City</th><th>County</th><th>Postcode</th>
              <th class="not-sortable"></th><th class="not-sortable"></th></tr></thead>';

        echo '<tbody>';
        while($row = mysql_fetch_array($procurement_conf_a))
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
        echo '<td>'; echo $row['contractStartDate'];echo '</td>';

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
         echo '<td><a href="#" class="show_hide smallButton" rel="#sliding_proc_div_'; echo $i; echo'">+</a></td>';

          $proc_conf_task_created_date = strtotime("-120 days", strtotime($row['contractEndDate']));
          $proc_conf_task_amber_date = date ( $date_format, strtotime ( '+14 days' ) );
          $proc_conf_task_red_date = date ( $date_format, strtotime ( '+7 days' ) );
          $contract_startdate_time = strtotime($row['contractStart-Date']);

        if ($now <= $proc_task_amber_date && $now >= $proc_task_red_date){
            echo '<td><div class="procurement_conf_amber_warning" title="Task older than 14 days"><img src="images/orange_icon.png" /></div></td>';
        } else if ($now <= $proc_task_red_date && $now >= $contract_startdate_time){
            echo '<td><div class="procurement_conf_red_warning" title="Task older than 28 days"><img src="images/red_icon.png" /></div></td>';
        } else {
            echo '<td><div class="procurement_conf_green_warning"></div></td>';
        }



        echo '</tr>';
        echo '<tr class="row-details expand-child"><td colspan="21"><style>#sliding_proc_div_'; echo $i;

        //Make sure the last edited div remains open on refresh

//        if($loa_div_to_open == $row['siteId']){
//
//        //normally block
//        echo'{display:block;}</style>
//              <div id="sliding_proc_div_'; echo $i; echo'">';
//        }else{
            echo '{display:none;}</style>
              <div id="sliding_proc_div_'; echo $i; echo'">';
//        }

echo'
<div id="addNotes">
<fieldset>
<form action="mgnt.php?form=addnote&type=proc&id='; echo $row['contractId']; echo'" method="post"  id="proc_conf">
        <textarea rows="10" cols="35" name="notes" required>'; echo $row ['taskNotes']; echo' </textarea><br />
        Mark task as complete? <input type="checkbox" name="is_task_done" value="yes" ><br />
                <input type="submit" name="submit" value="Save" class="formButton">
</fieldset>
                </form>'; ?>
        
 <script type="text/javascript">
$("#proc_conf").validate();
</script>

<?php echo '</div>

        <div id="taskButtons">
        <strong>Tasks:</strong><br />';


//if ($row['isSent'] == '1'){
//
//        echo '<a href ="mgnt.php?form=updatesent&type=proc&value=0&id='; echo $row['siteId']; echo '" class="largeButtonRed">Mark not sent (Supplier)</a>';
//
//        }else{
//
//        echo '<a href ="mgnt.php?form=updatesent&type=proc&value=1&id='; echo $row['siteId']; echo '" class="largeButton">Mark sent (Supplier)</a>';
//
//        }
//if ($row['isSentClient'] == '8'){
//
//        echo '<a href ="mgnt.php?form=updatesentclient&type=proc&value=7&id='; echo $row['siteId']; echo '" class="largeButtonRed">Mark not sent (Client)</a>';
//
//        }else{
//
//        echo '<a href ="mgnt.php?form=updatesentclient&type=proc&value=8&id='; echo $row['siteId']; echo '" class="largeButton">Mark sent (Client)</a>';
//
//        }

                if (isset($row['docPath'])){
            echo '<a href ="upload/'; echo $row['docPath']; echo '" class="largeButton" target="blank">View Document</a>';
            echo  '<a href ="mgnt.php?form=removedoc&type=proc&id='; echo $row['siteId']; echo '" class="largeButtonRed">Remove Document</a>';
        }else{
           echo '<a href = "javascript:void(0)" onclick = "document.getElementById(\'uploadlightproc'; echo $i; echo '\').style.display=\'block\';
            document.getElementById(\'uploadfadeproc'; echo $i; echo '\').style.display=\'block\'" class="largeButton">Upload Confirmation</a>';



                echo '<div id="uploadlightproc'; echo $i; echo'" class="white_content">

                <form action="mgnt.php?id='; echo $row['contractId']; echo'" method="post"
                enctype="multipart/form-data">
                <input type="hidden" name="filename" value="'; echo $row['contractId']; echo '" />'; echo '
                <input type="hidden" name="type" value="proc" />
                <input type="file" name="file" id="file" size="15">
                <input type="submit" name="submit" value="Upload" class="formButton">
                </form><br />


        <a href = "javascript:void(0)" onclick = "document.getElementById(\'uploadlightproc'; echo $i; echo '\').style.display=\'none\';document.getElementById(\'uploadfadeproc'; echo $i; echo '\').style.display=\'none\'" class="mediumButton">Close</a></div>
        <div id="uploadfadeproc'; echo $i; echo'" class="black_overlay"></div>';
        }
        echo '<br /><br /></div>';


echo '<div id="history"><strong> Task History: </strong><br />';

          foreach($proc_f as $proctaskhistory){
              if ($proctaskhistory['contractId'] == $row['contractId']){
                  echo $proctaskhistory['user']; historyType($proctaskhistory['eventType']); echo '<i>'; echo $proctaskhistory['eventTime']; echo '</i>'; echo '<br />';
              }

              }

        echo '<br /></div>';
echo '</div>';

        $i ++; }

        echo '</tbody></table></div>';


?>
