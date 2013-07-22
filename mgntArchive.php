<?php

// Trace Management application. Written by James Blackburn 2013.

require('header.php');

require('connect.php');
require('setUser.php');
require('setParams.php');
require('functions.php');
require ('input.php');

        $cot_archive = mysql_query("SELECT
        company_company.name AS companyName,
        company_portfolio.title AS portfolioName,
        building_site.site_ref AS siteReference,
        xmgnt_task.sent_supplier_timestamp AS sentDateTime,
        xmgnt_task.doc_path AS docPath,
        xmgnt_task.id AS taskId,
        xmgnt_task.doc_path_timestamp AS docPathTimestamp
        FROM
        xmgnt_task
        INNER JOIN building_changeoftenancy ON building_changeoftenancy.id=xmgnt_task.cot_id
        INNER JOIN building_site ON building_site.id=building_changeoftenancy.site_id
        INNER JOIN company_portfolio ON company_portfolio.id=building_site.portfolio_id
        INNER JOIN company_company ON company_company.id=company_portfolio.company_id
        WHERE company_portfolio.company_id IN ('$client_access_c')
        AND xmgnt_task.task_type=3
        AND xmgnt_task.sent_supplier=1
        AND xmgnt_task.doc_path IS NOT NULL
        ") or die ('Error: '.mysql_error ());

        $not_archive = mysql_query("SELECT
        company_company.name AS companyName,
        company_portfolio.title AS portfolioName,
        building_site.site_ref AS siteReference,
        statistics_contract.account_reference AS accountRef,
        statistics_meter.alias AS meterAlias,
        statistics_meter.mpan_number AS mpanNumber,
        xmgnt_task.sent_supplier AS isSent,
        xmgnt_task.sent_supplier_timestamp AS sentDateTime,
        xmgnt_task.doc_path AS docPath,
        xmgnt_task.doc_path_timestamp AS docPathTimestamp,
        xmgnt_task.id AS taskId,
        xmgnt_task.task_type AS taskType
        FROM statistics_contract
        LEFT JOIN xmgnt_task ON xmgnt_task.contract_id=statistics_contract.id
        LEFT JOIN statistics_meterreading ON statistics_meterreading.meter_id=statistics_contract.meter_id
        INNER JOIN statistics_meter ON statistics_meter.id=statistics_contract.meter_id
        INNER JOIN building_site ON building_site.id=statistics_meter.building_id
        INNER JOIN company_portfolio ON company_portfolio.id=building_site.portfolio_id
        INNER JOIN company_company ON company_company.id=company_portfolio.company_id
        WHERE company_portfolio.company_id IN ('$client_access_c')
        AND xmgnt_task.task_type=1
        AND xmgnt_task.sent_supplier=1
        AND xmgnt_task.doc_path IS NOT NULL
        ") or die ('Error: '.mysql_error ());
 
        $loa_archive = mysql_query("SELECT
        company_company.name AS companyName,
        company_portfolio.title AS portfolioName,
        building_site.id AS siteId,
        building_site.site_ref AS siteReference,
        xmgnt_task.sent_supplier_timestamp AS sentDateTime,
        xmgnt_task.sent_client_timestamp AS sentClientDateTime,
        xmgnt_task.doc_path AS docPath,
        xmgnt_task.id AS taskId,
        xmgnt_task.doc_path_timestamp AS docPathTimestamp
        FROM building_site
        LEFT JOIN xmgnt_task ON xmgnt_task.site_id=building_site.id
        INNER JOIN company_portfolio ON company_portfolio.id=building_site.portfolio_id
        INNER JOIN company_company ON company_company.id=company_portfolio.company_id
        WHERE company_portfolio.company_id IN ('$client_access_c')
        AND xmgnt_task.task_type=2
        AND xmgnt_task.sent_supplier=1
        AND xmgnt_task.sent_client=8
        AND xmgnt_task.doc_path IS NOT NULL
        ") or die ('Error: '.mysql_error ());
        
        $proc_archive = mysql_query("SELECT
        company_company.name AS companyName,
        company_portfolio.title AS portfolioName,
        building_site.site_ref AS siteReference,
        statistics_contract.account_reference AS accountRef,
        statistics_meter.alias AS meterAlias,
        statistics_meter.mpan_number AS mpanNumber,
        xmgnt_task.user_closed AS userClosed,
        xmgnt_task.edit_note_timestamp AS editNoteTimestamp,
        xmgnt_task.doc_path AS docPath,
        xmgnt_task.doc_path_timestamp AS docPathTimestamp,
        xmgnt_task.id AS taskId,
        xmgnt_task.task_type AS taskType
        FROM
        xmgnt_task 
        INNER JOIN statistics_contract on statistics_contract.id=xmgnt_task.proc_contract_id
        INNER JOIN statistics_meter ON statistics_meter.id=statistics_contract.meter_id
        INNER JOIN building_site ON building_site.id=statistics_meter.building_id
        INNER JOIN company_portfolio ON company_portfolio.id=building_site.portfolio_id
        INNER JOIN company_company ON company_company.id=company_portfolio.company_id
        WHERE company_portfolio.company_id IN ('$client_access_c')
        AND xmgnt_task.task_type=4
        AND xmgnt_task.task_status=1
        ") or die ('Error: '.mysql_error ());

//Visible page starts here

echo '<div id="topBlock">

<div id="traceLogo"><a href="mgnt.php"><img src="images/trace_mgnt_logo.png" /></a></div>';

        echo '<div id="viewPicker">You are viewing the Trace Management <strong>Archive</strong> | Go back to <a href="mgnt.php">Trace Management</a>
              <br /><br /><strong>Note:</strong> Removing a document or marking not sent will unarchive the task.
              </div>
              </div>';

echo '<div class="sectionHeader">COT <strong>Archive</strong></a></div>';

echo '<table class="grid tablesorter">
        <thead>
        <tr>
        <th>Client</th>
        <th>Portfolio</th>
        <th>Site Name</th>
        <th>Date Sent</th>
        <th>Date Received</th>
        <th>Document</th>
        <th class="not-sortable"></th>
        </tr>
        </thead>

        <tbody>';

while($row = mysql_fetch_array($cot_archive)){

echo '<tr>';
echo '<td>'; echo $row['companyName']; echo '</td>';
echo '<td>'; echo $row['portfolioName']; echo '</td>';
echo '<td>'; echo $row['siteReference']; echo '</td>';
echo '<td>'; echo $row['sentDateTime']; echo '</td>';
echo '<td>'; echo $row['docPathTimestamp']; echo '</td>';
echo '<td><a href="upload/'; echo $row['docPath'];  echo '">View Document</a></td>';
echo '<td>
    <a href="mgntArchive.php?form=removedoc&type=archive&id='; echo $row['taskId']; echo'" class="mediumButton">Remove document</a>
        </td>';
echo '</tr>';
}
echo '</tbody></table>';

echo '<div class="sectionHeader">NOT <strong>Archive</strong></a></div>';

echo '<table class="grid tablesorter">
        <thead>
        <tr>
        <th>Client</th>
        <th>Portfolio</th>
        <th>Site Name</th>
        <th>Account Ref</th>
        <th>Mpan</th>
        <th>Meter</th>
        <th>Date Sent</th>
        <th>Date Received</th>
        <th>Document</th>
        <th class="not-sortable"></th>
        </tr>
        </thead>

        <tbody>';

while($row = mysql_fetch_array($not_archive)){

echo '<tr>';
echo '<td>'; echo $row['companyName']; echo '</td>';
echo '<td>'; echo $row['portfolioName']; echo '</td>';
echo '<td>'; echo $row['siteReference']; echo '</td>';
echo '<td>'; echo $row['accountRef']; echo '</td>';
echo '<td>'; echo $row['mpanNumber']; echo '</td>';
echo '<td>'; echo $row['meterAlias']; echo '</td>';
echo '<td>'; echo $row['sentDateTime']; echo '</td>';
echo '<td>'; echo $row['docPathTimestamp']; echo '</td>';
echo '<td><a href="upload/'; echo $row['docPath'];  echo '">View Document</a></td>';
echo '<td>
    <a href="mgntArchive.php?form=removedoc&type=archive&id='; echo $row['taskId']; echo'" class="mediumButton">Remove document</a>
        </td>';
echo '</tr>';
}
echo '</tbody></table>';

echo '<div class="sectionHeader">LOA <strong>Archive</strong></a></div>';

echo '<table class="grid tablesorter">
        <thead>
        <tr>
        <th>Client</th>
        <th>Portfolio</th>
        <th>Site Name</th>
        <th>Date Sent (Supplier)</th>
        <th>Date Sent (Client)</th>
        <th>Date Received</th>
        <th>Document</th>
        <th class="not-sortable"></th>
        </tr>
        </thead>

        <tbody>';

while($row = mysql_fetch_array($loa_archive)){

echo '<tr>';
echo '<td>'; echo $row['companyName']; echo '</td>';
echo '<td>'; echo $row['portfolioName']; echo '</td>';
echo '<td>'; echo $row['siteReference']; echo '</td>';
echo '<td>'; echo $row['sentDateTime']; echo '</td>';
echo '<td>'; echo $row['sentClientDateTime']; echo '</td>';
echo '<td>'; echo $row['docPathTimestamp']; echo '</td>';
echo '<td><a href="upload/'; echo $row['docPath'];  echo '">View Document</a></td>';
echo '<td>
    <a href="mgntArchive.php?form=removedoc&type=archive&id='; echo $row['taskId']; echo'" class="mediumButton">Remove document</a>
        </td>';
echo '</tr>';
}
echo '</tbody></table>';

echo '<div class="sectionHeader">Procurement Confirmation <strong>Archive</strong></a></div>';

echo '<table class="grid tablesorter">
        <thead>
        <tr>
        <th>Client</th>
        <th>Portfolio</th>
        <th>Site Name</th>
        <th>Account Ref</th>
        <th>Mpan</th>
        <th>Meter</th>
        <th>Date (if closed via note)</th>
        <th>Closed by (if closed via note)</th>
        <th>Document Upload on</th>
        <th>Document</th>
        <th class="not-sortable"></th>
        </tr>
        </thead>

        <tbody>';

while($row = mysql_fetch_array($proc_archive)){

echo '<tr>';
echo '<td>'; echo $row['companyName']; echo '</td>';
echo '<td>'; echo $row['portfolioName']; echo '</td>';
echo '<td>'; echo $row['siteReference']; echo '</td>';
echo '<td>'; echo $row['accountRef']; echo '</td>';
echo '<td>'; echo $row['mpanNumber']; echo '</td>';
echo '<td>'; echo $row['meterAlias']; echo '</td>';
echo '<td>'; echo $row['editNoteTimestamp']; echo '</td>';
echo '<td>'; echo $row['userClosed']; echo '</td>';
echo '<td>'; echo $row['docPathTimestamp']; echo '</td>';
if (isset($row['docPath'])){
echo '<td><a href="upload/'; echo $row['docPath'];  echo '">View Document</a></td>';
}else{
echo '<td>No Document</td>';    
}
echo '<td>
    <a href="mgntArchive.php?form=removedoc&type=archive&id='; echo $row['taskId']; echo'" class="mediumButton">Remove document</a>
        </td>';
echo '</tr>';
}
echo '</tbody></table>';

//Include footer
require('footer.html');
?>

