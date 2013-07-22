<?php
// COT Grid       ----------------------------------------
        echo '<div id="COT-grid">';
        echo '<div class="sectionHeader">COT - Change of Tenant</div>';

                     $cot_a = mysql_query("SELECT
                                    company_company.name AS companyName,
                                    company_portfolio.title AS portfolioName,
                                    building_site.site_ref AS siteReference,
                                    building_changeoftenancy.id AS cotId,
                                    building_changeoftenancy.new_occupier AS newOccupier,
                                    building_changeoftenancy.new_occupier_phone AS newOccupierTel,
                                    building_changeoftenancy.handover_date AS handoverDate,
                                    building_changeoftenancy.existing_occupier_forwarding_address_line1 AS fwdLine1,
                                    building_changeoftenancy.existing_occupier_forwarding_address_line2 AS fwdLine2,
                                    building_changeoftenancy.existing_occupier_forwarding_address_city AS fwdCity,
                                    building_changeoftenancy.existing_occupier_forwarding_address_county AS fwdCounty,
                                    building_changeoftenancy.existing_occupier_forwarding_address_postcode AS fwdPostcode,
                                    building_changeoftenancy.new_occupier_address_line1 AS newLine1,
                                    building_changeoftenancy.new_occupier_address_line2 AS newLine2,
                                    building_changeoftenancy.new_occupier_address_city AS newCity,
                                    building_changeoftenancy.new_occupier_address_county AS newCounty,
                                    building_changeoftenancy.new_occupier_address_postcode AS newPostcode,
                                    building_changeoftenancy.new_occupier_email AS newEmail,
                                    building_changeoftenancy.new_occupier_phone AS newPhone,
                                    building_changeoftenancy.user_id AS userCreated,
                                    building_changeoftenancy.new_occupier AS newOccupier,
                                    building_changeoftenancy.trading_or_vacant AS tradingVacant,
                                    building_site.line1 AS siteAddress1,
                                    building_site.line2 AS siteAddress2,
                                    building_site.invoice_line1 AS invoiceLine1,
                                    building_site.city AS city,
                                    building_site.county AS county,
                                    building_site.postcode AS postcode,
                                    xmgnt_task.sent_supplier AS isSent,
                                    xmgnt_task.doc_path AS docPath,
                                    xmgnt_task.task_type AS taskType,
                                    xmgnt_task.notes AS taskNotes
                                    FROM building_changeoftenancy
                                    LEFT JOIN xmgnt_task ON xmgnt_task.cot_id=building_changeoftenancy.id
                                    INNER JOIN building_site ON building_site.id=building_changeoftenancy.site_id
                                    INNER JOIN company_portfolio ON company_portfolio.id=building_site.portfolio_id
                                    INNER JOIN company_company ON company_company.id=company_portfolio.company_id
                                    WHERE company_portfolio.company_id IN ('$client_access_c')
                                    AND building_site.status=1
                                    AND(
                                    (xmgnt_task.doc_path IS NULL AND xmgnt_task.sent_supplier IS NULL)OR
                                    (xmgnt_task.doc_path IS NULL AND xmgnt_task.sent_supplier IS NOT NULL)OR
                                    (xmgnt_task.doc_path IS NOT NULL AND xmgnt_task.sent_supplier IS NULL)
                                    )
                                    ") or die ('Error: '.mysql_error ());

                     //                                    statistics_contract.supplier AS supplierName,
//                                    statistics_contract.account_reference AS accountRef,

        echo '<table class="grid tablesorter">
              <thead><tr>
              <th>Client</th>
              <th>Portfolio</th>
              <th>Site Name</th>
              <th>New Occupier</th>
              <th>New Occupier Tel</th>
              <th>Handover Date</th>
              <th>Site Address 1</th>
              <th>Site Address 2</th>
              <th>City</th>
              <th>County</th>
              <th>Postcode</th>
              <th>Handover</th>
              <th class="not-sortable"></th>
              <th class="not-sortable"></th>
              <th class="not-sortable"></th>
              <th class="not-sortable"></th>
              </tr></thead>';
        
        $cot_div_to_open = $_GET['id'];
        $is_cot = $_GET['type'];
        $i =1;
        echo '<tbody>';
        while($row = mysql_fetch_array($cot_a))
        {
        echo '<tr>';

        echo '<td>'; echo $row['companyName'];echo '</td>';
        echo '<td>'; echo $row['portfolioName'];echo '</td>';
        echo '<td>'; echo $row['siteReference'];echo '</td>';
        echo '<td>'; echo $row['newOccupier'];echo '</td>';
        echo '<td>'; echo $row['newOccupierTel'];echo '</td>';
        echo '<td>'; echo $row['handoverDate'];echo '</td>';
        echo '<td>'; echo $row['siteAddress1'];echo '</td>';
        echo '<td>'; echo $row['siteAddress2'];echo '</td>';
        echo '<td>'; echo $row['city'];echo '</td>';
        echo '<td>'; echo $row['county'];echo '</td>';
        echo '<td>'; echo $row['postcode'];echo '</td>';
        echo '<td>'; dateCountdown($row['handoverDate'], 'COT');echo '</td>';

        
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


        echo '<td><a href="#" class="show_hide smallButton" rel="#sliding_cot_div_'; echo $i; echo'">+</a></td>';

        //function here.
        echo '<td>';        setWarning($row['handoverDate'], '10', 'COT'); echo '</td>';



        echo '</tr>';

        echo '<tr class="row-details expand-child"><td colspan="21"><style>#sliding_cot_div_'; echo $i;

        //Make sure the last edited div remains open on refresh

        if($cot_div_to_open == $row['cotId'] && $is_cot == 'cot'){

        //normally block
        echo'{display:block;}</style>
              <div id="sliding_cot_div_'; echo $i; echo'">';
        }else{
            echo '{display:none;}</style>
              <div id="sliding_cot_div_'; echo $i; echo'">';
        }

echo'
<div id="addNotes">
<form action="mgnt.php?form=addnote&type=cot&id='; echo $row['cotId']; echo'" method="post">
        <textarea rows="10" cols="35" name="notes">'; echo $row['taskNotes']; echo' </textarea><br />
                <input type="submit" name="submit" value="Save" class="formButton">
                </form>
                </div>

        <div id="taskButtons">
        <strong>Tasks:</strong><br />';


if ($row['isSent'] == '1'){

        echo '<a href ="mgnt.php?form=updatesent&type=cot&value=0&id='; echo $row['cotId']; echo '" class="largeButtonRed">Mark not sent</a>';

        }else{

        echo '<a href ="mgnt.php?form=updatesent&type=cot&value=1&id='; echo $row['cotId']; echo '" class="largeButton">Mark sent</a>';

        }
                if (isset($row['docPath'])){
            echo '<a href ="upload/'; echo $row['docPath']; echo '" class="largeButton" target="blank">View Document</a>';
            echo  '<a href ="mgnt.php?form=removedoc&type=cot&id='; echo $row['cotId']; echo '" class="largeButtonRed">Remove Document</a>';
        }else{
           echo '<a href = "javascript:void(0)" onclick = "document.getElementById(\'uploadlightcot'; echo $i; echo '\').style.display=\'block\';
            document.getElementById(\'uploadfadecot'; echo $i; echo '\').style.display=\'block\'" class="largeButton">Upload Confirmation</a>';



                echo '<div id="uploadlightcot'; echo $i; echo'" class="white_content">

                <form action="mgnt.php?id='; echo $row['cotId']; echo'" method="post"
                enctype="multipart/form-data">
                <input type="hidden" name="filename" value="'; echo $row['cotId']; echo '" />'; echo '
                <input type="hidden" name="type" value="cot" />
                <input type="hidden" name="sentclient" value="'; echo $row['isSent']; echo'" />
                <input type="file" name="file" id="file" size="15">
                <input type="submit" name="submit" value="Upload" class="formButton">
                </form><br />


        <a href = "javascript:void(0)" onclick = "document.getElementById(\'uploadlightcot'; echo $i; echo '\').style.display=\'none\';document.getElementById(\'uploadfadecot'; echo $i; echo '\').style.display=\'none\'" class="mediumButton">Close</a></div>
        <div id="uploadfadecot'; echo $i; echo'" class="black_overlay"></div>';
        }



        echo '<a href ="#" class="largeButton" target="name"
                 onclick="window.open(\'processpdf.php?form=cot&id=';echo$row['cotId'];echo'&firstname=';echo $master_firstname;echo'&lastname=';echo $master_lastname;echo'&email=';echo $master_email;echo'&cot_date=';echo $row['handoverDate'];
                 echo'&site1=';echo $row['siteAddress1'];echo'&site2=';echo $row['siteAddress2'];echo'&city=';echo $row['city'];echo'&county=';echo $row['county'];echo'&postcode=';echo $row['postcode'];echo'&accountno=';echo $row['postcode'];
                 echo'&outgoingcompany=';echo $row['siteLine1'];echo'&forwardline1=';echo $row['fwdLine1'];echo'&forwardline2=';echo $row['fwdLine2'];echo'&forwardcity=';echo $row['fwdCity'];echo'&forwardcounty=';echo $row['fwdCity'];
                 echo'&forwardpostcode=';echo $row['fwdPostcode'];echo'&usercreated=';echo $row['userCreated'];echo'&incomingcompany=';echo $row['newOccupier'];echo'&newline1=';echo $row['newLine1'];echo'&newline2=';echo $row['newLine2'];
                 echo'&newcity=';echo $row['newCity'];echo'&newcounty=';echo $row['newCounty'];echo'&newpostcode=';echo $row['newPostcode'];echo'&newphone=';echo $row['newPhone'];echo'&newemail=';echo $row['newEmail'];echo'&tradingorvacant=';echo $row['tradingVacant'];                                
              echo'\',\'name\',\'height=600, width=800,toolbar=no,directories=no,status=no, menubar=no,scrollbars=yes,resizable=yes\'); return false;"
              >COT Template</a>';
        echo '<br /><br /></div>';


echo '<div id="history"><strong> Task History: </strong><br />';

          foreach($cot_f as $cottaskhistory){
              if ($cottaskhistory['cotId'] == $row['cotId']){
                  echo $cottaskhistory['user']; historyType($cottaskhistory['eventType']); echo '<i>'; echo $cottaskhistory['eventTime']; echo '</i>'; echo '<br />';
              }

              }

        echo '<br /></div>';
echo '</div>';

        $i ++; }

        echo '</tbody></table></div>';

?>
