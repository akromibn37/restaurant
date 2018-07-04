<?php
    function createMysqlConnection()
    {
        $servername = "{{DATABASE_SERVER_LOCATION}}";
        $username = "{{DATABASE_SERVER_USERNAME}}";
        $password = "{{DATABASE_SERVER_PASSWORD}}";
        $dbname = "{{DATABASE_NAME}}";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->query('SET NAMES UTF8;');
        return $conn;
    }
    function insertNew{{TABLE_NAME}}(
        {{##START LOOP ALL COLUMNS##}}
            {{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}
            {{SEPERATOR}}, {{END SEPERATOR}}
            ${{COLUMN_FEILD}}
        {{##END LOOP ALL COLUMNS##}}
                )
    {
        $conn= createMysqlConnection();
        $sql = "INSERT INTO {{TABLE_NAME}}
                (
        {{##START LOOP ALL COLUMNS##}}
            {{EXCEPT LIST}}insert_time{{END EXCEPT LIST}}
            {{SEPERATOR}}, {{END SEPERATOR}}
            {{COLUMN_FEILD}}
        {{##END LOOP ALL COLUMNS##}}
                 )
                VALUES (0,
                {{##START LOOP ALL COLUMNS##}}
                    {{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}
                    {{SEPERATOR}}, {{END SEPERATOR}}
                    ?
                {{##END LOOP ALL COLUMNS##}}
                )";
        $stmt = $conn->prepare( $sql);
        $stmt-> bind_param("{{##START LOOP ALL COLUMNS##}}{{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}{{SEPERATOR}}{{END SEPERATOR}}{{COLUMN_TYPE_SMALL}}{{##END LOOP ALL COLUMNS##}}",
                           
                {{##START LOOP ALL COLUMNS##}}
                    {{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}
                    {{SEPERATOR}}, {{END SEPERATOR}}
                    ${{COLUMN_FEILD}}
                {{##END LOOP ALL COLUMNS##}}
                           
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
    
    
    function update{{TABLE_NAME}}(
         {{##START LOOP ALL COLUMNS##}}
            {{EXCEPT LIST}}insert_time{{END EXCEPT LIST}}
            {{SEPERATOR}}, {{END SEPERATOR}}
            ${{COLUMN_FEILD}}
        {{##END LOOP ALL COLUMNS##}}
                )
    {
        $conn= createMysqlConnection();
        
        $sql = "UPDATE {{TABLE_NAME}} SET
                    {{##START LOOP ALL COLUMNS##}}
                        {{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}
                        {{SEPERATOR}}, {{END SEPERATOR}}
                        {{COLUMN_FEILD}} =      ?
                    {{##END LOOP ALL COLUMNS##}}
                    WHERE {{TABLE_PRIMARY_KEY}} =  ?";
                    
        echo  $sql."<br/>";
        $stmt = $conn->prepare( $sql);
        $stmt-> bind_param("{{##START LOOP ALL COLUMNS##}}{{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}{{SEPERATOR}}{{END SEPERATOR}}{{COLUMN_TYPE_SMALL}}{{##END LOOP ALL COLUMNS##}}i", 
                            {{##START LOOP ALL COLUMNS##}}
                                {{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}
                                {{SEPERATOR}}, {{END SEPERATOR}}
                                ${{COLUMN_FEILD}} 
                            {{##END LOOP ALL COLUMNS##}}
                           
                           ,${{TABLE_PRIMARY_KEY}});
        
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
    function delete{{TABLE_NAME}}($id)
    {
        $conn= createMysqlConnection();
        
        $sql = "DELETE FROM {{TABLE_NAME}} WHERE {{TABLE_PRIMARY_KEY}} = ?" ;
        $stmt = $conn->prepare( $sql);
        $stmt-> bind_param("i",${{TABLE_PRIMARY_KEY}});
        
        if ($stmt->execute() === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $stmt->close();
        $conn->close();

    }
       
    function getAll{{TABLE_NAME}}()
    {
        $conn= createMysqlConnection();
        
        $sql = "SELECT *  FROM {{TABLE_NAME}} ORDER BY {{TABLE_PRIMARY_KEY}}";
        $result = $conn->query($sql);
        
        ${{TABLE_NAME}}s = array();
        if ($result->num_rows > 0)
        {
            // output data of each row
            while($row = $result->fetch_assoc())
            {
                ${{TABLE_NAME}}s_row = array(
                            {{##START LOOP ALL COLUMNS##}}
                                {{SEPERATOR}},
                                {{END SEPERATOR}}
                                "{{COLUMN_FEILD}}"=>$row["{{COLUMN_FEILD}}"]
                            {{##END LOOP ALL COLUMNS##}}
                                       );
                array_push(${{TABLE_NAME}}s,${{TABLE_NAME}}s_row);
            }
        } else {
            echo "0 results";
        }
        
        $conn->close();
        return   ${{TABLE_NAME}}s;
    }

    function get{{TABLE_NAME}}By{{TABLE_PRIMARY_KEY}}(${{TABLE_PRIMARY_KEY}})
    {
        $conn= createMysqlConnection();
        
        $sql = "SELECT *  FROM {{TABLE_NAME}} WHERE {{TABLE_PRIMARY_KEY}} = ?"; //////////////////////
        
        $stmt = $conn->prepare( $sql);
        $stmt-> bind_param("i",${{TABLE_PRIMARY_KEY}});
        $stmt->execute();
        
        
        $stmt->bind_result(
                           
                            {{##START LOOP ALL COLUMNS##}}
                                {{SEPERATOR}}, {{END SEPERATOR}}
                                ${{COLUMN_FEILD}}
                            {{##END LOOP ALL COLUMNS##}}
                          );
       
        
        ${{TABLE_NAME}}s = array();
       
        // output data of each row
        while($stmt->fetch())
        {
            ${{TABLE_NAME}}s_row = array(
                            {{##START LOOP ALL COLUMNS##}}
                                {{SEPERATOR}},
                                {{END SEPERATOR}}
                                "{{COLUMN_FEILD}}"=>${{COLUMN_FEILD}}
                            {{##END LOOP ALL COLUMNS##}}
                                    
                                   );
            array_push(${{TABLE_NAME}}s,${{TABLE_NAME}}s_row);
        }
       $stmt->close();
        $conn->close();
        return   ${{TABLE_NAME}}s;
    }

//%' AND  '1' =  '1' UNION SELECT * , 1, 1, 1 FROM  `users`  WHERE '1' = '1
    function search{{TABLE_NAME}}($name_search,$column_name_to_search)
    {
        $conn= createMysqlConnection();
        
        $sql = "SELECT *  FROM {{TABLE_NAME}} WHERE `$column_name_to_search` LIKE ?   "; //////////////////////
        echo "$sql";
        $stmt = $conn->prepare( $sql);
        $stmt-> bind_param("s",$name_search);
        $stmt->execute();
        //$result = $stmt->get_result();
        
        $stmt->bind_result(
                           
                            {{##START LOOP ALL COLUMNS##}}
                                {{SEPERATOR}}, {{END SEPERATOR}}
                                ${{COLUMN_FEILD}}
                            {{##END LOOP ALL COLUMNS##}}
                          );
       
        
        ${{TABLE_NAME}}s = array();
       
        // output data of each row
        while($stmt->fetch())
        {
            ${{TABLE_NAME}}s_row = array(
                            {{##START LOOP ALL COLUMNS##}}
                                {{SEPERATOR}},
                                {{END SEPERATOR}}
                                "{{COLUMN_FEILD}}"=>${{COLUMN_FEILD}}
                            {{##END LOOP ALL COLUMNS##}}
                                    
                                   );
            array_push(${{TABLE_NAME}}s,${{TABLE_NAME}}s_row);
        }
        $stmt->close();
        $conn->close();
        return   ${{TABLE_NAME}}s;
    }
?>