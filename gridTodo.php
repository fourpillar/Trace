<?php
//To do Grid --------------------------------------------
        echo '<div id="todo-grid">';
        echo '<div class="sectionHeader">Task List <div class="sectionHeaderRight">

            <a href = "javascript:void(0)" onclick = "document.getElementById(\'light\').style.display=\'block\';
            document.getElementById(\'fade\').style.display=\'block\'" class="mediumButton">Create task</a>

            <a href = "javascript:void(0)" onclick = "document.getElementById(\'light2\').style.display=\'block\';
            document.getElementById(\'fade2\').style.display=\'block\'" class="mediumButton">Task Archive</a></div></div>';

        echo '<div id="light" class="white_content">

              <form action="mgnt.php?form=addtodo" method="post">
              <div class="label">Task </div><input type="text" class="input" name="task"/><br />
              <div class="label">Client </div>
              <select class="input" name="client">';
              foreach($client_access_names_b as $clientname){
              echo '<option value="'; echo $clientname; echo '">'; echo $clientname; echo '</option>';
              }
              echo '</select><br />
              <div class="label">Due </div><input type="text" class="input" id="datepicker" name="due"/><br />

              <input type="submit" name="submit" value="Add" class="formButton">
              </form>


        <a href = "javascript:void(0)" onclick = "document.getElementById(\'light\').style.display=\'none\';document.getElementById(\'fade\').style.display=\'none\'" class="mediumButton">Close</a></div>
        <div id="fade" class="black_overlay"></div>';

// Main 'to do' query
        if ($_SESSION['mode'] == 'sim'){
        $todo_a = mysql_query("SELECT * FROM xmgnt_todo WHERE user='" . $_SESSION['sim_username'] . "' ORDER BY complete DESC, due_date ASC ");
        }else{

        $todo_a = mysql_query("SELECT * FROM xmgnt_todo WHERE user='$master_username' ORDER BY complete DESC, due_date ASC ");
        }

        //WHERE user='$username'

        
        echo '<table class="grid tablesorter"><thead><tr><th>Task</th><th>Client</th><th>Due Date</th><th class="not-sortable"></th><th class="not-sortable"></th><th class="not-sortable"></th></tr><thead>';
        echo '<tbody>';
        echo '<div id="light2" class="white_content"><a href = "javascript:void(0)" onclick = "document.getElementById(\'light2\').style.display=\'none\';document.getElementById(\'fade2\').style.display=\'none\'" class="mediumButton">Close</a><br /><br /><div id="todoArchive">';
        $i = 1;
       
        while($row = mysql_fetch_array($todo_a))
        {
        if($row['complete'] == 0){

        echo '<tr class="row-vm">';
        echo '<td>'; echo $row['task'];echo '</td>';
        echo '<td>'; echo $row['client'];echo '</td>';
        echo '<td>'; echo $row['due_date'];echo '</td>';
        echo '<td><a href="#" class="show_hide smallButton" rel="#todo_sliding_div_'; echo $i; echo'">+</a></td>';


        echo '<td><a href="mgnt.php?form=donetodo&id='; echo $row['id']; echo '"><img src="images/complete.png" alt="Mark complete"/></a></td>';
        
        echo '<td>'; setWarning($row['due_date'], '7', 'todo'); echo '</td>';
        


        echo '</tr>';
        echo '<tr class="row-details expand-child"><td colspan="6"><style>#todo_sliding_div_'; echo $i;
        echo '{display:none;}</style>
              <div id="todo_sliding_div_'; echo $i; echo'">

         <script language="JavaScript" type="text/javascript">
        $(function() {
            $("#editdatepicker'; echo $i; echo'").datepicker({dateFormat: \'yy-mm-dd\'});
        });
        </script>

              <form action="mgnt.php?form=edittodo&id='; echo $row['id']; echo'" method="post">
              Task <input type="text" class="input" name="task" value="'; echo $row['task']; echo '"/>
              Client

              <select class="input" name="client">';
              foreach($client_access_names_b as $clientname){
              echo '<option'.($clientname==$row['client']? ' selected' : '').'>'; echo $clientname; echo '</option>';
              }
              echo '</select>
                  
              Due <input type="text" class="input" id="editdatepicker'; echo $i; echo'" name="due" value="'; echo $row['due_date']; echo '"/><br />

              <input type="submit" name="submit" value="Edit" class="formButton">
              </form>

              </div></td>


              </tr>';}
          $i ++;

         if($row['complete'] == 1){
              echo $row['task']; echo ', '; echo $row['client']; echo ' ,'; echo 'completed on <i>'; echo $row['datetime_completed']; echo '</i>';
              echo '<a href="mgnt.php?form=retrievetodo&id='; echo $row['id']; echo '" class="mediumButton">Retrieve</a><br /><br />';
         }
                  }


                          echo'</div></div>
        <div id="fade2" class="black_overlay">';

                          echo '</tbody></table></div>';


?>
