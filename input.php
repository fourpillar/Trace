<?php

// check to see if form has been submitted
$action = $_GET['form'];

                    //Update sent/not sent for supplier. Both task table and task history table.

                    if ($action == 'updatesent'){

                        $id = $_GET['id'];
                        $value = $_GET['value'];
                        $category = $_GET['type'];
                        if($category == 'not'){
                         $type = 'contract_id';
                         $task = 1;
                        }else if($category == 'loa'){
                         $type = 'site_id';
                         $task = 2;
                        }else if($category == 'cot'){
                         $type = 'cot_id';
                         $task = 3;
                        }

                      mysql_query("INSERT INTO xmgnt_task ($type, task_type, sent_supplier, sent_supplier_timestamp)
                                   VALUES ($id, $task, $value, NOW())
                                   ON DUPLICATE KEY UPDATE sent_supplier = $value, task_type = $task, sent_supplier_timestamp = NOW()
                              ") or die ('Error: '.mysql_error ());

                      mysql_query("INSERT INTO xmgnt_task_history ($type, event_type, datetime, user)
                                   VALUES ($id, $value, NOW(), '$username')
                              ") or die ('Error: '.mysql_error ());

                    $complete = TRUE;
                    }

                     if ($action == 'updatesentclient'){

                        $id = $_GET['id'];
                        $value = $_GET['value'];
                        $category = $_GET['type'];
                        if($category == 'not'){
                         $type = 'contract_id';
                         $task = 1;
                        }else if($category == 'loa'){
                         $type = 'site_id';
                         $task = 2;
                        }else if($category == 'cot'){
                         $type = 'cot_id';
                         $task = 3;
                        }

                      mysql_query("INSERT INTO xmgnt_task ($type, task_type, sent_client, sent_client_timestamp)
                                   VALUES ($id, $task, $value, NOW())
                                   ON DUPLICATE KEY UPDATE sent_client = $value, task_type = $task, sent_client_timestamp = NOW()
                              ") or die ('Error: '.mysql_error ());

                      mysql_query("INSERT INTO xmgnt_task_history ($type, event_type, datetime, user)
                                   VALUES ($id, $value, NOW(), '$username')
                              ") or die ('Error: '.mysql_error ());

                    $complete = TRUE;
                    }

                    // Update notes. Both task table and task history table.

                    if ($action == 'addnote'){

                        $id = $_GET['id'];
                        $value = mysql_real_escape_string($_POST['notes']);
                        $category = $_GET['type'];


                        if($category == 'not'){
                         $type = 'contract_id';
                         $task = 1;
                        }else if($category == 'loa'){
                         $type = 'site_id';
                         $task = 2;
                        }else if($category == 'cot'){
                         $type = 'cot_id';
                         $task = 3;
                        }else if($category == 'proc'){
                         $type = 'proc_contract_id';
                         $task = 4;
                         $mark_complete = $_POST['is_task_done'];
                        }



                      mysql_query("INSERT INTO xmgnt_task ($type, notes)
                                   VALUES ('$id', '$value')
                                   ON DUPLICATE KEY UPDATE notes = VALUES(notes)
                              ") or die ('Error: '.mysql_error ());

                      mysql_query("INSERT INTO xmgnt_task_history ($type, event_type, datetime, user)
                                   VALUES ('$id', 4, NOW(), '$username')
                              ") or die ('Error: '.mysql_error ());


                      if (strlen($mark_complete)>1){
                      mysql_query("INSERT INTO xmgnt_task ($type, task_type, task_status, edit_note_timestamp, user_closed)
                                   VALUES ('$id', 4, 1, NOW(), '$username')
                                   ON DUPLICATE KEY UPDATE task_status = 1, task_type = 4, edit_note_timestamp=NOW(), user_closed = '$username'
                              ") or die ('Error: '.mysql_error ());


                    }
                    $complete = TRUE;
                    }

                    // Update todo

                    if ($action == 'addtodo'){

                        $task = $_POST['task'];
                        $client = $_POST['client'];
                        $due = $_POST['due'];

                        mysql_query("INSERT INTO xmgnt_todo (task, client, due_date, complete, user, datetime_created)
                                     VALUES ('$task', '$client', '$due', 0, '$username', NOW())")or die ('Error: '.mysql_error ());

                    }

                    if ($action == 'edittodo'){

                        $id = $_GET['id'];
                        $task = $_POST['task'];
                        $client = $_POST['client'];
                        $due = $_POST['due'];

                        mysql_query("UPDATE xmgnt_todo SET task = '$task', client='$client', due_date = '$due'
                                     WHERE id=$id ")or die ('Error: '.mysql_error ());

                    }

                    if ($action == 'donetodo'){

                        $id = $_GET['id'];

                        mysql_query("UPDATE xmgnt_todo SET complete=1, datetime_completed=NOW() WHERE id=$id")or die ('Error: '.mysql_error ());

                    }

                    if ($action == 'retrievetodo'){

                        $id = $_GET['id'];

                        mysql_query("UPDATE xmgnt_todo SET complete=0 WHERE id=$id")or die ('Error: '.mysql_error ());

                    }

                    if ($action == 'removedoc'){

                        $id = $_GET['id'];
                        $category = $_GET['type'];
                        if($category == 'not'){
                         $type = 'contract_id';
                        }else if($category == 'loa'){
                         $type = 'site_id';
                        }else if($category == 'cot'){
                         $type = 'cot_id';
                        }else if($category == 'archive'){
                         $type = 'id';
                        }
                        
                        if ($category = 'archive'){
                        mysql_query("UPDATE xmgnt_task SET doc_path=NULL, task_status=0 WHERE $type=$id")or die ('Error: '.mysql_error ());
                        }
                        
                        if ($category != 'archive'){
                        mysql_query("INSERT INTO xmgnt_task_history ($type, event_type, datetime, user)
                                   VALUES ('$id', 6, NOW(), '$username')
                              ") or die ('Error: '.mysql_error ());
                        }

                    }

                    if ($action == 'edituser'){

                        $id = $_GET['id'];
                        $clients = $_POST['clientAccess'];
                        $access_mgnt = (isset($_POST['access_mgnt'])) ? 1 : 0;
                        $access_sales = (isset($_POST['access_sales'])) ? 1 : 0;
                        $mgnt_super_user = (isset($_POST['mgnt_super_user'])) ? 1 : 0;
                        $sales_super_user = (isset($_POST['sales_super_user'])) ? 1 : 0;
                        $tier = $_POST['tier'];
                        $manager = $_POST['manager'];
                        $username = $_POST['username'];
                        $email = $_POST['email'];
                        $firstname = $_POST['firstname'];
                        $lastname = $_POST['lastname'];

                        if (strlen($_POST['newpassword']) > 3){
                            $password = md5($_POST['newpassword']);}else{
                                $password = $_POST['existingpassword'];
                            }

                                 mysql_query("INSERT INTO xadmin_user (trace_user_id, access_mgnt, access_sales, mgnt_super_user, sales_super_user, tier, manager, username, email, password, firstname, lastname)
                                   VALUES ('$id', $access_mgnt, $access_sales, $mgnt_super_user, $sales_super_user, $tier, $manager, '$username', '$email', '$password', '$firstname', '$lastname')
                                   ON DUPLICATE KEY UPDATE access_mgnt = $access_mgnt, access_sales = $access_sales, mgnt_super_user = $mgnt_super_user, sales_super_user = $sales_super_user, tier = $tier, manager = $manager, 
                                                           username = '$username', email = '$email', password = '$password', firstname = '$firstname', lastname = '$lastname'
                                          ") or die ('Error: '.mysql_error ());

                                  mysql_query("DELETE FROM xadmin_user_access WHERE trace_user_id=$id
                                          ") or die ('Error: '.mysql_error ());



                              foreach($clients as $clients_input){
                                  mysql_query("INSERT INTO xadmin_user_access (trace_user_id, client_id) VALUES ($id, $clients_input)
                                          ") or die ('Error: '.mysql_error ());
                              }


                    }
                    
                    if ($action == 'notsent'){
                        $id = $_GET['id'];
                        
                    }
                    
//                    if ($action == 'notsent'){
//                        $id = $_GET['id'];
//                    }

?>