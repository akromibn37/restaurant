<?php
    session_start();
    require_once("mk_order_function.php");
    
    $isEdit = false;
    if(isset( $_GET['action'] ) and  $_GET['action'] == "edit" )
    {
        $isEdit = true;
        $id = $_GET['id'];
        $values = getmk_orderByid($id);
	
        if(count($values) > 0)
        {
	    



		$id       		=   	$values[0]["id"] 	;
		$_SESSION["id"]       =  	$id    ;
	    

		$table_no       		=   	$values[0]["table_no"] 	;
		$_SESSION["table_no"]       =  	$table_no    ;
	    

		$status       		=   	$values[0]["status"] 	;
		$_SESSION["status"]       =  	$status    ;
	    

		$insert_time       		=   	$values[0]["insert_time"] 	;
		$_SESSION["insert_time"]       =  	$insert_time    ;
	    

            
        }
    }
?>
<html>
	<head>
		<title>MM's Bag [mk_order]</title>
		<meta charset="UTF-8"/>
	</head>
	<body>
    <?php

      
	



	    
	    if(isset( $_GET['return'] ) and $_GET['return'] == 1)
	    {
		echo "<p style='color:red;'>กรุณากรอกโต๊ะที่เท่าไรด้วยค่ะ</p>";
	    }
       

	    
	    if(isset( $_GET['return'] ) and $_GET['return'] == 2)
	    {
		echo "<p style='color:red;'>กรุณากรอกสถานะด้วยค่ะ</p>";
	    }
       

       
   ?>
		<h1>insert new mk_order</h1>
                <?php
                    if($isEdit)
                    {
                        echo "<form action='mk_order_update_action.php' method='POST'>";
                    }
                    else
                    {
                        echo "<form action='mk_order_insert_action.php' method='POST'>";
                    }
                ?>
                    <ul>
                            <?php
                                if($isEdit)
                                {
                                    echo "<input type='hidden' name='id'         value= '$id;' />";
                                }
                            ?>
			    



				
				<li>table_no  <input type="text" name="table_no"         value= "<?php echo $_SESSION["table_no"];?>" /> </li>
                            

				
				<li>status  <input type="text" name="status"         value= "<?php echo $_SESSION["status"];?>" /> </li>
                            

       
			    <li> <input type="submit" name="submit" value="SAVE" /> </li>
                    </ul>
                </form>
               
	<body>
</html>