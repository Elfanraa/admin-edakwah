<?php
	include_once('includes/connect_database.php'); 
	include_once('functions.php'); 
?>
<div id="content" class="container col-md-12">
	<?php 
		if(isset($_GET['Id'])){
			$Id = $_GET['Id'];
		}else{
			$Id = "";
		}
		
		// create array variable to store category data
		$provinsi = array();
			
		$sql_query = "SELECT provinsi 
				FROM tbl_ongkir 
				WHERE Id = ?";
				
		$stmt_ongkir = $connect->stmt_init();
		if($stmt_ongkir->prepare($sql_query)) {	
			// Bind your variables to replace the ?s
			$stmt_ongkir->bind_param('s', $Id);
			// Execute query
			$stmt_ongkir->execute();
			// store result 
			$stmt_ongkir->store_result();
			/*$stmt_ongkir->bind_result($previous_category_image);*/
			$stmt_ongkir->fetch();
			$stmt_ongkir->close();
		}
		
			
		if(isset($_POST['btnEdit'])){
			$provinsi = $_POST['provinsi'];
			$provinsi = $_POST['berat'];
			$provinsi = $_POST['harga'];
			
			// get image info
			/*$menu_image = $_FILES['category_image']['name'];*/
			/*$image_error = $_FILES['category_image']['error'];*/
			/*$image_type = $_FILES['category_image']['type'];*/
				
			// create array variable to handle error
			$error = array();
				
			if(empty($provinsi)){
				$error['provinsi'] = " <span class='label label-danger'>Required!</span>";
			}
			
			// common image file extensions
			/*$allowedExts = array("gif", "jpeg", "jpg", "png");*/
			
			// get image file extension
			/*error_reporting(E_ERROR | E_PARSE);*/
			/*$extension = end(explode(".", $_FILES["category_image"]["name"]));*/
			
			/*if(!empty($menu_image)){
				if(!(($image_type == "image/gif") || 
					($image_type == "image/jpeg") || 
					($image_type == "image/jpg") || 
					($image_type == "image/x-png") ||
					($image_type == "image/png") || 
					($image_type == "image/pjpeg")) &&
					!(in_array($extension, $allowedExts))){
					
					$error['category_image'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
				}
			}*/
				
			/*if(!empty($provinsi) && empty($error['category_image'])){
					
				if(!empty($menu_image)){
					
					// create random image file name
					$string = '0123456789';
					$file = preg_replace("/\s+/", "_", $_FILES['category_image']['name']);
					$function = new functions;
					$category_image = $function->get_random_string($string, 4)."-".date("Y-m-d").".".$extension;
				
					// delete previous image
					$delete = unlink("$previous_category_image");*/
					
					// upload new image
					/*$upload = move_uploaded_file($_FILES['category_image']['tmp_name'], 'upload/images/'.$category_image);
	  
					$sql_query = "UPDATE tbl_category 
							SET provinsi = ?, Category_image = ?
							WHERE Category_ID = ?";
							
					$upload_image = 'upload/images/'.$category_image;
					$stmt = $connect->stmt_init();
					if($stmt->prepare($sql_query)) {	
						// Bind your variables to replace the ?s
						$stmt->bind_param('sss', 
									$provinsi, 
									$upload_image,
									$ID);*/
						// Execute query
						$stmt->execute();
						// store result 
						$update_result = $stmt->store_result();
						$stmt->close();
					}
				}else{
					
					$sql_query = "UPDATE tbl_ongkir 
							SET provinsi = ?
							WHERE Id = ?";
					
					$stmt = $connect->stmt_init();
					if($stmt->prepare($sql_query)) {	
						// Bind your variables to replace the ?s
						$stmt->bind_param('ss', 
									$provinsi, 
									$Id);
						// Execute query
						$stmt->execute();
						// store result 
						$update_result = $stmt->store_result();
						$stmt->close();
					}
				}
				
				// check update result
				if($update_result){
					$error['update_ongkir'] = " <h4><div class='alert alert-success'>
														Success update ongkir
														<a href='ongkir.php'>
														<i class='fa fa-check fa-lg'></i>
														</a></div>
												  </h4>";
				}else{
					$error['update_ongkir'] = " <span class='label label-danger'>Failed update ongkir</span>";
				}
			}
				
		}
			
		// create array variable to store previous data
		$data = array();
		
		$sql_query = "SELECT * 
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
			$stmt->bind_result($data['Id'], 
					$data['provinsi'],
					$data['berat'],
					$data['harga']
					);
			$stmt->fetch();
			$stmt->close();
		}

		if(isset($_POST['btnCancel'])){
			header("location: ongkir.php");
		}
		
	?>
	<div class="col-md-12">
		<h1>Edit Ekspedisi</h1>
		<?php echo isset($error['update_ongkir']) ? $error['update_ongkir'] : '';?>
		<hr />
	</div>
	
	<div class="col-md-5">
		<form method="post"
			enctype="multipart/form-data">
			<label>Provinsi :</label><?php echo isset($error['provinsi']) ? $error['provinsi'] : '';?>
			<input type="text" class="form-control" name="provinsi" value="<?php echo $data['provinsi']; ?>"/>
			<br/>
			<label>Berat :</label><?php echo isset($error['berat']) ? $error['berat'] : '';?>
			<input type="text" class="form-control" name="berat" value="<?php echo $data['berat']; ?>"/>
			<br/>
			<label>Harga :</label><?php echo isset($error['harga']) ? $error['harga'] : '';?>
			<input type="text" class="form-control" name="harga" value="<?php echo $data['harga']; ?>"/>
			<br/><br/>
			<input type="submit" class="btn-primary btn" value="Update" name="btnEdit"/>
			<input type="submit" class="btn-danger btn" value="Cancel" name="btnCancel"/>
		</form>
	</div>

	<div class="separator"> </div>
</div>
	
<?php include_once('includes/close_database.php'); ?>