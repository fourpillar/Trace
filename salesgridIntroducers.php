<?php
// Contact Manager - Introducer Grid      ----------------------------------------
        echo '<div class="sectionHeaderContact">Manage Introducers<div class="sectionHeaderRight">
              <a href = "javascript:void(0)" onclick = "document.getElementById(\'newintroducerlight\').style.display=\'block\';
              document.getElementById(\'newintroducerfade\').style.display=\'block\'" class="mediumButton">New Introducer</a></div></div>';

        $sales_introducer_a = mysql_query("SELECT * FROM xsales_introducer WHERE active=1 ") or die ('Error: '.mysql_error ());

        echo '<div id="newintroducerlight" class="white_content">
              <strong>Create Sales Introducer</strong><br />
              <form action="salesContacts.php?form=newintroducer" method="post">
              <div class="label">Name </div><input type="text" class="input" name="name"/><br />
              <div class="label">Address 1 </div><input type="text" class="input" name="address_1"/><br />
              <div class="label">Address 2 </div><input type="text" class="input" name="address_2"/><br />
              <div class="label">Postcode </div><input type="text" class="input" name="postcode"/><br />
              <div class="label">Main Tel. </div><input type="text" class="input" name="main_tel"/><br />
              <div class="label">Primary Contact </div><input type="text" class="input" name="primary_contact"/><br />
              <div class="label">Primary Telephone </div><input type="text" class="input" name="primary_tel"/><br />
              <div class="label">Primary Mobile </div><input type="text" class="input" name="primary_mob"/><br />
              <div class="label">Primary email </div><input type="text" class="input" name="primary_email"/><br />
              <div class="label">Secondary Contact </div><input type="text" class="input" name="secondary_contact"/><br />
              <div class="label">Secondary Telephone </div><input type="text" class="input" name="secondary_tel"/><br />
              <div class="label">Secondary Mobile </div><input type="text" class="input" name="secondary_mob"/><br />
              <div class="label">Secondary email </div><input type="text" class="input" name="secondary_email"/><br />
              <div class="label">Commission Level </div><input type="text" class="input" name="commission_level"/><br />
              <div class="label">Notes </div><textarea rows="10" cols="35" name="notes"></textarea>
              <input type="submit" name="submit" value="Add" class="formButton">
              </form>

              <a href = "javascript:void(0)" onclick = "document.getElementById(\'newintroducerlight\').style.display=\'none\';
              document.getElementById(\'newintroducerfade\').style.display=\'none\'" class="mediumButton">Close</a></div>
              <div id="newintroducerfade" class="black_overlay"></div>';



        echo '<table class="grid tablesorter">
              <thead><tr>
              <th>Name</th>
              <th>Add. 1</th>
              <th>Add. 2</th>
              <th>Postcode</th>
              <th>Main Tel.</th>
              <th>Primary Contact</th>
              <th>Primary Tel.</th>
              <th>Primary Mob.</th>
              <th>Primary email</th>
              <th>Secondary Contact</th>
              <th>Secondary Tel.</th>
              <th>Secondary Mob.</th>
              <th>Secondary email</th>
              <th>Commission Level</th>
              <th>Notes</th>
              <th class="not-sortable"></th>
              <th class="not-sortable"></th>
              </tr></thead>';

        echo '<tbody>';
        $i = 1;
        while($row = mysql_fetch_array($sales_introducer_a))
        {
        echo '<tr>';
        echo '<td>'; echo $row['name'];echo '</td>';
        echo '<td>'; echo $row['address_line_1'];echo '</td>';
        echo '<td>'; echo $row['address_line_2'];echo '</td>';
        echo '<td>'; echo $row['postcode'];echo '</td>';
        echo '<td>'; echo $row['main_tel'];echo '</td>';
        echo '<td>'; echo $row['pri_contact_name'];echo '</td>';
        echo '<td>'; echo $row['pri_contact_tel'];echo '</td>';
        echo '<td>'; echo $row['pri_contact_mob'];echo '</td>';
        echo '<td>'; echo $row['pri_contact_email'];echo '</td>';
        echo '<td>'; echo $row['sec_contact_name'];echo '</td>';
        echo '<td>'; echo $row['sec_contact_tel'];echo '</td>';
        echo '<td>'; echo $row['sec_contact_mob'];echo '</td>';
        echo '<td>'; echo $row['sec_contact_email'];echo '</td>';
        echo '<td>'; echo $row['commission_level'];echo '</td>';
        echo '<td>'; echo $row['notes'];echo '</td>';
        echo '<td><a href = "javascript:void(0)" onclick = "document.getElementById(\'editintrolight';
        echo $i; echo '\').style.display=\'block\';
             document.getElementById(\'editintrofade'; echo $i;
             echo '\').style.display=\'block\'" class="mediumButton">Edit</a></td>';
             
        echo '<td><a href="salesContacts.php?form=deleteintroducer&id='; echo $row['id']; echo '"><img src="images/delete_icon.png" alt="Delete"/></a></td>';
        echo '</tr>
        
        <div id="editintrolight'; echo $i; echo'" class="white_content">
                      <strong>Edit Sales Opportunity</strong>
                      <form action="salesContacts.php?form=editintro&id='; echo $row['id']; echo'" method="post">
                      <div class="label">Name </div><input type="text" class="input" name="name" value="'; echo $row['name']; echo'"/><br />
                      <div class="label">Address 1 </div><input type="text" class="input" name="address_1" value="'; echo $row['address_line_1']; echo'"/><br />
                      <div class="label">Address 2 </div><input type="text" class="input" name="address_2" value="'; echo $row['address_line_2']; echo'"/><br />
                      <div class="label">Postcode </div><input type="text" class="input" name="postcode" value="'; echo $row['postcode']; echo'"/><br />
                      <div class="label">Main Tel. </div><input type="text" class="input" name="main_tel" value="'; echo $row['main_tel']; echo'"/><br />
                      <div class="label">Primary Contact </div><input type="text" class="input" name="primary_contact" value="'; echo $row['pri_contact_name']; echo'"/><br />
                      <div class="label">Primary Telephone </div><input type="text" class="input" name="primary_tel" value="'; echo $row['pri_contact_tel']; echo'"/><br />
                      <div class="label">Primary Mobile </div><input type="text" class="input" name="primary_mob" value="'; echo $row['pri_contact_mob']; echo'"/><br />
                      <div class="label">Primary email </div><input type="text" class="input" name="primary_email" value="'; echo $row['pri_contact_email']; echo'"/><br />
                      <div class="label">Secondary Contact </div><input type="text" class="input" name="secondary_contact" value="'; echo $row['sec_contact_name']; echo'"/><br />
                      <div class="label">Secondary Telephone </div><input type="text" class="input" name="secondary_tel" value="'; echo $row['sec_contact_tel']; echo'"/><br />
                      <div class="label">Secondary Mobile </div><input type="text" class="input" name="secondary_mob" value="'; echo $row['sec_contact_mob']; echo'"/><br />
                      <div class="label">Secondary email </div><input type="text" class="input" name="secondary_email" value="'; echo $row['sec_contact_email']; echo'"/><br />
                      <div class="label">Commission Level </div><input type="text" class="input" name="commission_level" value="'; echo $row['commission_level']; echo'"/><br />
                      <div class="label">Notes </div><textarea rows="10" cols="35" name="notes">'; echo $row['notes']; echo'</textarea>
                      <input type="submit" name="submit" value="Edit" class="formButton">
                      </form>

        <a href = "javascript:void(0)" onclick = "document.getElementById(\'editintrolight'; echo $i; echo '\').style.display=\'none\';document.getElementById(\'editintrofade'; echo $i; echo '\').style.display=\'none\'" class="mediumButton">Close</a></div>
        <div id="editintrofade'; echo $i; echo'" class="black_overlay"></div>';
        $i ++; }
        echo '</tbody></table>';
?>
