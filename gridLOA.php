<?php
// LOA Grid       ----------------------------------------
        echo '<div id="LOA-grid">';
        echo '<div class="sectionHeader">LOA - Letter of Authority <div class="sectionHeaderRight">';
             //
             echo'<a href = "javascript:void(0)" onclick = "document.getElementById(\'bulkloa\').style.display=\'block\';
            document.getElementById(\'bulkloa\').style.display=\'block\'" class="mediumButton">Bulk LOA</a></div></div>';

        //Main LOA query
        $loa_a = mysql_query("SELECT
                                        company_company.name AS companyName,
                                        company_portfolio.title AS portfolioName,
                                        building_site.id AS siteId,
                                        building_site.site_ref AS siteReference,
                                        building_site.letter_of_authority_renewal_date AS loaRenewalDate,
                                        building_site.letter_of_authority AS loaDoc,
                                        building_site.line1 AS siteAddress1,
                                        building_site.line2 AS siteAddress2,
                                        building_site.invoice_line1 AS invoiceLine1,
                                        building_site.city AS city,
                                        building_site.county AS county,
                                        building_site.postcode AS postcode,
                                        xmgnt_task.sent_supplier AS isSent,
                                        xmgnt_task.sent_client AS isSentClient,
                                        xmgnt_task.doc_path AS docPath,
                                        xmgnt_task.notes AS taskNotes
                                        FROM building_site
                                        LEFT JOIN xmgnt_task ON xmgnt_task.site_id=building_site.id
                                        INNER JOIN company_portfolio ON company_portfolio.id=building_site.portfolio_id
                                        INNER JOIN company_company ON company_company.id=company_portfolio.company_id
                                        WHERE(
                                        (company_portfolio.company_id IN ('$client_access_c') AND task_status=0 AND building_site.status=1 AND building_site.letter_of_authority_renewal_date between '" . $today . "' and '" . $LOA_deadline . "')
                                        OR
                                        (company_portfolio.company_id IN ('$client_access_c') AND building_site.status=1 AND building_site.letter_of_authority_renewal_date between '" . $today . "' and '" . $LOA_deadline . "')
                                        )
                                        AND(
                                        (xmgnt_task.doc_path IS NULL AND xmgnt_task.sent_supplier IS NULL AND xmgnt_task.sent_client IS NULL)OR
                                        (xmgnt_task.doc_path IS NULL AND xmgnt_task.sent_supplier IS NULL AND xmgnt_task.sent_client IS NOT NULL)OR
                                        (xmgnt_task.doc_path IS NULL AND xmgnt_task.sent_supplier IS NOT NULL AND xmgnt_task.sent_client IS NULL)OR
                                        (xmgnt_task.doc_path IS NULL AND xmgnt_task.sent_supplier IS NOT NULL AND xmgnt_task.sent_client IS NOT NULL)OR
                                        (xmgnt_task.doc_path IS NOT NULL AND xmgnt_task.sent_supplier IS NOT NULL AND xmgnt_task.sent_client IS NULL)OR
                                        (xmgnt_task.doc_path IS NOT NULL AND xmgnt_task.sent_supplier IS NULL AND xmgnt_task.sent_client IS NOT NULL)OR
                                        (xmgnt_task.doc_path IS NOT NULL AND xmgnt_task.sent_supplier IS NULL AND xmgnt_task.sent_client IS NULL)
                                        )
                                        ") or die ('Error: '.mysql_error ());
//AND portfolio_id=93

                $loa_bulk = mysql_query("SELECT
                                        company_company.name AS companyName,
                                        building_site.id AS siteId,
                                        building_site.site_ref AS siteReference,
                                        building_site.invoice_line1 AS invoiceLine1
                                        FROM building_site
                                        LEFT JOIN xmgnt_task ON xmgnt_task.site_id=building_site.id
                                        INNER JOIN company_portfolio ON company_portfolio.id=building_site.portfolio_id
                                        INNER JOIN company_company ON company_company.id=company_portfolio.company_id
                                        WHERE 
                                        (company_portfolio.company_id IN ('$client_access_c') AND task_status=0 AND building_site.status=1 AND building_site.letter_of_authority_renewal_date between '" . $today . "' and '" . $LOA_deadline . "')
                                        OR
                                        (company_portfolio.company_id IN ('$client_access_c') AND building_site.status=1 AND building_site.letter_of_authority_renewal_date between '" . $today . "' and '" . $LOA_deadline . "')
                                         AND(
                                        (xmgnt_task.doc_path IS NULL AND xmgnt_task.sent_supplier IS NULL AND xmgnt_task.sent_client IS NULL)OR
                                        (xmgnt_task.doc_path IS NULL AND xmgnt_task.sent_supplier IS NULL AND xmgnt_task.sent_client IS NOT NULL)OR
                                        (xmgnt_task.doc_path IS NULL AND xmgnt_task.sent_supplier IS NOT NULL AND xmgnt_task.sent_client IS NULL)OR
                                        (xmgnt_task.doc_path IS NULL AND xmgnt_task.sent_supplier IS NOT NULL AND xmgnt_task.sent_client IS NOT NULL)OR
                                        (xmgnt_task.doc_path IS NOT NULL AND xmgnt_task.sent_supplier IS NOT NULL AND xmgnt_task.sent_client IS NULL)OR
                                        (xmgnt_task.doc_path IS NOT NULL AND xmgnt_task.sent_supplier IS NULL AND xmgnt_task.sent_client IS NOT NULL)OR
                                        (xmgnt_task.doc_path IS NOT NULL AND xmgnt_task.sent_supplier IS NULL AND xmgnt_task.sent_client IS NULL)
                                        )

                                        ") or die ('Error: '.mysql_error ());

                //  WHERE company_portfolio.company_id IN ('$client_access_c')
                                       // OR task_status=0
        
        //End query
        echo '<div id="bulkloa" class="white_content">
              <strong>Bulk LOA</strong><br />

             <table class="grid tablesorter"><thead>
             <th>Company</th>
             <th>Site</th>
             <th>Invoice Line 1</th>
             <th class="not-sortable"></th>
              </tr></thead>';

        echo '<form action="processpdf.php?form=bulkloa"  method="post" target="new"><tbody>';
        $i = 1;
        while($row = mysql_fetch_array($loa_bulk))
        {
        echo '<tr>';

        echo '<td>'; echo $row['companyName'];echo '</td>';
        echo '<td>'; echo $row['siteReference'];echo '</td>';
        echo '<td>'; echo $row['invoiceLine1'];echo '</td>';
        echo '<td><input type="checkbox" name="loaSites[]" value="'; echo $row['siteId']; echo'"></td>';
        //$i ++;
        }
        echo '</tr></tbody></table>
            Mark all as sent? <input type="checkbox" name="updatesent" value="yes" ><br />
              <input type="submit" name="submit" value="Create" class="formButton"> </form>';


            //  "document.getElementById(\'bulkloa\').style.display=\'none\';document.getElementById(\'bulkloa\').style.display=\'none\'"


        echo '<a href = "javascript:void(0)" onClick="document.location.reload(true)" class="mediumButton">Close</a></div>
        <div id="bulkloa" class="black_overlay"></div>';

        //Begin table

        echo '<table class="grid tablesorter"><thead><tr><th>Client</th><th>Portfolio</th><th>Site Name</th>
             <th>LOA Expiry Date</th><th>Days to LOA Expiry</th><th>Address 1</th><th>Address 2</th>
              <th>City</th><th>County</th><th>Postcode</th><th class="not-sortable"></th><th class="not-sortable"></th><th class="not-sortable"></th><th class="not-sortable"></th>
              <th class="not-sortable"></th>
              </tr></thead>';

        $loa_div_to_open = $_GET['id'];
        $i = 1;
        echo '<tbody>';
        while($row = mysql_fetch_array($loa_a))
        {
        echo '<tr>';

        echo '<td>'; echo $row['companyName'];echo '</td>';
        echo '<td>'; echo $row['portfolioName'];echo '</td>';
        echo '<td>'; echo $row['siteReference'];echo '</td>';
        echo '<td>'; echo $row['loaRenewalDate'];echo '</td>';
        echo '<td>'; dateCountdown($row['loaRenewalDate'], 'LOA'); echo '</td>';
        echo '<td>'; echo $row['siteAddress1'];echo '</td>';
        echo '<td>'; echo $row['siteAddress2'];echo '</td>';
        echo '<td>'; echo $row['city'];echo '</td>';
        echo '<td>'; echo $row['county'];echo '</td>';
        echo '<td>'; echo $row['postcode'];echo '</td>';

        if ($row['isSent'] == '1' && $row['isSentClient'] == '8'){

        echo '<td><img src="images/sent.png" alt="Sent" /></td>';

        }else{

        echo '<td><img src="images/not_sent.png" alt="Not sent" /></td>';

        }

        if (isset($row['docPath'])){
            echo '<td><img src="images/doc.png" alt="Document uploaded" /></td>';
        }else{
        echo '<td><img src="images/no_doc.png" alt="Document not uploaded" /></td>';
        }


        echo '<td><a href="#" class="show_hide smallButton" rel="#sliding_loa_div_'; echo $i; echo'">+</a></td>';

          $LOA_task_created_date = strtotime("-120 days", strtotime($row['loaRenewalDate']));
          $LOA_task_amber_date = strtotime("-106 days", strtotime($row['loaRenewalDate']));
          $LOA_task_red_date = strtotime("-92 days", strtotime($row['loaRenewalDate']));

        if ($now <= $LOA_task_red_date && $now >= $LOA_task_amber_date){
            echo '<td><div class="LOA_amber_warning" title="Task older than 14 days"><img src="images/orange_icon.png" /></div></td>';
        } else if ($now >= $proc_task_red_date){
            echo '<td><div class="LOA_red_warning" title="Task older than 28 days"><img src="images/red_icon.png" /></div></td>';
        } else {
            echo '<td><div class="LOA_green_warning"></div></td>';
        }




        echo '</tr>';

        echo '<tr class="row-details expand-child"><td colspan="14"><style>#sliding_loa_div_'; echo $i;

        //Make sure the last edited div remains open on refresh

        if($loa_div_to_open == $row['siteId']){

        //normally block
        echo'{display:block;}</style>
              <div id="sliding_loa_div_'; echo $i; echo'">';
        }else{
            echo '{display:none;}</style>
              <div id="sliding_loa_div_'; echo $i; echo'">';
        }

echo'
<div id="addNotes">
<form action="mgnt.php?form=addnote&type=loa&id='; echo $row['siteId']; echo'" method="post">
        <textarea rows="10" cols="35" name="notes">'; echo $row ['taskNotes']; echo' </textarea><br />
                <input type="submit" name="submit" value="Save" class="formButton">
                </form>
                </div>

        <div id="taskButtons">
        <strong>Tasks:</strong><br />';


if ($row['isSent'] == '1'){

        echo '<a href ="mgnt.php?form=updatesent&type=loa&value=0&id='; echo $row['siteId']; echo '" class="largeButtonRed">Mark not sent (Supplier)</a>';

        }else{

        echo '<a href ="mgnt.php?form=updatesent&type=loa&value=1&id='; echo $row['siteId']; echo '" class="largeButton">Mark sent (Supplier)</a>';

        }
if ($row['isSentClient'] == '8'){

        echo '<a href ="mgnt.php?form=updatesentclient&type=loa&value=7&id='; echo $row['siteId']; echo '" class="largeButtonRed">Mark not sent (Client)</a>';

        }else{

        echo '<a href ="mgnt.php?form=updatesentclient&type=loa&value=8&id='; echo $row['siteId']; echo '" class="largeButton">Mark sent (Client)</a>';

        }

                if (isset($row['docPath'])){
            echo '<a href ="upload/'; echo $row['docPath']; echo '" class="largeButton" target="blank">View Document</a>';
            echo  '<a href ="mgnt.php?form=removedoc&type=loa&id='; echo $row['siteId']; echo '" class="largeButtonRed">Remove Document</a>';
        }else{
           echo '<a href = "javascript:void(0)" onclick = "document.getElementById(\'uploadlightloa'; echo $i; echo '\').style.display=\'block\';
            document.getElementById(\'uploadfadeloa'; echo $i; echo '\').style.display=\'block\'" class="largeButton">Upload Confirmation</a>';



                echo '<div id="uploadlightloa'; echo $i; echo'" class="white_content">

                <form action="mgnt.php?id='; echo $row['siteId']; echo'" method="post"
                enctype="multipart/form-data">
                <input type="hidden" name="filename" value="'; echo $row['siteId']; echo '" />'; echo '
                <input type="hidden" name="type" value="loa" />
                <input type="hidden" name="sentclient" value="'; echo $row['isSent']; echo'" />
                <input type="file" name="file" id="file" size="15">
                <input type="submit" name="submit" value="Upload" class="formButton">
                </form><br />


        <a href = "javascript:void(0)" onclick = "document.getElementById(\'uploadlightloa'; echo $i; echo '\').style.display=\'none\';document.getElementById(\'uploadfadeloa'; echo $i; echo '\').style.display=\'none\'" class="mediumButton">Close</a></div>
        <div id="uploadfadeloa'; echo $i; echo'" class="black_overlay"></div>';
        }



        echo '<a href ="#" class="largeButton" target="name"
              onclick="window.open(\'processpdf.php?form=loa_owner_occupier&type=loa&id='; echo $row['siteId'];
              echo'\',\'name\',\'height=600, width=800,toolbar=no,directories=no,status=no, menubar=no,scrollbars=yes,resizable=no\'); return false;"
              >Owner/Occupier Doc</a>';

        echo '<a href ="#" class="largeButton" target="name"
              onclick="window.open(\'processpdf.php?form=loa_managing_agent&type=loa&invoiceaddress='; echo $row['invoiceLine1']; echo'&id='; echo $row['siteId'];
               echo'&line1='; echo $row['siteAddress1'];echo'&line2='; echo $row['siteAddress2'];echo'&city='; echo $row['city'];echo'&county='; echo $row['county'];
               echo'&postcode='; echo $row['postcode'];
              echo'\',\'name\',\'height=600, width=800,toolbar=no,directories=no,status=no, menubar=no,scrollbars=yes,resizable=no\'); return false;"
              >Managing Agent Doc</a>';

        echo '<br /><br /></div>';


echo '<div id="history"><strong> Task History: </strong><br />';

          foreach($loa_f as $loataskhistory){
              if ($loataskhistory['siteId'] == $row['siteId']){
                  echo $loataskhistory['user']; historyType($loataskhistory['eventType']); echo '<i>'; echo $loataskhistory['eventTime']; echo '</i>'; echo '<br />';
              }

              }

        echo '<br /></div>';
echo '</div>';

        $i ++; }

        echo '</tbody></table></div>';


?>
