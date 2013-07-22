<?php

$action = $_GET['form'];

if($action == 'newtask'){

    $client = $_POST['client'];
    $account_manager = $_POST['account_manager'];
    $task_owner = $_POST['task_owner'];
    $summary = $_POST['summary'];
    $due_date = $_POST['due_date'];
    $notes = $_POST['notes'];
    $user = $_POST['user'];

    mysql_query("INSERT INTO xsales_task (client, account_manager, task_owner,
                 summary, due_date, notes, user_created)
                 VALUES ('$client', '$account_manager', '$task_owner', '$summary', '$due_date',
                         '$notes', '$user')
                 ") or die ('Error: '.mysql_error ());

}

 if ($action == 'donetask'){

     $id = $_GET['id'];

    mysql_query("UPDATE xsales_task SET complete=1, datetime_completed=NOW(), user_completed='$username' WHERE id=$id
                ")or die ('Error: '.mysql_error ());

                    }

 if ($action == 'edittask'){

     $id = $_GET['id'];

    $client = $_POST['client'];
    $account_manager = $_POST['account_manager'];
    $task_owner = $_POST['task_owner'];
    $summary = $_POST['summary'];
    $due_date = $_POST['due_date'];
    $notes = $_POST['notes'];

    mysql_query("UPDATE xsales_task SET
                 client='$client',
                 account_manager='$account_manager',
                 task_owner='$task_owner',
                 summary='$summary',
                 due_date='$due_date',
                 notes='$notes'
                 WHERE id=$id
                ")or die ('Error: '.mysql_error ());

                    }

 if ($action == 'newopp'){

    $client = $_POST['client'];
    $account_manager = $_POST['account_manager'];
    $introducer = $_POST['introducer'];
    $value = $_POST['value'];
    $stage = $_POST['stage'];
    $opp_summary = $_POST['opp_summary'];
    $terms_summary = $_POST['terms_summary'];
    $next_task = $_POST['next_task'];
    $probability = $_POST['probability'];
    $start_date = $_POST['start_date'];
    $notes = $_POST['notes'];
    $user = $_POST['user'];

    mysql_query("INSERT INTO xsales_opportunity (client, account_manager, introducer, value, stage, opportunity_summary, terms_summary, next_task, probability, start_date, notes, user_created)
                VALUES (
                '$client', '$account_manager', '$introducer',
                '$value', $stage, '$opp_summary',
                '$terms_summary', '$next_task', $probability,
                '$start_date', '$notes', '$user')
                ") or die ('Error: '.mysql_error ());

 }

  if ($action == 'doneopp'){

     $id = $_GET['id'];

    mysql_query("UPDATE xsales_opportunity SET complete=1, datetime_completed=NOW(), user_completed='$username' WHERE id=$id
                ")or die ('Error: '.mysql_error ());

                    }

  if ($action == 'editopp'){

      $id = $_GET['id'];

    $client = $_POST['client'];
    $account_manager = $_POST['account_manager'];
    $introducer = $_POST['introducer'];
    $value = $_POST['value'];
    $stage = $_POST['stage'];
    $opp_summary = $_POST['opp_summary'];
    $terms_summary = $_POST['terms_summary'];
    $next_task = $_POST['next_task'];
    $probability = $_POST['probability'];
    $start_date = $_POST['start_date'];
    $notes = $_POST['notes'];

   mysql_query("UPDATE xsales_opportunity SET
                client='$client',
                account_manager='$account_manager',
                introducer='$introducer',
                value='$value',
                stage='$stage',
                opportunity_summary='$opp_summary',
                terms_summary='$terms_summary',
                next_task='$next_task',
                probability='$probability',
                start_date='$start_date',
                notes='$notes'
                WHERE id=$id
                ")or die ('Error: '.mysql_error ());

                     }
                     
if ($action == 'newintroducer'){

$name=$_POST['name'];
$address_1=$_POST['address_1'];
$address_2=$_POST['address_2'];
$postcode=$_POST['postcode'];
$main_tel=$_POST['main_tel'];
$primary_contact=$_POST['primary_contact'];
$primary_tel=$_POST['primary_tel'];
$primary_mob=$_POST['primary_mob'];
$primary_email=$_POST['primary_email'];
$secondary_contact=$_POST['secondary_contact'];
$secondary_tel=$_POST['secondary_tel'];
$secondary_mob=$_POST['secondary_mob'];
$secondary_email=$_POST['secondary_email'];
$commission_level=$_POST['commission_level'];
$notes=$_POST['notes'];


        mysql_query("INSERT INTO xsales_introducer (name,
                    address_line_1,
                    address_line_2,
                    postcode,
                    main_tel,
                    pri_contact_name,
                    pri_contact_tel,
                    pri_contact_mob,
                    pri_contact_email,
                    sec_contact_name,
                    sec_contact_tel,
                    sec_contact_mob,
                    sec_contact_email,
                    commission_level,
                    notes,
                    datetime_added)
                    VALUES ('$name',
                            '$address_1',
                            '$address_2',
                            '$postcode',
                            '$main_tel',
                            '$primary_contact',
                            '$primary_tel',
                            '$primary_mob',
                            '$primary_email',
                            '$secondary_contact',
                            '$secondary_tel',
                            '$secondary_mob',
                            '$secondary_email',
                            '$commission_level',
                            '$notes',
                             NOW())
                ") or die ('Error: '.mysql_error ());
}

if ($action == 'newclient'){

$name=$_POST['name'];
$address_1=$_POST['address_1'];
$address_2=$_POST['address_2'];
$postcode=$_POST['postcode'];
$main_tel=$_POST['main_tel'];
$primary_contact=$_POST['primary_contact'];
$primary_tel=$_POST['primary_tel'];
$primary_mob=$_POST['primary_mob'];
$primary_email=$_POST['primary_email'];
$secondary_contact=$_POST['secondary_contact'];
$secondary_tel=$_POST['secondary_tel'];
$secondary_mob=$_POST['secondary_mob'];
$secondary_email=$_POST['secondary_email'];
$sector=$_POST['sector'];
$no_sites=$_POST['no_sites'];
$no_meters=$_POST['no_meters'];
$introducer=$_POST['introducer'];
$notes=$_POST['notes'];
$pri_position=$_POST['pri_position'];
$sec_position=$_POST['sec_position'];


        mysql_query("INSERT INTO xsales_client (name,
                    address_line_1,
                    address_line_2,
                    postcode,
                    main_tel,
                    pri_contact_name,
                    pri_contact_tel,
                    pri_contact_mob,
                    pri_contact_email,
                    sec_contact_name,
                    sec_contact_tel,
                    sec_contact_mob,
                    sec_contact_email,
                    sector,
                    no_sites,
                    no_meters,
                    introducer,
                    notes,
                    datetime_added,
                    pri_position,
                    sec_position)
                    VALUES ('$name',
                            '$address_1',
                            '$address_2',
                            '$postcode',
                            '$main_tel',
                            '$primary_contact',
                            '$primary_tel',
                            '$primary_mob',
                            '$primary_email',
                            '$secondary_contact',
                            '$secondary_tel',
                            '$secondary_mob',
                            '$secondary_email',
                            '$sector',
                            '$no_sites',
                            '$no_meters',
                            '$introducer',
                            '$notes',
                             NOW(),
                             '$pri_position',
                             '$sec_position')
                ") or die ('Error: '.mysql_error ());
}

  if ($action == 'deleteintroducer'){

     $id = $_GET['id'];

    mysql_query("UPDATE xsales_introducer SET active=0 WHERE id=$id
                ") or die ('Error: '.mysql_error ());

  }

  if ($action == 'deleteclient'){

     $id = $_GET['id'];

    mysql_query("UPDATE xsales_client SET active=0 WHERE id=$id
                ") or die ('Error: '.mysql_error ());

  }

  if ($action == 'editintro'){

    $id = $_GET['id'];
    $name=$_POST['name'];
    $address_1=$_POST['address_1'];
    $address_2=$_POST['address_2'];
    $postcode=$_POST['postcode'];
    $main_tel=$_POST['main_tel'];
    $primary_contact=$_POST['primary_contact'];
    $primary_tel=$_POST['primary_tel'];
    $primary_mob=$_POST['primary_mob'];
    $primary_email=$_POST['primary_email'];
    $secondary_contact=$_POST['secondary_contact'];
    $secondary_tel=$_POST['secondary_tel'];
    $secondary_mob=$_POST['secondary_mob'];
    $secondary_email=$_POST['secondary_email'];
    $commission_level=$_POST['commission_level'];
    $notes=$_POST['notes'];

       mysql_query("UPDATE xsales_introducer SET
                    name='$name',
                    address_line_1='$address_1',
                    address_line_2='$address_2',
                    postcode='$postcode',
                    main_tel='$main_tel',
                    pri_contact_name='$primary_contact',
                    pri_contact_tel='$primary_tel',
                    pri_contact_mob='$primary_mob',
                    pri_contact_email='$primary_email',
                    sec_contact_name='$secondary_contact',
                    sec_contact_tel='$secondary_tel',
                    sec_contact_mob='$secondary_mob',
                    sec_contact_email='$secondary_email',
                    commission_level='$commission_level',
                    notes='$notes'
            WHERE id=$id
                ") or die ('Error: '.mysql_error ());

  }

  if ($action == 'editclient'){

        $id = $_GET['id'];

        $name=$_POST['name'];
        $address_1=$_POST['address_1'];
        $address_2=$_POST['address_2'];
        $postcode=$_POST['postcode'];
        $main_tel=$_POST['main_tel'];
        $primary_contact=$_POST['primary_contact'];
        $primary_tel=$_POST['primary_tel'];
        $primary_mob=$_POST['primary_mob'];
        $primary_email=$_POST['primary_email'];
        $secondary_contact=$_POST['secondary_contact'];
        $secondary_tel=$_POST['secondary_tel'];
        $secondary_mob=$_POST['secondary_mob'];
        $secondary_email=$_POST['secondary_email'];
        $sector=$_POST['sector'];
        $no_sites=$_POST['no_sites'];
        $no_meters=$_POST['no_meters'];
        $introducer=$_POST['introducer'];
        $notes=$_POST['notes'];
        $pri_position=$_POST['pri_position'];
        $sec_position=$_POST['sec_position'];
        
    mysql_query("UPDATE xsales_client SET
                    name='$name',
                    address_line_1='$address_1',
                    address_line_2='$address_2',
                    postcode='$postcode',
                    main_tel='$main_tel',
                    pri_contact_name='$primary_contact',
                    pri_contact_tel='$primary_tel',
                    pri_contact_mob='$primary_mob',
                    pri_contact_email='$primary_email',
                    sec_contact_name='$secondary_contact',
                    sec_contact_tel='$secondary_tel',
                    sec_contact_mob='$secondary_mob',
                    sec_contact_email='$secondary_email',
                    sector='$sector',
                    no_sites='$no_sites',
                    no_meters='$no_meters',
                    introducer='$introducer',
                    notes='$notes',
                    pri_position='$pri_position',
                    sec_position='$sec_position'
                    WHERE id=$id
                    ") or die ('Error: '.mysql_error ());

  }

    if ($action == 'retrieve'){
        $id = $_GET['id'];
        $type = $_GET['type'];

        if ($type == 'opp'){
            $table='xsales_opportunity';
        }else if ($type = 'task'){
            $table='xsales_task';
        }
    

  mysql_query("UPDATE $table SET
               complete = 0
               WHERE id=$id
          ") or die ('Error: '.mysql_error ());
  }
?>
