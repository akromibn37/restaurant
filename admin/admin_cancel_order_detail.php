<?php
	require_once('../mk_function.php');

	$order_detail_id = $_GET['order_detail_id'];
	$newStatus = "cancel";
	change_orderDetail_status($order_detail_id,$newStatus);

?>