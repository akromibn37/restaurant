<?php
	$order_id = $_GET['order_id'];
	require_once('../mk_function.php');
	change_order_status($order_id,"cancel")
?>
