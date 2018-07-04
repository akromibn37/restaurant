<?php
	require_once('mk_function.php');
	//$status = "confirmed";//$_POST['status'];
	$order_detail_id = $_POST['order_detail_id'];


	confirm_orderDetail($order_detail_id);

?>