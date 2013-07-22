<?php

session_save_path('/home/mgmt/httpdocs/sessions');
session_start();

require 'connect.php';
require 'pdfcrowd.php';
require 'setUser.php';

$action = $_GET['form'];


if ($action == 'createpdf'){

$id = $_GET['id'];
$type = $_GET['type'];
$supplier = $_GET['supplier'];
$contract_end_date = $_GET['contractenddate'];
$account_ref = $_GET['accountref'];
$today = $_GET['today'];
$mpan = $_GET['mpan'];

//$not_pdf_query = mysql_query("SELECT * FROM statistics_contract WHERE id=$id") or die ('Error: '.mysql_error ());
//
//        while($row = mysql_fetch_array($not_pdf_query)){
//            $contractEndDate = $row['contract_end_date'];
//        }

// Build the document and merge values.

$not_pdf_doc = '<head></head><body><br /><br /><p>To: ';
$not_pdf_doc .= $supplier;

$not_pdf_doc .= '&nbsp; &nbsp; Date: ';
$not_pdf_doc .= $today;
$not_pdf_doc .= '</p>

<p>Dear Sir/Madam</p>

<p><strong>Notice of Termination of Existing Supply Agreement</strong></p>

<p>Please accept this letter as formal notice of termination of the energy supply agreement for the following supply.</p>

<table border="1" cellspacing="0">
<tr><td><strong>Account</strong></td><td><strong>Supply Number</strong></td><td><strong>Contract End Date</strong></td></tr>
<tr><td>';

$not_pdf_doc .= $account_ref;
$not_pdf_doc .= '</td><td>';
$not_pdf_doc .= $mpan;
$not_pdf_doc .= '</td><td>';
$not_pdf_doc .= $contract_end_date;
$not_pdf_doc .= '</td></tr>
</table>

<p>This termination in no way reflects any dissatisfaction with your service,
   but merely allows us to investigate our options with other potential suppliers.
   Please acknowledge receipt of this notice by return.</p>

<p>Please also note that we are seeking renewal offers for this contract from a variety of suppliers in the market,
and any renewal correspondence should be copied to ourselves.</p>

<p>Yours Sincerely</p>';
$not_pdf_doc .= '</body>';

//try {

// Username and api key below.

//$client = new Pdfcrowd("fourpillar", "f067a7488294fae888fe4e13a8d30d87");

//Set saved file location.

//$location = 'pdf/not-';
//$location .= $id;
//$location .= '.pdf';
//
//  $out_file = fopen("$location", "wb");
//    $client->convertHtml("$not_pdf_doc", $out_file);
//    fclose($out_file);
//
//}
//catch(PdfcrowdException $why) {
//    echo "Can't create PDF: ".$why."\n";
//}

//Spit out the link.

  echo $not_pdf_doc;

  }



  //LOA


  if ($action == 'bulkloa'){
      $ids = $_POST['loaSites'];
      $update_all_as_sent = $_POST['updatesent'];
    
      
      
      
      $ids_for_site_query = implode("', '", $ids);
      
      $get_site_data = mysql_query("SELECT line1, line2, city, county, postcode FROM building_site WHERE id IN ('$ids_for_site_query')");

      $ids2 = $_POST['loaSites'];

      $ids2_for_query = implode(", 1, NOW(), '$username'),(", $ids2);
      $ids2_for_query .= ', 1, NOW(), \'';
      $ids2_for_query .= $username;
      $ids2_for_query .= '\')';
      $ids2_for_query = "(" . $ids2_for_query;

      if ($update_all_as_sent == 'yes'){
          
          $ids_for_query = implode(", 1),(", $ids);
      $ids_for_query .= ', 1)';
      $ids_for_query = "(" . $ids_for_query;

      mysql_query("INSERT INTO xmgnt_task (site_id, sent_supplier)
                                   VALUES $ids_for_query
                                   ON DUPLICATE KEY UPDATE sent_supplier = 1
                              ") or die ('Error: '.mysql_error ());

       mysql_query("INSERT INTO xmgnt_task_history (site_id, event_type, datetime, user)
                                   VALUES $ids2_for_query
                              ") or die ('Error: '.mysql_error ());

      }

    $bulk_loa_doc = '<div align="center">
    <table border="0" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td valign="top" width="494">
                </td>
            </tr>
            <tr>
                <td valign="top" width="494">
                    <h1 align="left">
                    </h1>
                </td>
            </tr>
            <tr>
                <td valign="top" width="494">
                </td>
            </tr>
        </tbody>
    </table>
</div>
<p align="center">
    <strong>LETTER OF AUTHORITY</strong>
</p>
<p>
    <strong>To Whom It May Concern</strong>
</p>
<p>
    This Letter of Authority appoints Zero Trace Procurement Ltd (ZTP), 118 Piccadilly, Mayfair, London, W1J 7NW to represent us as our energy procurement
    supplier, and to place contracts for our managed clients in this case ';

$bulk_loa_doc .= $invoice_address;
        
$bulk_loa_doc .= ' on our behalf. A list of sites for this client can be found at the end of this letter.
</p>
<p>
    <strong>ZTP has our permission to:</strong>
</p>
<p>
    <em>Access and hold data on an electronic database, supplies and information relating to Electricity, Gas and Water</em>
</p>
<p>
    <em>Analyze our and our clients supply data and obtain additional information which may reasonably be required</em>
</p>
<p>
    <em>Receive copy invoices and related documentation</em>
</p>
<p>
    <em>Request and receive billing, payment and debt information, authorise any adjustments, refunds, billing or payment method changes</em>
</p>
<p>
    <em>Give Notice of Termination of Contract</em>
</p>
<p>
    <em>Request quotations, negotiate and place contracts for gas, electricity and water on our behalf, including new supplies and new meters</em>
</p>
<p>
    <em>Act as our representative in these matters</em>
</p>
<p>
    At no time will any information be passed or shared with other companies other than for the purposes of obtaining/investigating/monitoring supplies and/or
    prices on our behalf.
</p>
<p>
    &#x274f; Please tick the box if you do not wish to be contacted by ZTP regarding future product news
</p>
<p>
    <strong>It is understood that:</strong>
</p>
<p>
    We have auditable delegated authority to place energy contracts on behalf of our managed clients which can be provided on request to the energy suppliers.
</p>
<p>
    No contracts will be placed without written contracts signed by ourselves.
</p>
<p>
    Suppliers may make a Credit Check of our clients before or after issuing quotations and any supply agreement will be conditional on a successful credit
    check.
</p>
<p>
    Quotations will be made on the basis that payment for supplies will be by BACs unless otherwise specified.
</p>
<p>
    This LOA is valid for the longer of 12 months from the date signed or the duration of any contract placed under the LOA.
</p>
<p>
    Yours faithfully,
</p>
<p>
    <strong>Signature:</strong>
</p>
<p>
    <strong>Dated:</strong>
</p>
<p>
    <strong>Name:</strong>
</p>
<p>
    <strong>Position:</strong>
</p>
<p>
    <strong> Email Address:</strong>
</p>
';

//      foreach($ids as $loasite){
//          $bulk_loa_doc .= $loasite;
//          $bulk_loa_doc .= '<br />';
//      }

while ($row = mysql_fetch_array($get_site_data)){
    $bulk_loa_doc .= $row['line1'];
    $bulk_loa_doc .= ', ';
    $bulk_loa_doc .= $row['line2'];
    $bulk_loa_doc .= ', ';
    $bulk_loa_doc .= $row['city'];
    $bulk_loa_doc .= ', ';
    $bulk_loa_doc .= $row['county'];
    $bulk_loa_doc .= ', ';
    $bulk_loa_doc .= $row['postcode'];
    $bulk_loa_doc .= '<br />';
}

$bulk_loa_doc .= '</body>';

      

//try {
//
//// Username and api key below.
//
//$client = new Pdfcrowd("fourpillar", "f067a7488294fae888fe4e13a8d30d87");
//
////Set saved file location.
//
//$location = 'pdf/loa';
//$location .= '.pdf';
//
//  $out_file = fopen("$location", "wb");
//    $client->convertHtml("$loa_pdf_doc", $out_file);
//    fclose($out_file);
//
//}
//catch(PdfcrowdException $why) {
//    echo "Can't create PDF: ".$why."\n";
//}

//Spit out the link.

  //echo '<a href="'; echo $location; echo '" />View PDF</a><br />';

echo $bulk_loa_doc;
  


  }


  
  if ($action == 'loa_owner_occupier'){
  
  $loa_owner_occupier_doc = '<div align="center">
    <table border="0" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td valign="top" width="494">
                </td>
            </tr>
            <tr>
                <td valign="top" width="494">
                    <h1 align="left">
                    </h1>
                </td>
            </tr>
            <tr>
                <td valign="top" width="494">
                </td>
            </tr>
        </tbody>
    </table>
</div>
<p align="center">
    <strong>LETTER OF AUTHORITY</strong>
    <em></em>
</p>
<p>
    <strong>To Whom It May Concern</strong>
</p>
<p>
    This Letter of Authority appoints Zero Trace Procurement Ltd (ZTP), 118 Piccadilly, Mayfair, London, W1J 7NW to represent us as our exclusive energy
    procurement supplier.
</p>
<p>
    <strong>ZTP has our permission to:</strong>
</p>
<p>
    <em>Access and hold data on an electronic database, supplies and information relating to Electricity, Gas and Water</em>
</p>
<p>
    <em> </em>
</p>
<p>
    <em>Analyze our supply data and obtain additional information which may reasonably be required</em>
</p>
<p>
    <em> </em>
</p>
<p>
    <em>Receive copy invoices and related documentation</em>
</p>
<p>
    <em> </em>
</p>
<p>
    <em>Request and receive billing, payment and debt information, authorise any adjustments, refunds, billing or payment method changes</em>
</p>
<p>
    <em> </em>
</p>
<p>
    <em>Give Notice of Termination of Contract</em>
</p>
<p>
    <em> </em>
</p>
<p>
    <em>Request quotations, negotiate and place contracts for gas, electricity and water on our behalf, including new supplies and new meters</em>
</p>
<p>
    <em> </em>
</p>
<p>
    <em>Act as our representative in these matters</em>
</p>
<p>
    At no time will any information be passed or shared with other companies other than for the purposes of obtaining/investigating/monitoring supplies and/or
    prices on our behalf.
</p>
<p>
    &#x274f;
    Please tick the box if you do not wish to be contacted by ZTP regarding future product news
</p>
<p>
    <strong>It is understood that:</strong>
</p>
<p>
    <strong> </strong>
</p>
<p>
    No contracts will be placed without written contracts signed by ourselves.
</p>
<p>
    Suppliers may make a Credit Check before or after issuing quotations and any supply agreement will be conditional on a successful credit check
</p>
<p>
    Quotations will be made on the basis that payment for supplies will be by Direct Debit unless otherwise specified
</p>
<p>
    This LOA is valid for the longer of 12 months from the date signed or the duration of any contract placed under the LOA.
</p>
<p>
    Yours faithfully,
</p>
<p>
    <strong>Signature:</strong>
</p>
<p>
    <strong>Dated:</strong>
</p>
<p>
    <strong>Name:</strong>
</p>
<p>
    <strong>Position:</strong>
</p>
<p>
    <strong> Email Address:</strong>
</p>
';
    

$loa_owner_occupier_doc .= '</body>';

echo $loa_owner_occupier_doc; 

  }
  
  if ($action == 'loa_managing_agent'){
      
      $invoice_address = $_GET['invoiceaddress'];
      $line1 = $_GET['line1'];
      $line2 = $_GET['line2'];
      $city = $_GET['city'];
      $county = $_GET['county'];
      $postcode = $_GET['postcode'];
  
$loa_managing_agent_doc = '<div align="center">
    <table border="0" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td valign="top" width="494">
                </td>
            </tr>
            <tr>
                <td valign="top" width="494">
                    <h1 align="left">
                    </h1>
                </td>
            </tr>
            <tr>
                <td valign="top" width="494">
                </td>
            </tr>
        </tbody>
    </table>
</div>
<p align="center">
    <strong>LETTER OF AUTHORITY</strong>
</p>
<p>
    <strong>To Whom It May Concern</strong>
</p>
<p>
    This Letter of Authority appoints Zero Trace Procurement Ltd (ZTP), 118 Piccadilly, Mayfair, London, W1J 7NW to represent us as our energy procurement
    supplier, and to place contracts for our managed clients in this case ';

$loa_managing_agent_doc .= $invoice_address;
        
$loa_managing_agent_doc .= ' on our behalf. This applies to the following site:
</p>
<p>';
$loa_managing_agent_doc .= $line1;
$loa_managing_agent_doc .= ', ';
if (strlen($line2)>0){
$loa_managing_agent_doc .= $line2;
$loa_managing_agent_doc .= ', ';
}
$loa_managing_agent_doc .= $city;
$loa_managing_agent_doc .= ', ';
$loa_managing_agent_doc .= $county;
$loa_managing_agent_doc .= ', ';
$loa_managing_agent_doc .= $postcode;

$loa_managing_agent_doc .= '
</p>
<p>
    <strong>ZTP has our permission to:</strong>
</p>
<p>
    <em>Access and hold data on an electronic database, supplies and information relating to Electricity, Gas and Water</em>
</p>
<p>
    <em>Analyze our and our clients supply data and obtain additional information which may reasonably be required</em>
</p>
<p>
    <em>Receive copy invoices and related documentation</em>
</p>
<p>
    <em>Request and receive billing, payment and debt information, authorise any adjustments, refunds, billing or payment method changes</em>
</p>
<p>
    <em>Give Notice of Termination of Contract</em>
</p>
<p>
    <em>Request quotations, negotiate and place contracts for gas, electricity and water on our behalf, including new supplies and new meters</em>
</p>
<p>
    <em>Act as our representative in these matters</em>
</p>
<p>
    At no time will any information be passed or shared with other companies other than for the purposes of obtaining/investigating/monitoring supplies and/or
    prices on our behalf.
</p>
<p>
    &#x274f; Please tick the box if you do not wish to be contacted by ZTP regarding future product news
</p>
<p>
    <strong>It is understood that:</strong>
</p>
<p>
    We have auditable delegated authority to place energy contracts on behalf of our managed clients which can be provided on request to the energy suppliers.
</p>
<p>
    No contracts will be placed without written contracts signed by ourselves.
</p>
<p>
    Suppliers may make a Credit Check of our clients before or after issuing quotations and any supply agreement will be conditional on a successful credit
    check.
</p>
<p>
    Quotations will be made on the basis that payment for supplies will be by BACs unless otherwise specified.
</p>
<p>
    This LOA is valid for the longer of 12 months from the date signed or the duration of any contract placed under the LOA.
</p>
<p>
    Yours faithfully,
</p>
<p>
    <strong>Signature:</strong>
</p>
<p>
    <strong>Dated:</strong>
</p>
<p>
    <strong>Name:</strong>
</p>
<p>
    <strong>Position:</strong>
</p>
<p>
    <strong> Email Address:</strong>
</p>
';

$loa_managing_agent_doc .= '</body>';

echo $loa_managing_agent_doc; 
            
  }
  
    if ($action == 'cot'){
        
$id = $_GET['id'];
$firstname = $_GET['firstname'];
$site1 = $_GET['site1'];
$outgoingcompany = $_GET['outgoingcompany'];
$forwardpostcode = $_GET['forwardpostcode'];
$newcity = $_GET['newcity'];
$lastname = $_GET['lastname'];
$site2 = $_GET['site2'];
$forwardline1 = $_GET['forwardline1'];
$usercreated = $_GET['usercreated'];
$newcounty = $_GET['newcounty'];
$email = $_GET['email'];
$city = $_GET['city'];
$forwardline2 = $_GET['forwardline2'];
$incomingcompany = $_GET['incomingcompany'];
$newpostcode = $_GET['newpostcode'];
$cot_date = $_GET['cot_date'];
$county = $_GET['county'];
$forwardcity = $_GET['forwardcity'];
$newline1 = $_GET['newline1'];
$newphone = $_GET['newphone'];
$postcode = $_GET['postcode'];
$forwardcounty = $_GET['forwardcounty'];
$newline2 = $_GET['newline2'];
$newemail = $_GET['newemail'];
$accountno = $_GET['accountno'];
$tradingorvacant = $_GET['tradingorvacant'];

$meterquery = mysql_query("SELECT
                           building_changeoftenancymeter.final_meter_reading AS finalReading,
                           statistics_meter.mpan_number AS mpanNumber
                           FROM 
                           building_changeoftenancy
                           INNER JOIN building_changeoftenancymeter ON building_changeoftenancymeter.cot_id=building_changeoftenancy.id
                           INNER JOIN statistics_meter ON statistics_meter.id=building_changeoftenancymeter.existing_meter_id
                           WHERE building_changeoftenancy.id=$id
                           ") or die ('Error: '.mysql_error ());


//        $meterquery = mysql_query("SELECT * FROM building_changeoftenancy WHERE id=$id");
//                     while($row = mysql_fetch_array($meterquery)){
//                        echo $row['new_occupier'];
//                    } 
                    
      $cot_doc = '<table frame="VOID" cellspacing="0" cols="8" rules="NONE" border="1">
    <colgroup>
        <col width="74"/>
        <col width="74"/>
        <col width="287"/>
        <col width="118"/>
        <col width="74"/>
        <col width="74"/>
        <col width="107"/>
        <col width="316"/>
    </colgroup>
    <tbody>
        <tr>
            <td width="74" height="18" align="RIGHT">
                <br/>
            </td>
            <td width="74" align="LEFT">
                <br/>
            </td>
            <td width="287" align="LEFT">
                <br/>
            </td>
            <td width="118" align="RIGHT">
                <br/>
            </td>
            <td width="74" align="LEFT">
                <br/>
            </td>
            <td width="74" align="LEFT">
                <br/>
            </td>
            <td width="107" align="RIGHT">
                <br/>
            </td>
            <td width="316" align="LEFT">
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Information supplied by:
            </td>
            <td align="RIGHT">
                Name:
            </td>
            <td colspan="2" align="LEFT">';
             $cot_doc .= $firstname;
             $cot_doc .= ' ';
             $cot_doc .= $lastname;
             
             $cot_doc .= '
            </td>
            <td align="RIGHT">
                Tel No:
            </td>
            <td align="LEFT">
                +44 (0) 1227 475506
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                <br/>
            </td>
            <td align="RIGHT">
                Company:
            </td>
            <td colspan="5" align="LEFT">
                Zero Trace Procurement Ltd (Broker)
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                <br/>
            </td>
            <td align="RIGHT">
                Email:
            </td>
            <td colspan="5" align="LEFT">';
             $cot_doc .= $email;   
            $cot_doc .= '</td>
        </tr>
        <tr>
            <td height="18" align="RIGHT">
                <br/>
            </td>
            <td align="RIGHT">
                <br/>
            </td>
            <td align="RIGHT">
                <br/>
            </td>
            <td align="RIGHT">
                <br/>
            </td>
            <td align="LEFT">
                <br/>
            </td>
            <td align="LEFT">
                <br/>
            </td>
            <td align="LEFT">
                <br/>
            </td>
            <td align="LEFT">
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Change of tenancy date:
            </td>
            <td colspan="6" align="LEFT">';
                $cot_doc .= ' ';
                $cot_doc .= $cot_date;
                $cot_doc .= '
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Full Site Address:
            </td>
            <td colspan="6" align="LEFT">';
                $cot_doc .= ' ';
                $cot_doc .= $site1;
                $cot_doc .= ', <br />';
                if(strlen($site2)>0){ $cot_doc .= $site2;
                $cot_doc .= ', <br />';}else{}
                $cot_doc .= $city;
                $cot_doc .= ', <br />';
                $cot_doc .= $county;
                $cot_doc .= '
            </td>
        </tr>
        <tr>
            <td colspan="3" rowspan="2" height="37" align="RIGHT">
                <br/>
            </td>
            <td colspan="6" align="LEFT">
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="6" align="LEFT">
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Postcode:
            </td>
            <td colspan="6" align="LEFT">';
                $cot_doc .= $postcode;
                $cot_doc .= '
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Customer Account Number:
            </td>
            <td colspan="6" align="LEFT">
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                MPAN Number:
            </td>
            <td colspan="6" align="LEFT">
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Meter Serial Number(s)
            </td>
            <td colspan="6" align="LEFT">
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                (Please supply all readings
            </td>
            <td colspan="6" align="LEFT">';
             while($row = mysql_fetch_array($meterquery)){
                 $cot_doc .= $row['mpanNumber'];
                 $cot_doc .= ', ';
                 $cot_doc .= $row['finalReading'];
                 $cot_doc .= '<br /> ';
                 
             }   
                $cot_doc .= '
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                from all meters)
            </td>
            <td colspan="6" align="LEFT">
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                <br/>
            </td>
            <td colspan="6" align="LEFT">
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                <br/>
            </td>
            <td colspan="6" align="LEFT">
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="9" height="18" align="CENTER">
                <strong><em>Outgoing Customer</em></strong>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Company Name:
            </td>
            <td colspan="6" align="LEFT">';
                $cot_doc .= ' ';
                $cot_doc .= $outgoingcompany;
                $cot_doc .= '
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Forwarding Address:
            </td>
            <td colspan="6" align="LEFT">';
                $cot_doc .= ' ';
                $cot_doc .= $forwardline1;
                $cot_doc .= ', <br />';
                if(strlen($forwardline2)>1){
                $cot_doc .= $forwardline2;
                $cot_doc .= ', <br />';  
                }
                $cot_doc .= $forwardcity;
                $cot_doc .= ', <br />';
                $cot_doc .= $forwardcounty;
                $cot_doc .= '
                
            </td>
        </tr>
        <tr>
            <td colspan="3" rowspan="2" height="37" align="RIGHT">
                <br/>
            </td>
            <td colspan="6" align="LEFT">
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="6" align="LEFT">
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Postcode:
            </td>
            <td colspan="6" align="LEFT">';
                $cot_doc .= ' ';
                $cot_doc .= $forwardpostcode;
                $cot_doc .= '
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Contact Name:
            </td>
            <td colspan="6" align="LEFT">';
                $cot_doc .= ' ';
                $cot_doc .= $firstname;
                $cot_doc .= ' ';
                $cot_doc .= $lastname;
                
              $cot_doc .= '  
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Telephone Number:
            </td>
            <td colspan="6" align="LEFT">
                +44 (0) 1227 475506
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Email address:
            </td>
            <td colspan="6" align="LEFT">';
              
                $cot_doc .= ' ';
                $cot_doc .= $email;
                $cot_doc .= '
            </td>
        </tr>
        <tr>
            <td height="18" align="RIGHT">
                <br/>
            </td>
            <td align="RIGHT">
                <br/>
            </td>
            <td align="RIGHT">
                <br/>
            </td>
            <td align="LEFT">
                <br/>
            </td>
            <td align="LEFT">
                <br/>
            </td>
            <td align="LEFT">
                <br/>
            </td>
            <td align="LEFT">
                <br/>
            </td>
            <td align="LEFT">
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="9" height="18" align="CENTER">
                <strong><em>Incoming Customer</em></strong>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Company Name:
            </td>
            <td colspan="6" align="LEFT">';
                $cot_doc .= ' ';
                $cot_doc .= $incomingcompany;
                $cot_doc .= '
                
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Registration No (If Ltd):
            </td>
            <td colspan="6" align="LEFT">
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Sole Trader Name (If not Ltd):
            </td>
            <td colspan="6" align="LEFT">
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Billing Address:
            </td>
            <td colspan="6" align="LEFT">';
                $cot_doc .= ' ';
                $cot_doc .= $newline1;
                $cot_doc .= ', <br />';
                if (strlen($newline2)>0){$cot_doc .= $newline2;
                $cot_doc .= ', <br />';}
                $cot_doc .= $newcity;
                $cot_doc .= ', <br />';
                $cot_doc .= $newcounty;
                $cot_doc .= '
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                (If different to site address)
            </td>
            <td colspan="6" align="LEFT">
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                <br/>
            </td>
            <td colspan="6" align="LEFT">
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Postcode:
            </td>
            <td colspan="6" align="LEFT">';
                $cot_doc .= ' ';
                $cot_doc .= $newpostcode;
                $cot_doc .= '
                
                
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Contact Name:
            </td>
            <td colspan="6" align="LEFT">;
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Phone Number:
            </td>
            <td colspan="6" align="LEFT">';
                $cot_doc .= ' ';
                $cot_doc .= $newphone;
                $cot_doc .= '
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Email Address:
            </td>
            <td colspan="6" align="LEFT">';
                $cot_doc .= ' ';
                $cot_doc .= $newemail;
                $cot_doc .= '
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Sole Trader Home Address:
            </td>
            <td colspan="6" align="LEFT">
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="LEFT">
                <br/>
            </td>
            <td colspan="6" align="LEFT">
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="LEFT">
                <br/>
            </td>
            <td colspan="6" align="LEFT">
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Postcode:
            </td>
            <td colspan="6" align="LEFT">
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                <strong>
                    <br/>
                </strong>
            </td>
            <td align="LEFT">
                <br/>
            </td>
            <td align="LEFT">
                <br/>
            </td>
            <td align="LEFT">
                <br/>
            </td>
            <td align="LEFT">
                <br/>
            </td>
            <td align="LEFT">
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                Will the site be trading or vacant?
            </td>
            <td colspan="6" align="LEFT">';
                if ($tradingorvacant == 1){ $cot_doc .= ' Trading';} else
                if ($tradingorvacant == 2){ $cot_doc .= ' Vacant';}
            
                $cot_doc .='
                <br/>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="18" align="RIGHT">
                <br/>
            </td>
            <td colspan="6" align="LEFT">
                <br/>
            </td>
        </tr>
    </tbody>
</table>
';

      echo $cot_doc;
  }
?>



