<?php
    require_once("{{TABLE_NAME}}_function.php");
    ${{TABLE_PRIMARY_KEY}} = $_GET['{{TABLE_PRIMARY_KEY}}'];
    delete{{TABLE_NAME}}(${{TABLE_PRIMARY_KEY}});
    

?>

ลบข้อมูลเรียบร้อยแล้ว
<br/>
<a href="{{TABLE_NAME}}_show_all.php">กลับ</a>