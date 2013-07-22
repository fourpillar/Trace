<?php
session_save_path('/home/mgmt/httpdocs/sessions');
session_start();

require('connect.php');

$username = $_SESSION['myusername'];
$session_user_id = $_SESSION['myuserid'];

$change_user_view = $_GET['form'];

        if ($change_user_view == simulateview){

                       if ($_POST['id'] == $session_user_id){

                         $_SESSION['mode'] = 'normal';
                         
                         header("location:mgnt.php");
                         
                       }else if (strlen ($_POST['id'])>0){


                       $_SESSION['mode'] = 'sim';
                       $_SESSION['sim_id'] = $_POST['id'];


                     $find_username = mysql_query("SELECT username FROM xadmin_user WHERE trace_user_id='" . $_SESSION['sim_id'] . "'") or die ('Error: '.mysql_error ());

                         while($row=  mysql_fetch_array($find_username)){
                         $_SESSION['sim_username'] = $row['username'];
                         }
                         
                         header("location:mgnt.php");
                         
                   }
       }
       
       
?>
