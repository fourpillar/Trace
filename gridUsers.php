<?php
// Task Grid (Sales)      ----------------------------------------
        echo '<div class="sectionHeaderContact">User Administration </div>';

        //Query here

         $user_list = mysql_query("SELECT 
             auth_user.id AS traceUserId,
             auth_user.first_name AS firstName,
             auth_user.last_name AS lastName,
             auth_user.username AS username,
             auth_user.email AS email,
             auth_user.is_superuser AS superuser,
             xadmin_user.id AS mgntUserId,
             xadmin_user.access_mgnt AS accessMgnt,
             xadmin_user.access_sales AS accessSales,
             xadmin_user.mgnt_super_user AS mgntSuperUser,
             xadmin_user.sales_super_user AS salesSuperUser,
             xadmin_user.password AS existingPassword,
             xadmin_user.tier AS tier,
             xadmin_user.manager AS manager
             FROM auth_user
             LEFT JOIN xadmin_user ON xadmin_user.trace_user_id=auth_user.id
            WHERE is_active=1 AND is_staff=1
            ") or die ('Error: '.mysql_error ());

               $user_access = mysql_query("SELECT client_id, trace_user_id FROM xadmin_user_access") or die ('Error: '.mysql_error ());

            while($row = mysql_fetch_array($user_access)){
                        $user_access_list[] = array("client_id"=>$row['client_id'],"trace_user_id"=>$row['trace_user_id']);
                        }

        echo '<table class="grid tablesorter">
              <thead><tr>
              <th>Email</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>S/User</th>
              <th>Management Access</th>
              <th>Sales Access</th>
              <th>Management S/User</th>
              <th>Sales S/User</th>
              <th>Tier</th>
              <th>Manager</th>
              <th class="not-sortable"></th>
              </tr></thead>';

        echo '<tbody>';
        $i = 1;
        while($row = mysql_fetch_array($user_list))
        {
        echo '<tr>';
        echo '<td>'; echo $row['email'];echo '</td>';
        echo '<td>'; echo $row['firstName'];echo '</td>';
        echo '<td>'; echo $row['lastName'];echo '</td>';

        if ($row['superuser'] == 1){echo '<td>&#10004;</td>';}else{ echo '<td>&#10008;</td>'; };
        if ($row['accessMgnt'] == 1){echo '<td>&#10004;</td>';}else{ echo '<td>&#10008;</td>'; };
        if ($row['accessSales'] == 1){echo '<td>&#10004;</td>';}else{ echo '<td>&#10008;</td>'; };
        if ($row['mgntSuperUser'] == 1){echo '<td>&#10004;</td>';}else{ echo '<td>&#10008;</td>'; };
        if ($row['salesSuperUser'] == 1){echo '<td>&#10004;</td>';}else{ echo '<td>&#10008;</td>'; };

        echo '<td>'; echo $row['tier'];echo '</td>';
        if (isset($row['manager'])){
        echo '<td>'; managerName($row['manager']); echo '</td>';
        }else{ echo '<td>Not set.</td>';}

        echo '<td><a href = "javascript:void(0)" onclick = "document.getElementById(\'edituserlight';
        echo $i; echo '\').style.display=\'block\';
             document.getElementById(\'edituserfade'; echo $i;
             echo '\').style.display=\'block\'" class="mediumButton">Edit</a></td>
            </tr>';

        //test
                echo '<div id="edituserlight'; echo $i; echo'" class="white_content">
                      <strong>Edit User</strong>
                      <form action="mgntAdmin.php?form=edituser&id='; echo $row['traceUserId']; echo'" method="post">
                      <div class="label">Access Management? </div><input type="checkbox"';    isCheckedUserAdmin($row['accessMgnt']); echo 'name="access_mgnt" value="1"><br /><br />
                      <div class="label">Access Sales? </div><input type="checkbox"';    isCheckedUserAdmin($row['accessSales']); echo 'name="access_sales" value="1"><br /><br />
                      <div class="label">Management S/User? </div><input type="checkbox"';    isCheckedUserAdmin($row['mgntSuperUser']); echo 'name="mgnt_super_user" value="1"><br /><br />
                      <div class="label">Sales S/User? </div><input type="checkbox"';    isCheckedUserAdmin($row['salesSuperUser']); echo 'name="sales_super_user" value="1"><br /><br />
                      
                      <div class="label">Tier </div>
                      <select class="input" name="tier">
                      <option'.($row['tier']=="1"? ' selected' : '').'>1</option>
                      <option'.($row['tier']=="2"? ' selected' : '').'>2</option>
                      <option'.($row['tier']=="3"? ' selected' : '').'>3</option>
                      </select><br />';


                      
                          

                          echo'
                      <div class="label">Manager </div>
                      <select class="input" name="manager">';
                      listManager($row['manager']);
                      echo '</select><br />
                        <div class="label">Change password only</div><input type="text" class="input" name="newpassword" /><br />
                        <br /><strong>Client Access</strong> (no need to use if Management Superuser...)<br />';

                        foreach($full_client_list_b as $client){
                            echo $client['name']; echo '<input type="checkbox"'; isCheckedClientAccess($client['id'], $row['traceUserId']); echo' name="clientAccess[]" value="'; echo $client['id']; echo'"><br />';
                        }

                        echo '<input type="hidden" name="username" value="'; echo $row['username']; echo '" />';
                        echo '<input type="hidden" name="firstname" value="'; echo $row['firstName']; echo '" />';
                        echo '<input type="hidden" name="lastname" value="'; echo $row['lastName']; echo '" />';
                        echo '<input type="hidden" name="email" value="'; echo $row['email']; echo '" />';
                        echo '<input type="hidden" name="existingpassword" value="'; echo $row['existingPassword']; echo '" />';
                     echo' <br /> <input type="submit" name="submit" value="Edit" class="formButton"> </form>


        <a href = "javascript:void(0)" onclick = "document.getElementById(\'edituserlight'; echo $i; echo '\').style.display=\'none\';document.getElementById(\'edituserfade'; echo $i; echo '\').style.display=\'none\'" class="mediumButton">Close</a></div>
        <div id="edituserfade'; echo $i; echo'" class="black_overlay"></div>';

        $i ++;
        }

        echo '</tbody></table>';



?>
