<?php
include("connect.php");

$customfilename = $_POST['filename'];
$type = $_POST['type'];
$sent_client = $_POST['sentclient'];

$allowedExts = array("gif", "jpeg", "jpg", "png", "pdf", "doc");
$extension = end(explode(".", $_FILES["file"]["name"]));
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
|| ($_FILES["file"]["type"] == "application/msword")
|| ($_FILES["file"]["type"] == "application/pdf")
&& ($_FILES["file"]["size"] < 2000000)
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
//    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
//    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
//    echo "Type: " . $_FILES["file"]["type"] . "<br>";
//    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
//    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {

        //begin switch over logic

        //NOT dcuments only
       if ($type == 'not'){


      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/NOT" . $customfilename . "." . $extension);

      mysql_query("INSERT INTO xmgnt_task (contract_id, doc_path, doc_path_timestamp) VALUES ('$customfilename', 'NOT$customfilename.$extension', NOW())
                   ON DUPLICATE KEY UPDATE doc_path = 'NOT$customfilename.$extension', doc_path_timestamp = NOW()
") or die ('Error: '.mysql_error ());

      mysql_query("INSERT INTO xmgnt_task_history (contract_id, event_type, datetime, user)
                   VALUES ($customfilename, 3, NOW(), '$username')
") or die ('Error: '.mysql_error ());


      //LOA documents only
       }else if($type == 'loa'){

        move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/LOA" . $customfilename . "." . $extension);

      mysql_query("INSERT INTO xmgnt_task (site_id, doc_path, task_status,doc_path_timestamp) VALUES ('$customfilename', 'LOA$customfilename.$extension', 1, NOW())
                   ON DUPLICATE KEY UPDATE doc_path = 'LOA$customfilename.$extension', task_status = 1, doc_path_timestamp = NOW()
") or die ('Error: '.mysql_error ());

      mysql_query("INSERT INTO xmgnt_task_history (site_id, event_type, datetime, user)
                   VALUES ($customfilename, 3, NOW(), '$username')
") or die ('Error: '.mysql_error ());


            //COT documents only
       }else if($type == 'cot'){

        move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/COT" . $customfilename . "." . $extension);

      mysql_query("INSERT INTO xmgnt_task (cot_id, doc_path, task_status, doc_path_timestamp) VALUES ('$customfilename', 'COT$customfilename.$extension', 1, NOW())
                   ON DUPLICATE KEY UPDATE doc_path = 'COT$customfilename.$extension', task_status = 1, doc_path_timestamp = NOW()
") or die ('Error: '.mysql_error ());

      mysql_query("INSERT INTO xmgnt_task_history (cot_id, event_type, datetime, user)
                   VALUES ($customfilename, 3, NOW(), '$username')
") or die ('Error: '.mysql_error ());



       }else if($type == 'proc'){

        move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/proc" . $customfilename . "." . $extension);

      mysql_query("INSERT INTO xmgnt_task (proc_contract_id, doc_path, task_status, doc_path_timestamp, task_type, user_closed) VALUES ('$customfilename', 'proc$customfilename.$extension', 1, NOW(), 4, '$username')
                   ON DUPLICATE KEY UPDATE doc_path = 'proc$customfilename.$extension', task_status = 1, doc_path_timestamp = NOW(), task_type = 4, user_closed = '$username'
") or die ('Error: '.mysql_error ());

      mysql_query("INSERT INTO xmgnt_task_history (cot_id, event_type, datetime, user)
                   VALUES ($customfilename, 3, NOW(), '$username')
") or die ('Error: '.mysql_error ());



       }

       //end switchover logic
      }
    }
  }
else
//  {
//  echo "Invalid file";
//  }
?>