<?php
    function createMysqlConnection_order()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "mk";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->query('SET NAMES UTF8;');
        return $conn;
    }
    function insertNewmk_order($table_no, $status)
    {
        $conn= createMysqlConnection_order();
        $sql = "INSERT INTO mk_order
                (
        id, table_no, status
                 )
                VALUES (0,
                ?, ?
                )";
        $stmt = $conn->prepare( $sql);
        $stmt-> bind_param("ss",
                           
                $table_no, $status
                           
                           );
        
        $isSuccess = false;
        if ($stmt->execute() === TRUE)
        {
            $isSuccess = true;
        }
        else
        {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $stmt->close();
        $conn->close();
        return $isSuccess;
    }
    
    
    function updatemk_order(
         $id, $table_no, $status
                )
    {
        $conn= createMysqlConnection_order();
        
        $sql = "UPDATE mk_order SET
                    table_no =      ?, status =      ?
                    WHERE id =  ?";
                    
        echo  $sql."<br/>";
        $stmt = $conn->prepare( $sql);
        $stmt-> bind_param("ssi", 
                            $table_no, $status
                           
                           ,$id);
        
        $isSuccess = false;
        if ($stmt->execute()  === TRUE)
        {
            $isSuccess = true;
        } else
        {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $stmt->close();
        $conn->close();
        return $isSuccess;

    }
    function deletemk_order($id)
    {
        $conn= createMysqlConnection_order();
        
        $sql = "DELETE FROM mk_order WHERE id = ?" ;
        $stmt = $conn->prepare( $sql);
        $stmt-> bind_param("i",$id);
        
        if ($stmt->execute() === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $stmt->close();
        $conn->close();

    }
       
    function getAllmk_order()
    {
        $conn= createMysqlConnection_order();
        
        $sql = "SELECT *  FROM mk_order ORDER BY id";
        $result = $conn->query($sql);
        
        $mk_orders = array();
        if ($result->num_rows > 0)
        {
            // output data of each row
            while($row = $result->fetch_assoc())
            {
                $mk_orders_row = array(
                            "id"=>$row["id"],
                                "table_no"=>$row["table_no"],
                                "status"=>$row["status"],
                                "insert_time"=>$row["insert_time"]
                                       );
                array_push($mk_orders,$mk_orders_row);
            }
        } else {
            echo "0 results";
        }
        
        $conn->close();
        return   $mk_orders;
    }

    function getmk_orderByid($id)
    {
        $conn= createMysqlConnection_order();
        
        $sql = "SELECT *  FROM mk_order WHERE id = ?"; //////////////////////
        
        $stmt = $conn->prepare( $sql);
        $stmt-> bind_param("i",$id);
        $stmt->execute();
        
        
        $stmt->bind_result(
                           
                            $id, $table_no, $status, $insert_time
                          );
       
        
        $mk_orders = array();
       
        // output data of each row
        while($stmt->fetch())
        {
            $mk_orders_row = array(
                            "id"=>$id,
                                "table_no"=>$table_no,
                                "status"=>$status,
                                "insert_time"=>$insert_time
                                    
                                   );
            array_push($mk_orders,$mk_orders_row);
        }
       $stmt->close();
        $conn->close();
        return   $mk_orders;
    }

//%' AND  '1' =  '1' UNION SELECT * , 1, 1, 1 FROM  `users`  WHERE '1' = '1
    function searchmk_order($name_search,$column_name_to_search)
    {
        $conn= createMysqlConnection_order();
        
        $sql = "SELECT *  FROM mk_order WHERE `$column_name_to_search` LIKE ?   "; //////////////////////
        echo "$sql";
        $stmt = $conn->prepare( $sql);
        $stmt-> bind_param("s",$name_search);
        $stmt->execute();
        //$result = $stmt->get_result();
        
        $stmt->bind_result(
                           
                            $id, $table_no, $status, $insert_time
                          );
       
        
        $mk_orders = array();
       
        // output data of each row
        while($stmt->fetch())
        {
            $mk_orders_row = array(
                            "id"=>$id,
                                "table_no"=>$table_no,
                                "status"=>$status,
                                "insert_time"=>$insert_time
                                    
                                   );
            array_push($mk_orders,$mk_orders_row);
        }
        $stmt->close();
        $conn->close();
        return   $mk_orders;
    }


    ////////////no code gen ///////////////
    function searchmk_open_order($table_no)// แหก
    {
        $conn= createMysqlConnection_order();
        
        $sql = "SELECT *  
                FROM mk_order 
                WHERE `table_no` = ?  
                AND `status` = 'open' 
                ORDER BY id desc
                "; //////////////////////
        //echo "$sql";
        $stmt = $conn->prepare( $sql);
        $stmt-> bind_param("s",$table_no);
        $stmt->execute();
        //$result = $stmt->get_result();
        
        $stmt->bind_result($id, $table_no, $status, $insert_time);
       
        
        $mk_orders = array();
       
        // output data of each row
        while($stmt->fetch())
        {
            $mk_orders_row = array(
                                "id"=>$id,
                                "table_no"=>$table_no,
                                "status"=>$status,
                                "insert_time"=>$insert_time
                                 );
            array_push($mk_orders,$mk_orders_row);
        }
        $stmt->close();
        $conn->close();
        return   $mk_orders;
    }
?>