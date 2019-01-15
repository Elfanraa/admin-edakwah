<?php
	include_once('includes/connect_database.php'); 
	include_once('functions.php'); 
?>
<div id="content" class="container col-md-12">
	<?php 
		if(isset($_POST['btnAdd'])){
			$judul_info = $_POST['judul_info'];
			
			// get image info
			$info_image = $_FILES['info_image']['name'];
			$info_error = $_FILES['info_image']['error'];
			$info_type = $_FILES['info_image']['type'];
			
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
					
			if($info_error > 0){
				$error['info_image'] = " <span class='label label-danger'>Not Uploaded!!</span>";
			}else if(!(($info_type == "image/gif") || 
				($info_type == "image/jpeg") || 
				($info_type == "image/jpg") || 
				($info_type == "image/x-png") ||
				($info_type == "image/png") || 
				($info_type == "image/pjpeg")) &&
				!(in_array($extension, $allowedExts))){
			
				$error['info_image'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
			}
			
			if(!empty($judul_info) && empty($error['info_image'])){
				
				// create random image file name
				$string = '0123456789';
				$file = preg_replace("/\s+/", "_", $_FILES['info_image']['name']);
				$function = new functions;
				$menu_image = $function->get_random_string($string, 4)."-".date("Y-m-d").".".$extension;
					
				// upload new image
				$upload = move_uploaded_file($_FILES['info_image']['tmp_name'], 'upload/images/'.$info_image);
		
				// insert new data to menu table
				$sql_query = "INSERT INTO info (judul_info, info_image)
						VALUES(?, ?)";
				
				$upload_image = 'upload/images/'.$info_image;
				$stmt = $connect->stmt_init();
				if($stmt->prepare($sql_query)) {	
					// Bind your variables to replace the ?s
					$stmt->bind_param('ss', 
								$judul_info, 
								$upload_image
								);
					// Execute query
					$stmt->execute();
					// store result 
					$result = $stmt->store_result();
					$stmt->close();
				}
				
				if($result){
					$error['add_info'] = " <h4><div class='alert alert-success'>
														* Success add new info kegiatan
														<a href='info.php'>
														<i class='fa fa-check fa-lg'></i>
														</a></div>
												  </h4>";
				}else{
					$error['add_info'] = " <span class='label label-danger'>Failed add quote</span>";
				}
			}
			
		}

		if(isset($_POST['btnCancel'])){
			header("location: info.php");
		}

	?>
	<div class="col-md-12">
		<h1>Add Info Kegiatan</h1>
		<?php echo isset($error['add_info']) ? $error['add_info'] : '';?>
		<hr />
	</div>
	
	<div class="col-md-5">
		<form method="post"
			enctype="multipart/form-data">
			<label>Judul Info :</label><?php echo isset($error['judul_info']) ? $error['judul_info'] : '';?>
			<input type="text" class="form-control" name="judul_info"/>
			<br/>
			<label>Image :</label><?php echo isset($error['info_image']) ? $error['info_image'] : '';?>
			<input type="file" name="info_image" id="info_image" />
			<br/>
			<input type="submit" class="btn-primary btn" value="Submit" name="btnAdd"/>
			<input type="reset" class="btn-warning btn" value="Clear"/>
			<input type="submit" class="btn-danger btn" value="Cancel" name="btnCancel"/>
		</form>
	</div>

	<div class="separator"> </div>
</div>
	
<?php include_once('includes/close_database.php'); ?>