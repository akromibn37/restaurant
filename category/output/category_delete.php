<?php
    require_once("category_function.php");
    $id = $_GET['id'];
    deletecategory($id);
    

?>

ลบข้อมูลเรียบร้อยแล้ว
<br/>
<a href="category_show_all.php">กลับ</a>