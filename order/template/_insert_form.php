<?php
    session_start();
    require_once("{{TABLE_NAME}}_function.php");
    
    $isEdit = false;
    if(isset( $_GET['action'] ) and  $_GET['action'] == "edit" )
    {
        $isEdit = true;
        $id = $_GET['id'];
        $values = get{{TABLE_NAME}}Byid($id);
	
        if(count($values) > 0)
        {
	    {{##START LOOP ALL COLUMNS##}}
		${{COLUMN_FEILD}}       		=   	$values[0]["{{COLUMN_FEILD}}"] 	;
		$_SESSION["{{COLUMN_FEILD}}"]       =  	${{COLUMN_FEILD}}    ;
	    {{##END LOOP ALL COLUMNS##}}
            
        }
    }
?>
<html>
	<head>
		<title>MM's Bag [{{TABLE_NAME}}]</title>
		<meta charset="UTF-8"/>
	</head>
	<body>
    <?php

      
	{{##START LOOP ALL COLUMNS##}}
	    {{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}
	    if(isset( $_GET['return'] ) and $_GET['return'] == {{COLUMN_INDEX}})
	    {
		echo "<p style='color:red;'>กรุณากรอก{{COLUMN_COMMENT}}ด้วยค่ะ</p>";
	    }
       {{##END LOOP ALL COLUMNS##}}
       
   ?>
		<h1>insert new {{TABLE_NAME}}</h1>
                <?php
                    if($isEdit)
                    {
                        echo "<form action='{{TABLE_NAME}}_update_action.php' method='POST'>";
                    }
                    else
                    {
                        echo "<form action='{{TABLE_NAME}}_insert_action.php' method='POST'>";
                    }
                ?>
                    <ul>
                            <?php
                                if($isEdit)
                                {
                                    echo "<input type='hidden' name='id'         value= '$id;' />";
                                }
                            ?>
			    {{##START LOOP ALL COLUMNS##}}
				{{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}
				<li>{{COLUMN_FEILD}}  <input type="text" name="{{COLUMN_FEILD}}"         value= "<?php echo $_SESSION["{{COLUMN_FEILD}}"];?>" /> </li>
                            {{##END LOOP ALL COLUMNS##}}
       
			    <li> <input type="submit" name="submit" value="SAVE" /> </li>
                    </ul>
                </form>
               
	<body>
</html>