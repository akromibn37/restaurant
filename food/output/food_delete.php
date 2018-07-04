<?php
    require_once("food_function.php");
    $id = $_GET['id'];
    deletefood($id);
    

?>

ลบข้อมูลเรียบร้อยแล้ว
<br/>
<a href="food_show_all.php">กลับ</a>