<?php
    require_once("mk_order_detail_function.php");
    $id = $_GET['id'];
    deletemk_order_detail($id);
    

?>

ลบข้อมูลเรียบร้อยแล้ว
<br/>
<a href="mk_order_detail_show_all.php">กลับ</a>