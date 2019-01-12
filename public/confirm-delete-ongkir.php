<?php
	include_once('includes/connect_database.php'); 
?>

<div id="content" class="container col-md-12">
	<?php 
		
		if(isset($_POST['btnDelete'])){
			if(isset($_GET['Id'])){
				$Id = $_GET['Id'];
			}else{
				$Id = "";
			}
			// get image file from table
			$sql_query = "SELECT provinsi 
					FROM tbl_ongkir 
					WHERE Id = ?";
			
			$stmt = $connect->stmt_init();
			if($stmt->prepare($sql_query)) {	
				// Bind your variables to replace the ?s
				$stmt->bind_param('s', $Id);
				// Execute query
				$stmt->execute();
				// store result 
				$stmt->store_result();
				$stmt->bind_result($provinsi);
				$stmt->fetch();
				$stmt->close();
			}
			
			// delete image file from directory
			/*$delete = unlink("$provinsi");*/
			
			// delete data from menu table
			$sql_query = "DELETE FROM tbl_ongkir 
					WHERE Id = ?";
			
			$stmt = $connect->stmt_init();
			if($stmt->prepare($sql_query)) {	
				// Bind your variables to replace the ?s
				$stmt->bind_param('s', $Id);
				// Execute query
				$stmt->execute();
				// store result 
				$delete_ongkir_result = $stmt->store_result();
				$stmt->close();
			}
			
			// get image file from table
			$sql_query = "SELECT provinsi 
					FROM tbl_ongkir 
					WHERE Id = ?";
			
			// create array variable to store menu image
			/*$image_data = array();
			
			$stmt_menu = $connect->stmt_init();
			if($stmt_menu->prepare($sql_query)) {	
				// Bind your variables to replace the ?s
				$stmt_menu->bind_param('s', $Id);
				// Execute query
				$stmt_menu->execute();
				// store result 
				$stmt_menu->store_result();
				$stmt_menu->bind_result($data['provinsi']);
			}
			*/
			// delete all menu image files from directory
			/*while($stmt_menu->fetch()){
				$provinsi = $image_data[provinsi];
				$delete_image = unlink("$provinsi");
			}*/
			
			/*$stmt_menu->close();
			*/
			// delete data from menu table
			$sql_query = "DELETE FROM tbl_ongkir 
					WHERE Id = ?";
			
			$stmt = $connect->stmt_init();
			if($stmt->prepare($sql_query)) {	
				// Bind your variables to replace the ?s
				$stmt->bind_param('s', $Id);
				// Execute query
				$stmt->execute();
				// store result 
				$delete_menu_result = $stmt->store_result();
				$stmt->close();
			}
				
			// if delete data success back to reservation page
			if($delete_ongkir_result && $delete_menu_result){
				header("location: ongkir.php");
			}
		}		
		
		if(isset($_POST['btnNo'])){
			header("location: ongkir.php");
		}
		
	?>
	<h1>Confirm Action</h1>
	<hr />
	<form method="post">
		<p>Are you sure want to delete this espedisi?</p>
		<input type="submit" class="btn btn-primary" value="Delete" name="btnDelete"/>
		<input type="submit" class="btn btn-danger" value="Cancel" name="btnNo"/>
	</form>
	<div class="separator"> </div>
</div>
			
<?php include_once('includes/close_database.php'); ?>