<?php
// Contact Manager - Clients Grid      ----------------------------------------
        echo '<div class="sectionHeaderContact">Manage Clients <div class="sectionHeaderRight">
              <a href = "javascript:void(0)" onclick = "document.getElementById(\'newclientlight\').style.display=\'block\';
              document.getElementById(\'newclientfade\').style.display=\'block\'" class="mediumButton">New client</a></div></div>';

        $sales_client_a = mysql_query("SELECT * FROM xsales_client WHERE active=1") or die ('Error: '.mysql_error ());

        echo '<div id="newclientlight" class="white_content">
              <strong>Create New Client</strong><br />
              <form action="salesContacts.php?form=newclient" method="post">
              <div class="label">Name </div><input type="text" class="input" name="name"/><br />
              <div class="label">Address 1 </div><input type="text" class="input" name="address_1"/><br />
              <div class="label">Address 2 </div><input type="text" class="input" name="address_2"/><br />
              <div class="label">Postcode </div><input type="text" class="input" name="postcode"/><br />
              <div class="label">Main Tel. </div><input type="text" class="input" name="main_tel"/><br />
              <div class="label">Primary Contact </div><input type="text" class="input" name="primary_contact"/><br />
              <div class="label">Position </div><input type="text" class="input" name="pri_position"/><br />
              <div class="label">Primary Telephone </div><input type="text" class="input" name="primary_tel"/><br />
              <div class="label">Primary Mobile </div><input type="text" class="input" name="primary_mob"/><br />
              <div class="label">Primary email </div><input type="text" class="input" name="primary_email"/><br />
              <div class="label">Secondary Contact </div><input type="text" class="input" name="secondary_contact"/><br />
              <div class="label">Position </div><input type="text" class="input" name="sec_position"/><br />
              <div class="label">Secondary Telephone </div><input type="text" class="input" name="secondary_tel"/><br />
              <div class="label">Secondary Mobile </div><input type="text" class="input" name="secondary_mob"/><br />
              <div class="label">Secondary email </div><input type="text" class="input" name="secondary_email"/><br />
              <div class="label">Sector </div><select class="input" name="sector">'; listSector(); echo'</select><br />
              <div class="label">Number of sites </div><input type="text" class="input" name="no_sites"/><br />
              <div class="label">Number of meters </div><input type="text" class="input" name="no_meters"/><br />
              <div class="label">Introducer </div><select class="input" name="introducer">'; listIntroducer(); echo'</select><br />
              <div class="label">Notes </div><textarea rows="10" cols="35" name="notes"></textarea>
              <input type="submit" name="submit" value="Add" class="formButton">
              </form>

              <a href = "javascript:void(0)" onclick = "document.getElementById(\'newclientlight\').style.display=\'none\';
              document.getElementById(\'newclientfade\').style.display=\'none\'" class="mediumButton">Close</a></div>
              <div id="newclientfade" class="black_overlay"></div>';



        echo '<table class="grid tablesorter">
              <thead><tr>
              <th>Name</th>
              <th>Add. 1</th>
              <th>Add. 2</th>
              <th>Postcode</th>
              <th>Main Tel.</th>
              <th>Primary Contact</th>
              <th>Position</th>
              <th>Primary Tel.</th>
              <th>Primary Mob.</th>
              <th>Primary email</th>
              <th>Secondary Contact</th>
              <th>Position</th>
              <th>Secondary Tel.</th>
              <th>Secondary Mob.</th>
              <th>Secondary email</th>
              <th>Sector</th>
              <th>No. Sites</th>
              <th>No. Meters</th>
              <th>Introducer</th>
              <th>Date Added</th>
              <th>Notes</th>
              <th class="not-sortable"></th>
              <th class="not-sortable"></th>
              </tr></thead>';

        echo '<tbody>';



        $i = 1;
        while($row = mysql_fetch_array($sales_client_a))
        {
        echo '<tr>';
        echo '<td>'; echo $row['name'];echo '</td>';
        echo '<td>'; echo $row['address_line_1'];echo '</td>';
        echo '<td>'; echo $row['address_line_2'];echo '</td>';
        echo '<td>'; echo $row['postcode'];echo '</td>';
        echo '<td>'; echo $row['main_tel'];echo '</td>';    
        echo '<td>'; echo $row['pri_contact_name'];echo '</td>';
        echo '<td>'; echo $row['pri_position'];echo'</td>';
        echo '<td>'; echo $row['pri_contact_tel'];echo '</td>';
        echo '<td>'; echo $row['pri_contact_mob'];echo '</td>';
        echo '<td>'; echo $row['pri_contact_email'];echo '</td>';
        echo '<td>'; echo $row['sec_contact_name'];echo '</td>';
        echo '<td>'; echo $row['sec_position'];echo '</td>';
        echo '<td>'; echo $row['sec_contact_tel'];echo '</td>';
        echo '<td>'; echo $row['sec_contact_mob'];echo '</td>';
        echo '<td>'; echo $row['sec_contact_email'];echo '</td>';
        echo '<td>'; sectorName($row['sector']); echo '</td>';
        echo '<td>'; echo $row['no_sites'];echo '</td>';
        echo '<td>'; echo $row['no_meters']; echo '</td>';
        echo '<td>'; introducerName($row['introducer']); echo '</td>';
        echo '<td>'; echo $row['datetime_added'];echo '</td>';
        echo '<td>'; echo $row['notes'];echo '</td>';
        echo '<td><a href = "javascript:void(0)" onclick = "document.getElementById(\'editclientlight';
        echo $i; echo '\').style.display=\'block\';
             document.getElementById(\'editclientfade'; echo $i;
             echo '\').style.display=\'block\'" class="mediumButton">Edit</a></td>';

        echo '<td><a href="salesContacts.php?form=deleteclient&id='; echo $row['id']; echo '"><img src="images/delete_icon.png" alt="Delete"/></a></td>';
        echo '</tr>

        <div id="editclientlight'; echo $i; echo'" class="white_content">
                      <strong>Edit Client</strong>
                      <form action="salesContacts.php?form=editclient&id='; echo $row['id']; echo'" method="post">
                      <div class="label">Name </div><input type="text" class="input" name="name" value="'; echo $row['name']; echo'"/><br />
                      <div class="label">Address 1 </div><input type="text" class="input" name="address_1" value="'; echo $row['address_line_1']; echo'"/><br />
                      <div class="label">Address 2 </div><input type="text" class="input" name="address_2" value="'; echo $row['address_line_2']; echo'"/><br />
                      <div class="label">Postcode </div><input type="text" class="input" name="postcode" value="'; echo $row['postcode']; echo'"/><br />
                      <div class="label">Main Tel. </div><input type="text" class="input" name="main_tel" value="'; echo $row['main_tel']; echo'"/><br />
                      <div class="label">Primary Contact </div><input type="text" class="input" name="primary_contact" value="'; echo $row['pri_contact_name']; echo'"/><br />
                      <div class="label">Position </div><input type="text" class="input" name="pri_position" value="'; echo $row['pri_position']; echo'"/><br />
                      <div class="label">Primary Telephone </div><input type="text" class="input" name="primary_tel" value="'; echo $row['pri_contact_tel']; echo'"/><br />
                      <div class="label">Primary Mobile </div><input type="text" class="input" name="primary_mob" value="'; echo $row['pri_contact_mob']; echo'"/><br />
                      <div class="label">Primary email </div><input type="text" class="input" name="primary_email" value="'; echo $row['pri_contact_email']; echo'"/><br />
                      <div class="label">Secondary Contact </div><input type="text" class="input" name="secondary_contact" value="'; echo $row['sec_contact_name']; echo'"/><br />
                      <div class="label">Position </div><input type="text" class="input" name="sec_position" value="'; echo $row['sec_position']; echo'"/><br />
                      <div class="label">Secondary Telephone </div><input type="text" class="input" name="secondary_tel" value="'; echo $row['sec_contact_tel']; echo'"/><br />
                      <div class="label">Secondary Mobile </div><input type="text" class="input" name="secondary_mob" value="'; echo $row['sec_contact_mob']; echo'"/><br />
                      <div class="label">Secondary email </div><input type="text" class="input" name="secondary_email" value="'; echo $row['sec_contact_email']; echo'"/><br />
                      <div class="label">Sector </div><select class="input" name="sector">'; listSector($row['sector']); echo'</select><br />
                      <div class="label">Number of sites </div><input type="text" class="input" name="no_sites" value="'; echo $row['no_sites']; echo'"/><br />
                      <div class="label">Number of meters </div><input type="text" class="input" name="no_meters" value="'; echo $row['no_meters']; echo'"/><br />
                      <div class="label">Introducer </div><select class="input" name="introducer">'; listIntroducer($row['introducer']); echo'</select><br />
                      <div class="label">Notes </div><textarea rows="10" cols="35" name="notes">'; echo $notes; echo'</textarea>
                      <input type="submit" name="submit" value="Edit" class="formButton">
                      </form>

        <a href = "javascript:void(0)" onclick = "document.getElementById(\'editclientlight'; echo $i; echo '\').style.display=\'none\';document.getElementById(\'editclientfade'; echo $i; echo '\').style.display=\'none\'" class="mediumButton">Close</a></div>
        <div id="editclientfade'; echo $i; echo'" class="black_overlay"></div>';
        $i ++; }
        echo '</tbody></table>';




?>
