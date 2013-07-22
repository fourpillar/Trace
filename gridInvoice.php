<?php
// Begin Invoices grid      --------------------------
         echo '<div id="invoicing-grid">';
         echo '<div class="sectionHeader">Invoices</div>';

             $invoices_a = mysql_query("SELECT
                                        company_company.name AS companyName,
                                        company_portfolio.title AS portfolioName,
                                        building_site.site_ref AS siteReference,
                                        statistics_meter.mpan_number AS mpanNumber,
                                        statistics_meter.id AS meterId,
                                        statistics_meter.alias AS meterAlias,
                                        statistics_contract.supplier AS supplierName,
                                        statistics_contract.account_reference AS accountRef,
                                        MAX(statistics_contract.id) AS contractId,
                                        statistics_contract.contract_end_date AS contractEndDate,
                                        statistics_bill.start_date AS invoiceStartDate,
                                        MAX(statistics_bill.end_date) AS invoiceEndDate,
                                        statistics_contract.billing_frequency AS billingFrequency
                                        FROM statistics_bill
                                        INNER JOIN statistics_contract ON statistics_contract.id=statistics_bill.contract_id
                                        INNER JOIN statistics_meter ON statistics_meter.id=statistics_contract.meter_id
                                        INNER JOIN building_site ON building_site.id=statistics_meter.building_id
                                        INNER JOIN company_portfolio ON company_portfolio.id=building_site.portfolio_id
                                        INNER JOIN company_company ON company_company.id=company_portfolio.company_id
                                        WHERE company_portfolio.company_id IN ('$client_access_c')
                                        AND building_site.status=1
                                        AND building_site.is_validating=1
                                        GROUP BY statistics_contract.meter_id
                                        ORDER BY statistics_bill.end_date DESC
                                        ") or die ('Error: '.mysql_error ());
//                                        
                                      //  OR (statistics_bill.end_date < '" . $invoice_retrieve_quaterly . "' AND statistics_contract.billing_frequency ='2')


//AND (statistics_bill.end_date < '" . $invoice_retrieve_monthly . "' AND statistics_contract.billing_frequency ='1')
             //GROUP BY statistics_bill.end_date
                                     //    //ORDER BY statistics_bill.end_date ASC //GROUP BY statistics_bill.contract_id

             //AND (statistics_bill.end_date < '" . $invoice_retrieve_monthly . "' AND statistics_contract.billing_frequency ='1')
                                       // OR (statistics_bill.end_date < '" . $invoice_retrieve_quaterly . "' AND statistics_contract.billing_frequency ='2')

        echo '<table class="grid tablesorter"><thead><tr><th>Client</th><th>Portfolio</th><th>Site Name</th>
             <th>Supplier</th><th>Account Ref.</th><th>MPAN/MPRN</th><th>Meter</th>
              <th>Last Invoice Close Date</th><th class="not-sortable"></th><th class="not-sortable"></th>
              </tr></thead>';

        $monthly = strtotime($invoice_retrieve_monthly);
        $quarterly = strtotime($invoice_retrieve_quarterly);

        echo '<tbody>';
        while($row = mysql_fetch_array($invoices_a)){
        if ($row['billingFrequency'] == '1' && strtotime($row['invoiceEndDate']) < $monthly || $row['billingFrequency'] == '2' && strtotime($row['invoiceEndDate']) < $quarterly){

        echo '<tr>';
        //echo '<td>'; echo $row['meterId'];echo '</td>';
        //echo '<td>'; echo $row['contractId'];echo '</td>';
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
        echo '<td>'; echo $row['meterAlias'];echo '</td>';
        echo '<td>'; echo $row['invoiceEndDate'];echo '</td>';
        
        
        $invoice_created_date_monthly = strtotime("+35 days", strtotime($row['invoiceEndDate']));
        $invoice_amber_date_monthly = strtotime("+7 days", strtotime($invoice_created_date_monthly));
        $invoice_red_date_monthly = strtotime("+14 days", strtotime($invoice_created_date_monthly));

        $invoice_created_date_quarterly = strtotime("+98 days", strtotime($row['invoiceEndDate']));
        $invoice_amber_date_quarterly = strtotime("+7 days", strtotime($invoice_created_date_quarterly));
        $invoice_red_date_quarterly = strtotime("+14 days", strtotime($invoice_created_date_quarterly));
       
        if ($row['billingFrequency'] == '1' && $now <= $invoice_red_date_monthly && $now >= $invoice_amber_date_monthly){
        echo '<td><div class="invoicing_amber_warning"  title="Task older than 7 days"><img src="images/orange_icon.png" /></div></td>';
        }else if ($row['billingFrequency'] == '1' && $now >= $invoice_red_date_monthly){
            echo '<td><div class="invoicing_red_warning"  title="Task older than 14 days"><img src="images/red_icon.png" /></div></td>';
        }else{
            echo '<td></td>';
        }

        if ($row['billingFrequency'] == '2' && $now <= $invoice_red_date_quarterly && $now >= $invoice_amber_date_quarterly){
        echo '<td><div class="invoicing_amber_warning"  title="Task older than 7 days"><img src="images/orange_icon.png" /></div></td>';
        }else if ($row['billingFrequency'] == '2' && $now >= $invoice_red_date_quarterly){
            echo '<td><div class="invoicing_red_warning"  title="Task older than 14 days"><img src="images/red_icon.png" /></div></td>';
        }else{
            echo '<td><div class="invoicing_green_warning"></div></td>';
        }

        echo '</tr>';
        }
        }
        echo '</tbody></table></div>';

?>


