<?php
	require_once("food_function.php");
	$cat_id = $_GET['cat_id'];
	//echo "cat_id = $cat_id<br/>";
	$data =searchfood($cat_id,"cat_id");
	echo json_encode ($data);
?>