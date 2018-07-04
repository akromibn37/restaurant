<?php

    require_once("category_function.php");
    session_start();

    
$id      =   trim($_POST['id']);
$name      =   trim($_POST['name']);
    
    $submit      =   $_POST['submit'];
    
    
$_SESSION["name "]      =  $name        ;
    
   
    if(!isset($submit))
    {
        header("location:category_insert_form.php");
    }
    
    
    
if($name == "")
            {
                header("location:category_insert_form.php?action=edit&return=1");
                exit;
            }
    
  /*  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("location:insert_form.php?return=5");
        exit; 
    }
    */
   $isSuccess = updatecategory(
                               
        $id, $name 
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
        <a href="category_insert_form.php">กลับหน้าinsert new category</a> 
    </body>
</html>
