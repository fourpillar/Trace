<?php
// Sales Opportunity Grid      ----------------------------------------
        echo '<div id="salesOpp">';
        echo '<div class="sectionHeader">Sales Opportunities <div class="sectionHeaderRight">';
        if ($mode != 'archive'){
         echo '<a href = "javascript:void(0)" onclick = "document.getElementById(\'newopplight\').style.display=\'block\';
              document.getElementById(\'newoppfade\').style.display=\'block\'" class="mediumButton">New Opportunity</a>';} echo'</div></div>';

        //Query here

        if ($mode == 'archive'){
        if ($master_sales_super_user == '1'){
         $sales_opp_a = mysql_query("SELECT * FROM xsales_opportunity WHERE complete=1 ") or die ('Error: '.mysql_error ());
        }else if ($master_access_sales == '1'){
         $sales_opp_a = mysql_query("SELECT * FROM xsales_opportunity WHERE complete=1 AND user_created=$master_user_id") or die ('Error: '.mysql_error ());
        }

        }else
        if ($master_sales_super_user == '1'){
         $sales_opp_a = mysql_query("SELECT * FROM xsales_opportunity WHERE complete=0 ") or die ('Error: '.mysql_error ());
        }else if ($master_access_sales == '1'){
         $sales_opp_a = mysql_query("SELECT * FROM xsales_opportunity WHERE complete=0 AND user_created=$master_user_id") or die ('Error: '.mysql_error ());
        }



                echo '<div id="newopplight" class="white_content">
                      <strong>Create Sales Opportunity</strong><br />
                      <form action="sales.php?form=newopp" method="post">
                      <div class="label">Client </div>
                      <select class="input" name="client">';
                      foreach($new_client_b as $clientname){
                      echo '<option value="'; echo $clientname; echo '">'; echo $clientname; echo '</option>';
                      }
                      echo '</select><br />

                      <div class="label">Account Manager </div>
                      <input type="text" class="input" name="account_manager"/><br />

                      <div class="label">Introducer </div>
                      <select class="input" name="introducer">';
                      foreach($introducer_b as $introducername){
                      echo '<option value="'; echo $introducername; echo '">'; echo $introducername; echo '</option>';
                      }
                      echo '</select><br />

                      <div class="label">Value (£)</div><input type="text" class="input" name="value"/><br />
                      
                      <div class="label">Stage </div>
                      <select class="input" name="stage">
                      <option value="1">No Contact</option>
                      <option value="2">Closed. No interest</option>
                      <option value="3">Interested</option>
                      <option value="4">Had meeting</option>
                      <option value="5">Trial</option>
                      <option value="6">Proposal sent</option>
                      <option value="7">Follow up</option>
                      <option value="8">Agreed in principle</option>
                      <option value="9">Contract negotiation</option>
                      <option value="10">Close - Won</option>
                      </select><br />
                      
                      <div class="label">Opportunity Summary<br /> <i>(50 chars max)</i><div id="limit-counter1" class="limit-counter"></div></div>
                      <textarea rows="3" cols="35" name="opp_summary" data-maxsize="50" data-output="limit-counter1"></textarea>
                      <br />
                      <div class="label">Terms Summary <br /><i>(50 chars max)</i><div id="limit-counter2" class="limit-counter"></div></div>
                      <textarea rows="3" cols="35" name="terms_summary" data-maxsize="50" data-output="limit-counter2"></textarea>
                      <br />
                      <div class="label">Next Task <br /><i>(50 chars max)</i><div id="limit-counter3" class="limit-counter"></div></div>
                      <textarea rows="3" cols="35" name="next_task" data-maxsize="50" data-output="limit-counter3"></textarea>
                      <br />
                      <div class="label">Probablity (%)</div><input type="text" class="input" name="probability"/><br />
                      <div class="label">Start Date if won</div><input type="text" class="input" id="datepickeropp" name="start_date"/><br />
                      <div class="label">Notes </div><textarea rows="3" cols="35" name="notes"></textarea>
                      <input type="hidden" name="user" value="'; echo $master_user_id; echo '">
                      <input type="submit" name="submit" value="Create" class="formButton"> </form>';

        echo '<a href = "javascript:void(0)" onclick = "document.getElementById(\'newopplight\').style.display=\'none\';
              document.getElementById(\'newoppfade\').style.display=\'none\'" class="mediumButton">Close</a></div>

              <div id="newoppfade" class="black_overlay"></div>';

        echo '<table class="grid tablesorter">
              <thead><tr>
              <th>Client</th>
              <th>Account Manager</th>
              <th>Introducer</th>
              <th>Value</th>
              <th>Stage</th>
              <th>Opportunity Summary</th>
              <th>Probability</th>
              <th>Terms Summary</th>
              <th>Next Task</th>
              <th>Start Date (if won)</th>
              <th>Notes</th>';
              if ($mode == 'archive'){
              echo '<th>Date completed</th>';
              echo '<th>Completed by</th>';
              echo '<th class="not-sortable"></th>';
              }else{
              echo'
              <th class="not-sortable"></th>
              <th class="not-sortable"></th>
              </tr></thead>';
              }
        echo '<tbody>';
        $i = 1;
        while($row = mysql_fetch_array($sales_opp_a))
        {
        echo '<tr>';

        echo '<td>'; echo $row['client'];echo '</td>';
        echo '<td>'; echo $row['account_manager'];echo '</td>';
        echo '<td>'; echo $row['introducer'];echo '</td>';
        echo '<td>'; echo $row['value'];echo '</td>';


        //$stage = $row['stage'];
        echo '<td><strong>'; opportunityStage($row['stage']); echo '</strong></td>';
        echo '<td>'; echo $row['opportunity_summary'];echo '</td>';
        echo '<td>'; echo $row['probability'];echo '</td>';
        echo '<td>'; echo $row['terms_summary'];echo '</td>';
        echo '<td>'; echo $row['next_task'];echo '</td>';
        echo '<td>'; echo $row['start_date'];echo '</td>';
        echo '<td>'; echo $row['notes'];echo '</td>';
        if ($mode == 'archive'){
        echo '<td>'; echo $row['datetime_completed'];echo '</td>';
        echo '<td>'; echo $row['user_completed'];echo '</td>';
        }
        if ($mode != 'archive'){
        echo '<td><a href = "javascript:void(0)" onclick = "document.getElementById(\'editopplight';
        echo $i; echo '\').style.display=\'block\';
             document.getElementById(\'editoppfade'; echo $i;
             echo '\').style.display=\'block\'" class="mediumButton">Edit</a></td>';

        echo '<td><a href="sales.php?form=doneopp&id='; echo $row['id']; echo '">
              <img src="images/complete.png" alt="Mark complete"/></a></td>';
        }else{
        echo '<td><a href="sales.php?form=retrieve&type=opp&id='; echo $row['id']; echo'">Retrieve</a></td>';
        }

        echo '</tr>';

        //test
                echo '<div id="editopplight'; echo $i; echo'" class="white_content">
                      <strong>Edit Sales Opportunity</strong>
                      <form action="sales.php?form=editopp&id='; echo $row['id']; echo'" method="post">
                      <div class="label">Client </div>
                      <select class="input" name="client">';
                      foreach($new_client_b as $clientname){
                      echo '<option'.($clientname==$row['client']? ' selected' : '').'>'; echo $clientname; echo '</option>';
                      }
                      echo '</select><br />

                      <div class="label">Account Manager </div>
                      <select class="input" name="account_manager">';
                      foreach($account_manager_b as $accountmanagername){
                      echo '<option'.($accountmanagername==$row['account_manager']? ' selected' : '').'>'; echo $accountmanagername; echo '</option>';
                      }
                      echo '</select><br />

                      <div class="label">Introducer </div>
                      <select class="input" name="introducer">';
                      foreach($introducer_b as $introducername){
                      echo '<option'.($introducername==$row['introducer']? ' selected' : '').'>'; echo $introducername; echo '</option>';
                      }
                      echo '</select><br />

                      <div class="label">Value (£)</div><input type="text" class="input" name="value" value="'; echo $row['value']; echo '"/><br />

                      <div class="label">Stage </div>
                      <select class="input" name="stage">
                      <option value="1">No Contact</option>
                      <option value="2">Closed. No interest</option>
                      <option value="3">Interested</option>
                      <option value="4">Had meeting</option>
                      <option value="5">Trial</option>
                      <option value="6">Proposal sent</option>
                      <option value="7">Follow up</option>
                      <option value="8">Agreed in principle</option>
                      <option value="9">Contract negotiation</option>
                      <option value="10">Close - Won</option>
                      </select><br />

                      <div class="label">Opportunity Summary<br /> <i>(50 chars max)</i><div id="limit-counter-a-'; echo $i; echo'" class="limit-counter"></div></div>
                      <textarea rows="3" cols="35" name="opp_summary" data-maxsize="50" data-output="limit-counter-a-'; echo $i; echo '">'; echo $row['opportunity_summary']; echo'</textarea>
                      <br />
                      <div class="label">Terms Summary <br /><i>(50 chars max)</i><div id="limit-counter-b-'; echo $i; echo'" class="limit-counter"></div></div>
                      <textarea rows="3" cols="35" name="terms_summary" data-maxsize="50" data-output="limit-counter-b-'; echo $i; echo '">'; echo $row['terms_summary']; echo'</textarea>
                      <br />
                      <div class="label">Next Task <br /><i>(50 chars max)</i><div id="limit-counter-c-'; echo $i; echo'" class="limit-counter"></div></div>
                      <textarea rows="3" cols="35" name="next_task" data-maxsize="50" data-output="limit-counter-c-'; echo $i; echo '">'; echo $row['next_task']; echo'</textarea>
                      <br />
                      <div class="label">Probablity (%)</div><input type="text" class="input" name="probability" value="'; echo $row['probability']; echo '"/><br />
                      <div class="label">Start Date if won</div><input type="text" class="input" id="datepickeropp'; echo $i; echo'" name="start_date" value="'; echo $row['start_date']; echo '"/><br />
                      <div class="label">Notes </div><textarea rows="3" cols="35" name="notes">'; echo $row['notes']; echo'</textarea>
                      <input type="submit" name="submit" value="Edit" class="formButton"> </form>


        <a href = "javascript:void(0)" onclick = "document.getElementById(\'editopplight'; echo $i; echo '\').style.display=\'none\';document.getElementById(\'editoppfade'; echo $i; echo '\').style.display=\'none\'" class="mediumButton">Close</a></div>
        <div id="editoppfade'; echo $i; echo'" class="black_overlay"></div>';

        $i ++;
        }

        echo '</tbody></table></div>';

?>
