<?php
// Task Grid (Sales)      ----------------------------------------
        echo '<div id="salesTask">';
        echo '<div class="sectionHeader">Sales Tasks <div class="sectionHeaderRight">';

        if ($mode != 'archive'){
              echo '<a href = "javascript:void(0)" onclick = "document.getElementById(\'newsaleslight\').style.display=\'block\';
              document.getElementById(\'newsalesfade\').style.display=\'block\'" class="mediumButton">New Task</a>';}echo'</div></div>';

        //Query here

        if ($mode == 'archive'){
            if ($master_sales_super_user == '1'){
         $sales_task_a = mysql_query("SELECT * FROM xsales_task WHERE complete=1 ") or die ('Error: '.mysql_error ());
        }else if($master_access_sales == '1'){
         $sales_task_a = mysql_query("SELECT * FROM xsales_task WHERE complete=1 AND user_created=$master_user_id ") or die ('Error: '.mysql_error ());
        }
        }else
        if ($master_sales_super_user == '1'){
         $sales_task_a = mysql_query("SELECT * FROM xsales_task WHERE complete=0 ") or die ('Error: '.mysql_error ());
        }else if($master_access_sales == '1'){
         $sales_task_a = mysql_query("SELECT * FROM xsales_task WHERE complete=0 AND user_created=$master_user_id ") or die ('Error: '.mysql_error ());
        }
                echo '<div id="newsaleslight" class="white_content">
                      <strong>Create Sales Task</strong><br />
                      <form action="sales.php?form=newtask" method="post">
                      <div class="label">Client </div>
                      <select class="input" name="client">';
                      foreach($new_client_b as $clientname){
                      echo '<option value="'; echo $clientname; echo '">'; echo $clientname; echo '</option>';
                      }
                      echo '</select><br />
                      <div class="label">Account Manager </div><input type="text" class="input" name="account_manager"/><br />
                      <div class="label">Task Owner </div><input type="text" class="input" name="task_owner"/><br />
                      <div class="label">Summary </div><input type="text" class="input" name="summary"/><br />
                      <div class="label">Due Date </div><input type="text" class="input" id="datepicker" name="due_date"/><br />
                      <div class="label">Notes </div><textarea rows="3" cols="35" name="notes"></textarea>
                      <input type="hidden" name="user" value="'; echo $master_user_id; echo '">
                      <input type="submit" name="submit" value="Create" class="formButton"> </form>';

        echo '<a href = "javascript:void(0)" onclick = "document.getElementById(\'newsaleslight\').style.display=\'none\';
              document.getElementById(\'newsalesfade\').style.display=\'none\'" class="mediumButton">Close</a></div>
              
              <div id="newsalesfade" class="black_overlay"></div>';

        echo '<table class="grid tablesorter">
              <thead><tr>
              <th>Client</th>
              <th>Account Manager</th>
              <th>Task Owner</th>
              <th>Summary</th>
              <th>Due Date</th>
              <th>Notes</th>';
              if ($mode == 'archive'){
              echo '<th>Date completed</th>';
              echo '<th>Completed by</th>';
              echo '<th class="not-sortable"></th>';
              }else{
              echo'
              <th class="not-sortable"></th>
              <th class="not-sortable"></th>
              <th class="not-sortable"></th>';
              }
              echo '</tr></thead>';

        echo '<tbody>';
        $i = 1;
        while($row = mysql_fetch_array($sales_task_a))
        {
        echo '<tr>';

        echo '<td>'; echo $row['client'];echo '</td>';
        echo '<td>'; echo $row['account_manager'];echo '</td>';
        echo '<td>'; echo $row['task_owner'];echo '</td>';
        echo '<td>'; echo $row['summary'];echo '</td>';
        echo '<td>'; echo $row['due_date'];echo '</td>';
        echo '<td>'; echo $row['notes'];echo '</td>';
        if ($mode == 'archive'){
        echo '<td>'; echo $row['datetime_completed'];echo '</td>';
        echo '<td>'; echo $row['user_completed'];echo '</td>';
        }
        if ($mode != 'archive'){
        echo '<td><a href = "javascript:void(0)" onclick = "document.getElementById(\'editsaleslight';
        echo $i; echo '\').style.display=\'block\';
             document.getElementById(\'editsalesfade'; echo $i;
             echo '\').style.display=\'block\'" class="mediumButton">Edit</a></td>';

        echo '<td><a href="sales.php?form=donetask&id='; echo $row['id']; echo '">
              <img src="images/complete.png" alt="Mark complete"/></a></td>';

        $sales_task_amber_date = strtotime("-7 days", strtotime($row['due_date']));

        if ($now <= strtotime($row['due_date']) && $now >= $sales_task_amber_date){
        echo '<td><img src="images/orange_icon.png" /></td>';
        } else if ($now >= strtotime($row['due_date'])){
        echo '<td><img src="images/red_icon.png" /></td>';
        } else {
            echo '<td></td>';
        }
        }else{
        echo '<td><a href="sales.php?form=retrieve&type=task&id='; echo $row['id']; echo'">Retrieve</a></td>';
        }
        echo '</tr>';

        //test
                echo '<div id="editsaleslight'; echo $i; echo'" class="white_content">
                      <strong>Edit Sales Task</strong>
                      <form action="sales.php?form=edittask&id='; echo $row['id']; echo'" method="post">
                      <div class="label">Client </div>
                      <select class="input" name="client">';
                      foreach($new_client_b as $clientname){
                      echo '<option'.($clientname==$row['client']? ' selected' : '').'>'; echo $clientname; echo '</option>';
                      }
                      echo '</select><br />
                      <div class="label">Account Manager </div><input type="text" class="input" name="account_manager" value="'; echo $row['account_manager']; echo '"/><br />
                      <div class="label">Task Owner </div><input type="text" class="input" name="task_owner" value="'; echo $row['task_owner']; echo '"/><br />
                      <div class="label">Summary </div><input type="text" class="input" name="summary" value="'; echo $row['summary']; echo '"/><br />
                      <div class="label">Due Date </div><input type="text" class="input" id="datepicker'; echo $i;  echo'" name="due_date" value="'; echo $row['due_date']; echo '"/><br />
                      <div class="label">Notes </div><textarea rows="10" cols="35" name="notes">'; echo $row['notes']; echo'</textarea>
                      <input type="submit" name="submit" value="Edit" class="formButton"> </form>


        <a href = "javascript:void(0)" onclick = "document.getElementById(\'editsaleslight'; echo $i; echo '\').style.display=\'none\';document.getElementById(\'editsalesfade'; echo $i; echo '\').style.display=\'none\'" class="mediumButton">Close</a></div>
        <div id="editsalesfade'; echo $i; echo'" class="black_overlay"></div>';
        
        $i ++;
        }
        
        echo '</tbody></table></div>';

?>
