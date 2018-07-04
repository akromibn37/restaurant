<?php
	require_once('../order_detail/output/mk_order_detail_function.php');

	$order_id = $_GET['order_id'];
	$status = array();
	$detail = getmk_order_detailByid_and_status($order_id,$status);

?>
<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>jQuery UI Tabs - Default functionality</title>
      <link rel="stylesheet" href="jquery-ui/jquery-ui.css">
      <script src="jquery-2.1.3.min.js"></script>
      <script src="jquery-ui/jquery-ui.js"></script>

      <!-- Bootstrap -->
      <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link href="mk.css" rel="stylesheet">

    </head>
    <body>

    	<a href="admin_close_order_paid.php?order_id=<?php echo $order_id; ?>"  > จ่ายตังแล้ว </a>
    	<br/>
    	<br/>
    	<a href="admin_close_order_cancel.php?order_id=<?php echo $order_id; ?>"  > ยกเลิกไม่กินแล้ว </a>
    	
    	<br/>
    	<br/>
    	

    	<table border='1' style= 'border-collapse: collapse;'>

    		<tr>
				<th>id</th>
				<th>food_id</th>
				<th>order_id</th>
				<th>qty</th>
				<th>status</th>
				<th>insert_time</th>
				<th>food_id_x</th>
				<th>food_name</th>
				<th>food_description</th>
				<th>food_price</th>
				<th>food_image</th>
				<th>food_cat_id</th>
				<th>cancel</th>
				<th>served</th>
            </tr>
    		<?php
    			/*
				"id"=>$id,
                "food_id"=>$food_id,
                "order_id"=>$order_id,
                "qty"=>$qty,
                "status"=>$status,
                "insert_time"=>$insert_time,

                "food_id_x"=>$food_id_x,
                "food_name"=>$food_name,
                "food_description"=>$food_description,
                "food_price"=>$food_price,
                "food_image"=>$food_image,
                "food_cat_id"=>$food_cat_id,


    			*/
    			for($i = 0 ; $i < count ($detail) ; $i ++)
    			{
    				echo "<tr>";
    					echo "<td>";
    					echo $detail[$i]['id'];
    					echo "</td>";
    					echo "<td>";
    					echo $detail[$i]['food_id'];
    					echo "</td>";
    					echo "<td>";
    					echo $detail[$i]['order_id'];
    					echo "</td>";
    					echo "<td>";
    					echo $detail[$i]['qty'];
    					echo "</td>";
    					echo "<td>";
    					echo $detail[$i]['status'];
    					echo "</td>";
    					echo "<td>";
    					echo $detail[$i]['insert_time'];
    					echo "</td>";
    					echo "<td>";
    					echo $detail[$i]['food_id_x'];
    					echo "</td>";
    					echo "<td>";
    					echo $detail[$i]['food_name'];
    					echo "</td>";
    					echo "<td>";
    					echo $detail[$i]['food_description'];
    					echo "</td>";
    					echo "<td>";
    					echo $detail[$i]['food_price'];
    					echo "</td>";
    					echo "<td>";
    					echo $detail[$i]['food_image'];
    					echo "</td>";
    					echo "<td>";
    					echo $detail[$i]['food_cat_id'];
    					echo "</td>";


    					echo "<td>";
    					echo "<a href='admin_cancel_order_detail.php?order_detail_id=".$detail[$i]['id']."' > cancle </a>  ";
    					echo "</td>";

    					echo "<td>";
    					echo "<a href='admin_served_order_detail.php?order_detail_id=".$detail[$i]['id']."' > serve แล้ว </a>  ";
    					echo "</td>";
    				echo "</tr>";
    			}
    		?>
    	</table>


    </body>
</html>