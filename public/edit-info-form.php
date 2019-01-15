<?php
	include_once('includes/connect_database.php'); 
	include_once('functions.php'); 
?>
<div id="content" class="container col-md-12">
	<?php 
		if(isset($_GET['id'])){
			$ID = $_GET['id'];
		}else{
			$ID = "";
		}
		
		// create array variable to store category data
		$category_data = array();
			
		$sql_query = "SELECT info_image 
				FROM info
				WHERE id_info = ?";
				
		$stmt_category = $connect->stmt_init();
		if($stmt_category->prepare($sql_query)) {	
			// Bind your variables to replace the ?s
			$stmt_category->bind_param('s', $ID);
			// Execute query
			$stmt_category->execute();
			// store result 
			$stmt_category->store_result();
			$stmt_category->bind_result($previous_category_image);
			$stmt_category->fetch();
			$stmt_category->close();
		}
		
			
		if(isset($_POST['btnEdit'])){
			$judul_info = $_POST['judul_info'];
			
			// get image info
			$menu_image = $_FILES['info_image']['name'];
			$image_error = $_FILES['info_image']['error'];
			$image_type = $_FILES['info_image']['type'];
				
			// create array variable to handle error
			$error = array();
				
			if(empty($judul_info)){
				$error['judul_info'] = " <span class='label label-danger'>Required!</span>";
			}
			
			// common image file extensions
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			
			// get image file extension
			error_reporting(E_ERROR | E_PARSE);
			$extension = end(explode(".", $_FILES["info_image"]["name"]));
			
			if(!empty($info_image)){
				if(!(($info_type == "image/gif") || 
					($info_type == "image/jpeg") || 
					($info_type == "image/jpg") || 
					($info_type == "image/x-png") ||
					($info_type == "image/png") || 
					($info_type == "image/pjpeg")) &&
					!(in_array($extension, $allowedExts))){
					
					$error['info_image'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
				}
			}
				
			if(!empty($judul_info) && empty($error['info_image'])){
					
				if(!empty($info_image)){
					
					// create random image file name
					$string = '0123456789';
					$file = preg_replace("/\s+/", "_", $_FILES['info_image']['name']);
					$function = new functions;
					$info_image = $function->get_random_string($string, 4)."-".date("Y-m-d").".".$extension;
				
					// delete previous image
					$delete = unlink("$previous_info_image");
					
					// upload new image
					$upload = move_uploaded_file($_FILES['info_image']['tmp_name'], 'upload/images/'.$info_image);
	  
					$sql_query = "UPDATE info 
							SET judul_info = ?, info_image = ?
							WHERE id_info = ?";
							
					$upload_image = 'upload/images/'.$info_image;
					$stmt = $connect->stmt_init();
					if($stmt->prepare($sql_query)) {	
						// Bind your variables to replace the ?s
						$stmt->bind_param('sss', 
									$judul_info, 
									$upload_image,
									$ID);
						// Execute query
						$stmt->execute();
						// store result 
						$update_result = $stmt->store_result();
						$stmt->close();
					}
				}else{
					
					$sql_query = "UPDATE info
							SET judul_info = ?
							WHERE id_info = ?";
					
					$stmt = $connect->stmt_init();
					if($stmt->prepare($sql_query)) {	
						// Bind your variables to replace the ?s
						$stmt->bind_param('ss', 
									$judul_info, 
									$ID);
						// Execute query
						$stmt->execute();
						// store result 
						$update_result = $stmt->store_result();
						$stmt->close();
					}
				}
				
				// check update result
				if($update_result){
					$error['update_info'] = " <h4><div class='alert alert-success'>
														Success update info
														<a href='info_image.php'>
														<i class='fa fa-check fa-lg'></i>
														</a></div>
												  </h4>";
				}else{
					$error['update_info'] = " <span class='label label-danger'>Failed update info</span>";
				}
			}
				
		}
			
		// create array variable to store previous data
		$data = array();
		
		$sql_query = "SELECT * 
				FROM info 
				WHERE id_info = ?";
		
		$stmt = $connect->stmt_init();
		if($stmt->prepare($sql_query)) {	
			// Bind your variables to replace the ?s
			$stmt->bind_param('s', $ID);
			// Execute query
			$stmt->execute();
			// store result 
			$stmt->store_result();
			$stmt->bind_result($data['id_info'], 
					$data['judul_info'],
					$data['info_image']
					);
			$stmt->fetch();
			$stmt->close();
		}

		if(isset($_POST['btnCancel'])){
			header("location: info.php");
		}
		
	?>

	<div class="col-md-12">
		<h1>Edit Info</h1>
		<?php echo isset($error['update_info']) ? $error['update_info'] : '';?>
		<hr />
	</div>
	
	<div class="col-md-5">
		<form method="post"
			enctype="multipart/form-data">
			<label>Judul Info :</label><?php echo isset($error['judul_info']) ? $error['judul_info'] : '';?>
			<input type="text" class="form-control" name="judul_info" value="<?php echo $data['judul_info']; ?>"/>
			<br/>
			<label>Image :</label><?php echo isset($error['info_image']) ? $error['info_image'] : '';?>
			<input type="file" name="info_image" id="info_image" /><br />
			<img src="<?php echo $data['info_image']; ?>" width="280" height="190"/>
			<br/><br/>
			<input type="submit" class="btn-primary btn" value="Update" name="btnEdit"/>
			<input type="submit" class="btn-danger btn" value="Cancel" name="btnCancel"/>
		</form>
	</div>

	<div class="separator"> </div>
</div>
	
<?php include_once('includes/close_database.php'); ?>