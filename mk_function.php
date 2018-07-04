<?php
	require_once('order/output/mk_order_function.php');
	require_once('order_detail/output/mk_order_detail_function.php');
	function createTable($table_no)
	{
		$order = isTableAlredyOpenBill($table_no);
		if($order === FALSE)
		{
			$status = "open";
			insertNewmk_order($table_no, $status);
			$order = searchmk_open_order($table_no);
		}

		return  ($order);

	}

	function order_food($food_id, $order_id)
	{
		$qty = 1; 
		$status = "wait_confirm";
		insertNewmk_order_detail($food_id, $order_id, $qty, $status);
	}
	function isTableAlredyOpenBill($table_no)
	{
		$order = searchmk_open_order($table_no);
		if(count($order) == 0)
		{
			return FALSE;
		}
		return $order;
	}
	function get_all_orderDetail_by_order_id($status,$order_id)
	{
		return getmk_order_detailByid_and_status($order_id,$status);
	}
	function confirm_orderDetail($orderDetail_id)
	{
		$mk_order_details = getmk_order_detailByid($orderDetail_id);
		echo "x1";
		if(count($mk_order_details) == 0) 
		{
			echo "error orderDetail ID does not exist ";
			echo "x2";
			exit;
		}
		if($mk_order_details[0]['status'] != 'wait_confirm' )
		{
			echo "x3";
			exit;
		}
		echo "x4";
		$id = $orderDetail_id;
		$food_id = $mk_order_details[0]['food_id'];
		$order_id = $mk_order_details[0]['order_id'];
		$qty = $mk_order_details[0]['qty'];
		$status = "confirmed";
		

		echo "id=  $id  food_id=  $food_id order_id = $order_id qty=$qty status=$status ";

		updatemk_order_detail( $id, $food_id, $order_id, $qty, $status);
	}
	

	function change_orderDetail_status($orderDetail_id,$newStatus)
	{
		$mk_order_details = getmk_order_detailByid($orderDetail_id);
		
		$id = $orderDetail_id;
		$food_id = $mk_order_details[0]['food_id'];
		$order_id = $mk_order_details[0]['order_id'];
		$qty = $mk_order_details[0]['qty'];
		$status = $newStatus;
		

		echo "id=  $id  food_id=  $food_id order_id = $order_id qty=$qty status=$status ";

		updatemk_order_detail( $id, $food_id, $order_id, $qty, $status);
	}


	function change_order_status($order_id,$newStatus)
	{
		$mk_order = getmk_orderByid($order_id);
		
		$id = $order_id;
		$table_no= $mk_order[0]['table_no'];
		$status = $newStatus;
		
		updatemk_order($id, $table_no, $status);
	}

?>