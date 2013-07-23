<?php
//ini_set('display_errors', 1);

//session_save_path('Applications/MAMP/htdocs/Trace/sessions');

//session_save_path('/home/mgmt/httpdocs/sessions');
session_start();
//if(!session_is_registered(myusername)){
//$_SESSION['myusername'] = 'AlexHill';
//$_SESSION['myuserid'] = '2';




if(!isset($_SESSION['myusername'])){
header("location:index.php");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
       <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
       <title>Trace Management</title>
       <link rel="stylesheet" type="text/css" href="style.css">
<!--       <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
       <script type ="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
       <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>-->
       
       <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
       
       <script type="text/javascript" src="jquery.tablesorter.js"></script>
       <script src="showHide.js" type="text/javascript"></script>
       <script type="text/javascript" src="maxlength.js"></script>
       <script type="text/javascript" src="jquery.validate.min.js"></script>

       <!-- JQuery table sorter controls -->
       <script type="text/javascript">
            $(document).ready(function()
                {
                 $(".grid").tablesorter();
                }
            );
       </script>

       <script>
function formSubmit()
{
document.theForm.submit();
}
</script>

        <!-- Sliding div controls -->
        <script type="text/javascript">

        $(document).ready(function(){


           $('.show_hide').showHide({
                        speed: 200,  // speed you want the toggle to happen
                        easing: '',  // the animation effect you want. Remove this line if you dont want an effect and if you haven't included jQuery UI
                        changeText: 1, // if you dont want the button text to change, set this to 0
                        showText: '+',// the button text to show when a div is closed
                        hideText: '-'
                    });
        });
        </script>

        <!-- Create cookie for positioning -->
        <script language="JavaScript">
        function readCookie(name){
        return(document.cookie.match('(^|; )'+name+'=([^;]*)')||0)[2]
        }
        </script>

        <!-- File upload controls -->
        <script language="JavaScript" type="text/javascript">
        function HandleBrowseClick()
        {
            var fileinput = document.getElementById("browse");
            fileinput.click();
        }
        function Handlechange()
        {
        var fileinput = document.getElementById("browse");
        var textinput = document.getElementById("filename");
        textinput.value = fileinput.value;
        }
        </script>

        <!-- Datepicker -->
       <script language="JavaScript" type="text/javascript">
        $(function() {
            $("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
            $("#datepicker2").datepicker({dateFormat: 'yy-mm-dd'});
            $("*[id*=datepicker]").datepicker({dateFormat: 'yy-mm-dd'});
        });
        </script>


        <script type="text/javascript">
            function classCount(name){
            var red_count = $('div.'+name+'_red_warning').length;
            var amber_count = $('div.'+name+'_amber_warning').length;
            var green_count = $('div.'+name+'_green_warning').length;
            //var count = $('.red_icon').length;
            //var count = $("img[src='red_icon.png']").length;
            $('#'+name+'_red_counter').append(red_count);
            $('#'+name+'_amber_counter').append(amber_count);
            $('#'+name+'_green_counter').append(green_count);

            }</script>
        
        <script type="text/javascript">
 $(function() {
    $( document ).tooltip();
  });
        </script>
        
    </head>

<!-- onScroll below ensures page opens where the last scroll position was -->
<body onScroll="document.cookie='ypos=' + window.pageYOffset" onLoad="window.scrollTo(0,readCookie('ypos'))"> 
