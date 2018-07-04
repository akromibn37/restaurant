<?php
    function createMysqlConnection()
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
    function insertNewfood(
        $name, $description, $price, $image, $cat_id
                )
    {
        $conn= createMysqlConnection();
        $sql = "INSERT INTO food
                (
        id, name, description, price, image, cat_id
                 )
                VALUES (0,
                ?, ?, ?, ?, ?
                )";
        $stmt = $conn->prepare( $sql);
        $stmt-> bind_param("ssdsi",
                           
                $name, $description, $price, $image, $cat_id
                           
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
    
    
    function updatefood(
         $id, $name, $description, $price, $image, $cat_id
                )
    {
        $conn= createMysqlConnection();
        
        $sql = "UPDATE food SET
                    name =      ?, description =      ?, price =      ?, image =      ?, cat_id =      ?
                    WHERE id =  ?";
                    
        echo  $sql."<br/>";
        $stmt = $conn->prepare( $sql);
        $stmt-> bind_param("ssdsii", 
                            $name, $description, $price, $image, $cat_id
                           
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
    function deletefood($id)
    {
        $conn= createMysqlConnection();
        
        $sql = "DELETE FROM food WHERE id = ?" ;
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
       
    function getAllfood()
    {
        $conn= createMysqlConnection();
        
        $sql = "SELECT *  FROM food ORDER BY id";
        $result = $conn->query($sql);
        
        $foods = array();
        if ($result->num_rows > 0)
        {
            // output data of each row
            while($row = $result->fetch_assoc())
            {
                $foods_row = array(
                            "id"=>$row["id"],
                                "name"=>$row["name"],
                                "description"=>$row["description"],
                                "price"=>$row["price"],
                                "image"=>$row["image"],
                                "cat_id"=>$row["cat_id"]
                                       );
                array_push($foods,$foods_row);
            }
        } else {
            echo "0 results";
        }
        
        $conn->close();
        return   $foods;
    }

    function getfoodByid($id)
    {
        $conn= createMysqlConnection();
        
        $sql = "SELECT *  FROM food WHERE id = ?"; //////////////////////
        
        $stmt = $conn->prepare( $sql);
        $stmt-> bind_param("i",$id);
        $stmt->execute();
        
        
        $stmt->bind_result(
                           
                            $id, $name, $description, $price, $image, $cat_id
                          );
       
        
        $foods = array();
       
        // output data of each row
        while($stmt->fetch())
        {
            $foods_row = array(
                            "id"=>$id,
                                "name"=>$name,
                                "description"=>$description,
                                "price"=>$price,
                                "image"=>$image,
                                "cat_id"=>$cat_id
                                    
                                   );
            array_push($foods,$foods_row);
        }
       $stmt->close();
        $conn->close();
        return   $foods;
    }

//%' AND  '1' =  '1' UNION SELECT * , 1, 1, 1 FROM  `users`  WHERE '1' = '1
    function searchfood($name_search,$column_name_to_search)
    {
        $conn= createMysqlConnection();
        
        $sql = "SELECT *  FROM food WHERE `$column_name_to_search` LIKE ?   "; //////////////////////
        //echo "$sql";
        //echo $name_search;
        $stmt = $conn->prepare( $sql);
        $stmt-> bind_param("s",$name_search);
        $stmt->execute();
        //$result = $stmt->get_result();
        
        $stmt->bind_result(
                           
                            $id, $name, $description, $price, $image, $cat_id
                          );
       
        
        $foods = array();
       
        // output data of each row
        while($stmt->fetch())
        {
            $foods_row = array(
                            "id"=>$id,
                                "name"=>$name,
                                "description"=>$description,
                                "price"=>$price,
                                "image"=>$image,
                                "cat_id"=>$cat_id
                                    
                                   );
            array_push($foods,$foods_row);
        }
        $stmt->close();
        $conn->close();
        return   $foods;
    }
?>