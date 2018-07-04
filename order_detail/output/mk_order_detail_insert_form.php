<?php
    session_start();
    require_once("mk_order_detail_function.php");
    
    $isEdit = false;
    if(isset( $_GET['action'] ) and  $_GET['action'] == "edit" )
    {
        $isEdit = true;
        $id = $_GET['id'];
        $values = getmk_order_detailByid($id);
	
        if(count($values) > 0)
        {
	    



		$id       		=   	$values[0]["id"] 	;
		$_SESSION["id"]       =  	$id    ;
	    

		$food_id       		=   	$values[0]["food_id"] 	;
		$_SESSION["food_id"]       =  	$food_id    ;
	    

		$order_id       		=   	$values[0]["order_id"] 	;
		$_SESSION["order_id"]       =  	$order_id    ;
	    

		$qty       		=   	$values[0]["qty"] 	;
		$_SESSION["qty"]       =  	$qty    ;
	    

		$status       		=   	$values[0]["status"] 	;
		$_SESSION["status"]       =  	$status    ;
	    

		$insert_time       		=   	$values[0]["insert_time"] 	;
		$_SESSION["insert_time"]       =  	$insert_time    ;
	    

            
        }
    }
?>
<html>
	<head>
		<title>MM's Bag [mk_order_detail]</title>
		<meta charset="UTF-8"/>
	</head>
	<body>
    <?php

      
	



	    
	    if(isset( $_GET['return'] ) and $_GET['return'] == 1)
	    {
		echo "<p style='color:red;'>กรุณากรอกรหัสอาหารที่สั่งด้วยค่ะ</p>";
	    }
       

	    
	    if(isset( $_GET['return'] ) and $_GET['return'] == 2)
	    {
		echo "<p style='color:red;'>กรุณากรอกรหัสของตารางใหญ่ด้วยค่ะ</p>";
	    }
       

	    
	    if(isset( $_GET['return'] ) and $_GET['return'] == 3)
	    {
		echo "<p style='color:red;'>กรุณากรอกจำนวนที่สั่งด้วยค่ะ</p>";
	    }
       

	    
	    if(isset( $_GET['return'] ) and $_GET['return'] == 4)
	    {
		echo "<p style='color:red;'>กรุณากรอกstatusด้วยค่ะ</p>";
	    }
       

       
   ?>
		<h1>insert new mk_order_detail</h1>
                <?php
                    if($isEdit)
                    {
                        echo "<form action='mk_order_detail_update_action.php' method='POST'>";
                    }
                    else
                    {
                        echo "<form action='mk_order_detail_insert_action.php' method='POST'>";
                    }
                ?>
                    <ul>
                            <?php
                                if($isEdit)
                                {
                                    echo "<input type='hidden' name='id'         value= '$id;' />";
                                }
                            ?>
			    



				
				<li>food_id  <input type="text" name="food_id"         value= "<?php echo $_SESSION["food_id"];?>" /> </li>
                            

				
				<li>order_id  <input type="text" name="order_id"         value= "<?php echo $_SESSION["order_id"];?>" /> </li>
                            

				
				<li>qty  <input type="text" name="qty"         value= "<?php echo $_SESSION["qty"];?>" /> </li>
                            

				
				<li>status  <input type="text" name="status"         value= "<?php echo $_SESSION["status"];?>" /> </li>
                            

       
			    <li> <input type="submit" name="submit" value="SAVE" /> </li>
                    </ul>
                </form>
               
	<body>
</html>