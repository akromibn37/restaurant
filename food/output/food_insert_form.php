<?php
    session_start();
    require_once("food_function.php");
    
    $isEdit = false;
    if(isset( $_GET['action'] ) and  $_GET['action'] == "edit" )
    {
        $isEdit = true;
        $id = $_GET['id'];
        $values = getfoodByid($id);
	
        if(count($values) > 0)
        {
	    



		$id       		=   	$values[0]["id"] 	;
		$_SESSION["id"]       =  	$id    ;
	    

		$name       		=   	$values[0]["name"] 	;
		$_SESSION["name"]       =  	$name    ;
	    

		$description       		=   	$values[0]["description"] 	;
		$_SESSION["description"]       =  	$description    ;
	    

		$price       		=   	$values[0]["price"] 	;
		$_SESSION["price"]       =  	$price    ;
	    

		$image       		=   	$values[0]["image"] 	;
		$_SESSION["image"]       =  	$image    ;
	    

		$cat_id       		=   	$values[0]["cat_id"] 	;
		$_SESSION["cat_id"]       =  	$cat_id    ;
	    

            
        }
    }
?>
<html>
	<head>
		<title>MM's Bag [food]</title>
		<meta charset="UTF-8"/>
	</head>
	<body>
    <?php

      
	



	    
	    if(isset( $_GET['return'] ) and $_GET['return'] == 1)
	    {
		echo "<p style='color:red;'>กรุณากรอกชื่อด้วยค่ะ</p>";
	    }
       

	    
	    if(isset( $_GET['return'] ) and $_GET['return'] == 2)
	    {
		echo "<p style='color:red;'>กรุณากรอกคำอธิบายด้วยค่ะ</p>";
	    }
       

	    
	    if(isset( $_GET['return'] ) and $_GET['return'] == 3)
	    {
		echo "<p style='color:red;'>กรุณากรอกราคาด้วยค่ะ</p>";
	    }
       

	    
	    if(isset( $_GET['return'] ) and $_GET['return'] == 4)
	    {
		echo "<p style='color:red;'>กรุณากรอกpath ไปยังรูปด้วยค่ะ</p>";
	    }
       

	    
	    if(isset( $_GET['return'] ) and $_GET['return'] == 5)
	    {
		echo "<p style='color:red;'>กรุณากรอกรหัสประเภทอาหารด้วยค่ะ</p>";
	    }
       

       
   ?>
		<h1>insert new food</h1>
                <?php
                    if($isEdit)
                    {
                        echo "<form action='food_update_action.php' method='POST'>";
                    }
                    else
                    {
                        echo "<form action='food_insert_action.php' method='POST'>";
                    }
                ?>
                    <ul>
                            <?php
                                if($isEdit)
                                {
                                    echo "<input type='hidden' name='id'         value= '$id;' />";
                                }
                            ?>
			    



				
				<li>name  <input type="text" name="name"         value= "<?php echo $_SESSION["name"];?>" /> </li>
                            

				
				<li>description  <input type="text" name="description"         value= "<?php echo $_SESSION["description"];?>" /> </li>
                            

				
				<li>price  <input type="text" name="price"         value= "<?php echo $_SESSION["price"];?>" /> </li>
                            

				
				<li>image  <input type="text" name="image"         value= "<?php echo $_SESSION["image"];?>" /> </li>
                            

				
				<li>cat_id  <input type="text" name="cat_id"         value= "<?php echo $_SESSION["cat_id"];?>" /> </li>
                            

       
			    <li> <input type="submit" name="submit" value="SAVE" /> </li>
                    </ul>
                </form>
               
	<body>
</html>