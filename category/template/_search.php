<?php
    require_once("{{TABLE_NAME}}_function.php");    
?>
<html>
    <head>
        <meta charset="UTF-8"/> 
        <title>MM's Bag [{{TABLE_NAME}}]</title>
        <script>
            function confirm_delete(id)
            {
                var r = confirm("คุณจะลบ id " + id + "จริงๆ เหรอ");
                if (r == true)
                {
                    window.open("{{TABLE_NAME}}_delete.php?id="+id, "_self");
                }
                else
                {
                    
                }
            }
        </script>
    </head>
    <body>
            <h1>{{TABLE_NAME}} ของเราทั้งหมด</h1>
            <form action="{{TABLE_NAME}}_search.php" method="POST">
                search : <input type="text" name="text_to_search" value ="%" />
                <input type="submit" value="SEARCH" name ="btn" />
                
            </form>
            <br/>
            <br/>
            <?php
                if(isset($_POST['btn']))
                {
                    require_once("{{TABLE_NAME}}_function.php");
                    
                    ${{TABLE_NAME}} = search{{TABLE_NAME}}(trim($_POST['text_to_search']),"name");
                    //print_r(${{TABLE_NAME}});
                    if(count(${{TABLE_NAME}}) > 0)
                    {
                        echo "<table border='1' style= 'border-collapse: collapse;'>";
                            echo "<tr>";
                                $keys = array_keys (${{TABLE_NAME}}[0]);
                                for($i =0 ;$i < count($keys) ; $i++)
                                {
                                    $key = $keys[$i];
                                    echo "<th>$key</th>";
                                }
                                 echo "<th >"."แก้ไข"."</th>";
                                echo "<th >"."ลบ"."</th>";
                            echo "</tr>";
                            for($i =0 ;$i < count(${{TABLE_NAME}} ) ; $i++)
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
                                    echo "<td >".${{TABLE_NAME}}[$i][$key]."</td>";
                                }
                                $id = ${{TABLE_NAME}}[$i]['id'];
                                
                                echo "<td >"."<a href = '{{TABLE_NAME}}_insert_form.php?action=edit&id=$id' >แก้ไข </a>"."</td>";
                                echo "<td >".
                                        "<button onclick='confirm_delete($id)'>ลบ
                                        </button>".
                                "</td>";
                                echo "</tr>";
                            }
                            
                        echo "</table>";
                    }
                }
                else
                {
                    echo "กรุณากดปุ่ม Search ค่ะ";
                }
            ?>
            <br/>
        <a href="index.php">กลับ</a>
    <body>
</html>