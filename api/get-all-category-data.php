<?php
	include_once('../includes/connect_database.php'); 
	include_once('../includes/variables.php');
	
	if(isset($_GET['accesskey'])) {
		$access_key_received = $_GET['accesskey'];
		
		if($access_key_received == $access_key){
			// get all category data from category table
			$sql_query = "SELECT * 
					FROM quote";

					$r = mysqli_query($connect,$sql_query);
	
			//Membuat Array Kosong 
			$result = array();
			
			//$result = $connect->query($sql_query) or die ("Error :".mysql_error());
	 
			//$categories = array();
			while($row = mysqli_fetch_array($r)){
				array_push($result,array(
			"judul_quote"=>$row['judul_quote'],
			"quote_image"=>$row['quote_image']

		));
			}
			
			// create json output
			$output = json_encode($result);
		}else{
			die('accesskey is incorrect.');
		}
	} else {
		die('accesskey is required.');
	}
 
	//Output the output.
	echo $output;

	include_once('../includes/close_database.php'); 
?>