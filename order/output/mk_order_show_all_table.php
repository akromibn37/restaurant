<?php
    require_once("mk_order_function.php");
    $datas = getAllmk_order();
    if(count($datas) > 0)
    {
        echo "<table border='1' style= 'border-collapse: collapse;'>";
            echo "<tr>";
                $keys = array_keys ($datas[0]);
                for($i =0 ;$i < count($keys) ; $i++)
                {
                    $key = $keys[$i];
                    echo "<th>$key</th>";
                }
                echo "<th >"."แก้ไข"."</th>";
                echo "<th >"."ลบ"."</th>";
                echo "<th >"."ดูรายละเอียด"."</th>";
            echo "</tr>";
            for($i =0 ;$i < count($datas ) ; $i++)
            {
                if($i % 2 == 0)
                {
                    echo "<tr style='background-color:#cccccc;'>";
                }
                else
                {
                    echo "<tr>";
                }
                for($j =0 ;$j < count($keys) ; $j++)
                {
                    $key = $keys[$j];
                    echo "<td >".$datas[$i][$key]."</td>";
                }
                $id = $datas[$i]['id'];
                
                echo "<td >"."<a href = 'mk_order_insert_form.php?action=edit&id=$id' >แก้ไข </a>"."</td>";
                echo "<td >".
                        "<button onclick='confirm_delete($id)'>ลบ
                        </button>".
                    "</td>";
                echo "<td >"."<a href = 'order_detail.php?order_id=$id' >ดูรายละเอียด </a>"."</td>";
                echo "</tr>";
            }
            
        echo "</table>";
    }


?>