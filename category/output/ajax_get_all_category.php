<?php
	require_once("category_function.php");
	$data = getAllcategory();
	echo json_encode ($data);
?>