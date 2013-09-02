<?php
// NOT Grid       ----------------------------------------
        echo '<div id="NOT-grid">';
        echo '<div class="sectionHeader">NOT - Notice of Termination</div>';


        //Main NOT query
        $not_a = mysql_query("SELECT
                                        company_company.name AS companyName,
                                        company_portfolio.title AS portfolioName,
                                        building_site.site_ref AS siteReference,
                                        statistics_meter.mpan_number AS mpanNumber,
                                        statistics_contract.meter_id AS meterId,
                                        statistics_contract.supplier AS supplierName,
                                        statistics_contract.account_reference AS accountRef,
                                        statistics_contract.notice_of_termination_days AS terminationDays,
                                        statistics_contract.billing_address_line1 AS billingLine1,
                                        MAX(statistics_contract.contract_end_date) AS contractEndDate,
                                        MAX(statistics_meterreading.date) AS lastMeterReadingDate,
                                        statistics_meterreading.reading AS lastMeterReading,
                                        statistics_contract.id AS contractId,
                                        xmgnt_task.sent_supplier AS isSent,
                                        xmgnt_task.doc_path AS docPath,
                                        xmgnt_task.notes AS taskNotes
                                        FROM statistics_contract
                                        LEFT JOIN xmgnt_task ON xmgnt_task.contract_id=statistics_contract.id
                                        LEFT JOIN statistics_meterreading ON statistics_meterreading.meter_id=statistics_contract.meter_id
                                        INNER JOIN statistics_meter ON statistics_meter.id=statistics_contract.meter_id
                                        INNER JOIN building_site ON building_site.id=statistics_meter.building_id
                                        INNER JOIN company_portfolio ON company_portfolio.id=building_site.portfolio_id
                                        INNER JOIN company_company ON company_company.id=company_portfolio.company_id
                                        WHERE company_portfolio.company_id IN ('$client_access_c')
                                        AND building_site.status=1
                                        AND statistics_contract.contract_end_date between '" . $today . "' and '" . $NOT_contract_deadline . "'
                                        AND (
                                        (xmgnt_task.doc_path IS NULL AND xmgnt_task.sent_supplier IS NULL)OR
                                        (xmgnt_task.doc_path IS NULL AND xmgnt_task.sent_supplier IS NOT NULL)OR
                                        (xmgnt_task.doc_path IS NOT NULL AND xmgnt_task.sent_supplier IS NULL)
                                        )
                                        GROUP BY statistics_contract.meter_id
                                        ORDER BY statistics_contract.contract_end_date ASC
                                        ") or die ('Error: '.mysql_error ());



       echo '<table class="grid tablesorter"><thead><tr><th>Client</th><th>Portfolio</th><th>Site Name</th>
             <th>Supplier</th><th>Account Ref.</th><th>MPAN/MPRN</th>
             <th>Contract End Date</th><th>Termination  Period</th><th>Days to Deadline</th>
             <th class="not-sortable"></th><th class="not-sortable"></th><th class="not-sortable"></th><th class="not-sortable"></th>
             </tr></thead>';

          $div_to_open = $_GET['id'];
        $i = 1;
        echo '<tbody>';
        while($row = mysql_fetch_array($not_a)){

            if (isset ($row['terminationDays'])){
            $total_day_count = $row['terminationDays'] + 30;
            }else{
            $total_day_count = 120;
            }
            $calc_not = strtotime("-".$total_day_count." days", strtotime($row['contractEndDate']));
            
            if ($now >= $calc_not){
        
        echo '<tr>';
        echo '<td>'; echo $row['companyName'];echo '</td>';
        echo '<td>'; echo $row['portfolioName'];echo '</td>';
        echo '<td>'; echo $row['siteReference'];echo '</td>';
        echo '<td>'; echo $row['supplierName'];echo '</td>';
        if (strlen($row['accountRef']) > 1){
        echo '<td>'; echo $row['accountRef'];echo '</td>';
        }else{
        echo '<td> - </td>';
        }
        echo '<td>'; echo $row['mpanNumber'];echo '</td>';
        //echo '<td>'; echo $row['meterId'];echo '</td>';
        echo '<td>'; echo $row['contractEndDate'];echo '</td>';
        if (isset($row['terminationDays'])){
        echo '<td>'; echo $row['terminationDays'];echo ' days</td>';
        }else{
        echo '<td> - </td>';
        }

        echo '<td>'; echo dateCountdown($row['contractEndDate'], 'NOT'); echo'</td>';

//        echo '<td>'; echo $row['lastMeterReading'];echo '</td>';
//        echo '<td>'; echo $row['lastMeterReadingDate'];echo '</td>';



        if ($row['isSent'] == '1'){

        echo '<td><img src="images/sent.png" alt="Sent" /></td>';

        }else{

        echo '<td><img src="images/not_sent.png" alt="Not sent" /></td>';

        }

        if (isset($row['docPath'])){
            echo '<td><img src="images/doc.png" alt="Document uploaded" /></td>';
        }else{
        echo '<td><img src="images/no_doc.png" alt="Document not uploaded" /></td>';
        }


        echo '<td><a href="#" class="show_hide smallButton" rel="#sliding_div_'; echo $i; echo'">+</a></td>';


          $not_amber_days = $total_day_count - 7;
          $not_red_days = $total_day_count - 14;

          $not_task_created_date = strtotime("-".$total_day_count." days", strtotime($row['contractEndDate']));
          $not_task_amber_date = strtotime("-".$not_amber_days." days", strtotime($row['contractEndDate']));
          $not_task_red_date = strtotime("-".$not_red_days. "days", strtotime($row['contractEndDate']));

        if ($now <= $not_task_red_date && $now >= $not_task_amber_date){
            echo '<td><div class="NOT_amber_warning" title="Task older than 7 days"><img src="images/orange_icon.png" /></div></td>';
        } else if ($now >= $not_task_red_date){
            echo '<td><div class="NOT_red_warning" title="Task older than 14 days"><img src="images/red_icon.png" /></div></td>';
        } else {
            echo '<td><div class="NOT_green_warning"></div></td>';
        }

        echo '</tr>';
        echo '<tr  class="row-details expand-child"><td colspan="14"><style>#sliding_div_'; echo $i;

        //Make sure the last edited div remains open on refresh

        $check = $_GET['type'];

        if($div_to_open == $row['contractId'] && $check != 'procurement'){


        echo'{display:block;}</style>
              <div id="sliding_div_'; echo $i; echo'">';
        }else{
            echo '{display:none;}</style>
              <div id="sliding_div_'; echo $i; echo'">';
        }

echo'
<div id="addNotes">
<form action="mgnt.php?form=addnote&type=not&id='; echo $row['contractId']; echo'" method="post">
        <textarea rows="10" cols="35" name="notes">'; echo $row ['taskNotes']; echo' </textarea><br />
                <input type="submit" name="submit" value="Save" class="formButton">
                </form>
                </div>

<div id="taskButtons">';
echo '<strong>Tasks:</strong><br />';


if ($row['isSent'] == '1'){

        echo '<a href ="mgnt.php?form=updatesent&type=not&value=0&id='; echo $row['contractId']; echo '" class="largeButtonRed">Mark not sent</a>';

        }else{

        echo '<a href ="mgnt.php?form=updatesent&type=not&value=1&id='; echo $row['contractId']; echo '" class="largeButton">Mark sent</a>';

        }
                if (isset($row['docPath'])){
            echo '<a href ="upload/'; echo $row['docPath']; echo '" class="largeButton">View Document</a>';
            echo  '<a href ="mgnt.php?form=removedoc&type=not&id='; echo $row['contractId']; echo '" class="largeButtonRed">Remove Document</a>';
        }else{
           echo '<a href = "javascript:void(0)" onclick = "document.getElementById(\'uploadlightnot'; echo $i; echo '\').style.display=\'block\';
            document.getElementById(\'uploadfadenot'; echo $i; echo '\').style.display=\'block\'" class="largeButton">Upload Document</a>';



                echo '<div id="uploadlightnot'; echo $i; echo'" class="white_content">

                <form action="mgnt.php?id='; echo $row['contractId']; echo '" method="post"
                enctype="multipart/form-data">
                <input type="hidden" name="filename" value="'; echo $row['contractId']; echo '" />
                <input type="hidden" name="type" value="not" />
                <input type="file" name="file" id="file" size="15">
                <input type="submit" name="submit" value="Upload" class="formButton">
                </form><br />


        <a href = "javascript:void(0)" onclick = "document.getElementById(\'uploadlightnot'; echo $i; echo '\').style.display=\'none\';document.getElementById(\'uploadfadenot'; echo $i; echo '\').style.display=\'none\'" class="mediumButton">Close</a></div>
        <div id="uploadfadenot'; echo $i; echo'" class="black_overlay"></div>';
        }



        echo '<a href ="#" class="largeButton" target="name"
              onclick="window.open(\'processpdf.php?form=createpdf&type=not&id='; echo $row['contractId']; echo'&supplier='; echo $row['supplierName'];
              echo '&contractenddate='; echo $row['contractEndDate']; echo '&billingline1='; echo $row['billingLine1']; echo '&accountref='; echo $row['accountRef']; echo '&today='; echo $today;echo '&mpan='; echo $row['mpanNumber'];
              echo'\',\'name\',\'height=600, width=800,toolbar=no,directories=no,status=no, menubar=no,scrollbars=no,resizable=yes\'); return false;"
              >NOT Template</a>';
        echo '<br /><br /></div>';


echo '<div id="history"><strong> Task History: </strong><br />';

          foreach($not_f as $taskhistory){
              if ($taskhistory['contractId'] == $row['contractId']){
                  echo $taskhistory['user']; historyType($taskhistory['eventType']); echo '<i>'; echo $taskhistory['eventTime']; echo '</i>'; echo '<br />';
              }

              }

        echo '<br /></div>';
echo '</div>';
$i ++; }}

        echo '</tbody></table></div>';





// End NOT grid     --------------------------

?>
