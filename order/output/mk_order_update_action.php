<?php

    require_once("mk_order_function.php");
    session_start();

    
$id      =   trim($_POST['id']);
$table_no      =   trim($_POST['table_no']);
$status      =   trim($_POST['status']);
    
    $submit      =   $_POST['submit'];
    
    
$_SESSION["table_no "]      =  $table_no        ;
$_SESSION["status "]      =  $status        ;
    
   
    if(!isset($submit))
    {
        header("location:mk_order_insert_form.php");
    }
    
    
    
if($table_no == "")
            {
                header("location:mk_order_insert_form.php?action=edit&return=1");
                exit;
            }
if($status == "")
            {
                header("location:mk_order_insert_form.php?action=edit&return=2");
                exit;
            }
    
  /*  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("location:insert_form.php?return=5");
        exit; 
    }
    */
   $isSuccess = updatemk_order(
                               
        $id, $table_no, $status 
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
        <h1><?php echo $isSuccess ? "แก้ไข สำเร็จ"  : "ล้มเหลว"; ?></h1>
        <br/>
        <a href="index.php">กลับหน้าหลัก</a>
        <br/>
        <a href="mk_order_insert_form.php">กลับหน้าinsert new mk_order</a> 
    </body>
</html>
