<?php

    require_once("food_function.php");
    session_start();

    
$id      =   trim($_POST['id']);
$name      =   trim($_POST['name']);
$description      =   trim($_POST['description']);
$price      =   trim($_POST['price']);
$image      =   trim($_POST['image']);
$cat_id      =   trim($_POST['cat_id']);
    
    $submit      =   $_POST['submit'];
    
    
$_SESSION["name "]      =  $name        ;
$_SESSION["description "]      =  $description        ;
$_SESSION["price "]      =  $price        ;
$_SESSION["image "]      =  $image        ;
$_SESSION["cat_id "]      =  $cat_id        ;
    
   
    if(!isset($submit))
    {
        header("location:food_insert_form.php");
    }
    
    
    
if($name == "")
            {
                header("location:food_insert_form.php?action=edit&return=1");
                exit;
            }
if($description == "")
            {
                header("location:food_insert_form.php?action=edit&return=2");
                exit;
            }
if($price == "")
            {
                header("location:food_insert_form.php?action=edit&return=3");
                exit;
            }
if($image == "")
            {
                header("location:food_insert_form.php?action=edit&return=4");
                exit;
            }
if($cat_id == "")
            {
                header("location:food_insert_form.php?action=edit&return=5");
                exit;
            }
    
  /*  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("location:insert_form.php?return=5");
        exit; 
    }
    */
   $isSuccess = updatefood(
                               
        $id, $name, $description, $price, $image, $cat_id 
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
        <a href="food_insert_form.php">กลับหน้าinsert new food</a> 
    </body>
</html>
