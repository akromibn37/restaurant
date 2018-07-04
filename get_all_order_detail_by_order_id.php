<?php
	require_once('mk_function.php');
	
	$status = $_POST['status'];
	$order_id = $_POST['order_id'];
	$status = explode("|", $status);

	$data = get_all_orderDetail_by_order_id($status,$order_id);
	$orderDetail_jason = json_encode($data);
	echo $orderDetail_jason;
	
	//print_r($status);


?>