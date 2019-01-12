<?php
	include_once('../includes/connect_database.php'); 
	include_once('../includes/variables.php');

	
	// get data from android app
	$menu_id =  $_POST['Menu_ID'];
    //$menu_name =  $_POST['Menu_name'];
	$quantity = $_POST['Quantity'];

	$quantity_integer= intval($quantity);
	
	$sql_query = "set names 'utf8'";
	$stmt = $connect->stmt_init();
	if($stmt->prepare($sql_query)) {	
		// Execute query
		$stmt->execute();
		// store result 
		$stmt->close();
	}

	// var_dump($menu_id);
	// var_dump($menu_name);
	// var_dump($quantity_integer);
	// exit();

	
	// update table menu
	$sql_query = "UPDATE tbl_menu 
					SET
					Quantity =Quantity-?  
					WHERE Menu_ID = ?";

	
	$stmt = $connect->stmt_init();
	if($stmt->prepare($sql_query)) {	
				// Bind your variables to replace the ?s
				$stmt->bind_param('ss',$quantity,$menu_id);
				// Execute query
				$stmt->execute();
				// store result 
				$update_result = $stmt->store_result();
				$stmt->close();
				echo "OK";
	} else {
				echo "Failed";
	}
	
	include_once('../includes/close_database.php');
?>