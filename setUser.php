<?php

//Get these from session.

//$session_user_id = '2';
//$username = 'AlexHill';

$username = $_SESSION['myusername'];
$session_user_id = $_SESSION['myuserid'];

//Set access parameters for the rest of the application.

$query_user_info = mysql_query("SELECT email, firstname, lastname, username, access_mgnt, access_sales, mgnt_super_user, sales_super_user, tier, manager
                    FROM xadmin_user
                    WHERE trace_user_id=$session_user_id
                    ") or die ('Error: '.mysql_error ());

while($row = mysql_fetch_array($query_user_info)){

                                $master_user_id = $session_user_id;
                                $master_username = $row['username'];
                                $master_access_mgnt = $row['access_mgnt'];
                                $master_access_sales = $row['access_sales'];
                                $master_mgnt_super_user = $row['mgnt_super_user'];
                                $master_sales_super_user = $row['sales_super_user'];
                                $master_tier = $row['tier'];
                                $master_manager = $row['manager'];
                                $master_email = $row['email'];
                                $master_firstname = $row['firstname'];
                                $master_lastname = $row['lastname'];
                        }

                 //  $change_user_view = $_GET['form'];

//                   if ($change_user_view == simulateview){
//                       $simulate_view = '1';
//                       $simulation_id = $_POST['id'];
//
//
//                     $find_username = mysql_query("SELECT username FROM xadmin_user WHERE trace_user_id=$simulation_id") or die ('Error: '.mysql_error ());
//
//                     while($row=  mysql_fetch_array($find_username)){
//                     $simulation_username = $row['username'];
//                   }
//                   }



?>