<?php
    require_once("mk_order_function.php");
    $id = $_GET['id'];
    deletemk_order($id);
    

?>

ลบข้อมูลเรียบร้อยแล้ว
<br/>
<a href="mk_order_show_all.php">กลับ</a>