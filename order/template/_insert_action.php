<?php
    require_once("{{TABLE_NAME}}_function.php");
    session_start();

    
    {{##START LOOP ALL COLUMNS##}}
        {{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}
        ${{COLUMN_FEILD}}      =   trim($_POST['{{COLUMN_FEILD}}']);
    {{##END LOOP ALL COLUMNS##}}
    
    $submit      =  $_POST['submit'];
    
    {{##START LOOP ALL COLUMNS##}}
        {{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}
        $_SESSION["{{COLUMN_FEILD}}"]      =  ${{COLUMN_FEILD}}        ;
    {{##END LOOP ALL COLUMNS##}}
    
    if(!isset($submit))
    {
        header("location:{{TABLE_NAME}}_insert_form.php");
    }


    {{##START LOOP ALL COLUMNS##}}
        {{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}    
            if(${{COLUMN_FEILD}} == "")
            {
                header("location:{{TABLE_NAME}}_insert_form.php?return={{COLUMN_INDEX}}");
                exit;
            }
    {{##END LOOP ALL COLUMNS##}}

    
   // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //    header("location:insert_form.php?return=5");
    //    exit; 
    //}
    
   $isSuccess = insertNew{{TABLE_NAME}}(               
        {{##START LOOP ALL COLUMNS##}}
            {{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}
            {{SEPERATOR}}, {{END SEPERATOR}}
            ${{COLUMN_FEILD}}
        {{##END LOOP ALL COLUMNS##}} 
                                        );
   
   
   // remove all session variables
    session_unset(); 
    
    // destroy the session 
    session_destroy(); 
 
?>
<html>
    <head>
        <meta charset="UTF-8"/>
    </head>
    <body>
        <h1><?php echo $isSuccess ? "insert สำเร็จ"  : "ล้มเหลว"; ?></h1>
        <br/>
        <a href="index.php">กลับหน้าหลัก</a>
        <br/>
        <a href="{{TABLE_NAME}}_insert_form.php">กลับหน้าinsert new customer</a> 
    </body>
</html>
