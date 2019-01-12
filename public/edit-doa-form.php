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
			
		$sql_query = "SELECT judul 
				FROM doa 
				WHERE id_doa = ?";
				
		$stmt_category = $connect->stmt_init();
		if($stmt_category->prepare($sql_query)) {	
			// Bind your variables to replace the ?s
			$stmt_category->bind_param('s', $ID);
			// Execute query
			$stmt_category->execute();
			// store result 
			$stmt_category->store_result();
			//$stmt_category->bind_result($previous_category_image);
			$stmt_category->fetch();
			$stmt_category->close();
		}
		
			
		if(isset($_POST['btnEdit'])){
			$judul = $_POST['judul'];
			$isi = $_POST['isi'];
			


			
			// get image info
			/*$menu_image = $_FILES['category_image']['name'];
			$image_error = $_FILES['category_image']['error'];
			$image_type = $_FILES['category_image']['type'];*/
				
			// create array variable to handle error
			$error = array();
				
			if(empty($judul)){
				$error['judul'] = " <span class='label label-danger'>Required!</span>";
			}
			
			// common image file extensions
			/*$allowedExts = array("gif", "jpeg", "jpg", "png");*/
			
			// get image file extension
			/*error_reporting(E_ERROR | E_PARSE);
			$extension = end(explode(".", $_FILES["category_image"]["name"]));*/
			
			if(!empty($menu_image)){
				if(!(($image_type == "image/gif") || 
					($image_type == "image/jpeg") || 
					($image_type == "image/jpg") || 
					($image_type == "image/x-png") ||
					($image_type == "image/png") || 
					($image_type == "image/pjpeg")) &&
					!(in_array($extension, $allowedExts))){
					
					$error['category_image'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
				}
			}
				
			if(!empty($judul) && empty($error['isi'])){
					
				if(!empty($menu_image)){
					
					// create random image file name
					$string = '0123456789';
					$file = preg_replace("/\s+/", "_", $_FILES['category_image']['name']);
					$function = new functions;
					$category_image = $function->get_random_string($string, 4)."-".date("Y-m-d").".".$extension;
				
					// delete previous image
					$delete = unlink("$previous_category_image");
					
					// upload new image
					$upload = move_uploaded_file($_FILES['category_image']['tmp_name'], 'upload/images/'.$category_image);
	  
					$sql_query = "UPDATE doa 
							SET judul = ?, isi = ? 
							WHERE id_doa = ?";
							
					$upload_image = 'upload/images/'.$category_image;
					$stmt = $connect->stmt_init();
					if($stmt->prepare($sql_query)) {	
						// Bind your variables to replace the ?s
						$stmt->bind_param('sss', 
									$judul, 
									$isi,
									$ID);
						// Execute query
						$stmt->execute();
						// store result 
						$update_result = $stmt->store_result();
						$stmt->close();
					}
				}else{
					
					$sql_query = "UPDATE doa 
							SET judul = ?, isi = ?
							WHERE id_doa = ?";
					
					$stmt = $connect->stmt_init();
					if($stmt->prepare($sql_query)) {	
						// Bind your variables to replace the ?s
						$stmt->bind_param('sss', 
									$judul,
									$isi, 
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
					$error['update_doa'] = " <h4><div class='alert alert-success'>
														Success update doa
														<a href='doa.php'>
														<i class='fa fa-check fa-lg'></i>
														</a></div>
												  </h4>";
				}else{
					$error['update_doa'] = " <span class='label label-danger'>Failed update doa</span>";
				}
			}
				
		}
			
		// create array variable to store previous data
		$data = array();
		
		$sql_query = "SELECT * 
				FROM doa 
				WHERE id_doa = ?";
		
		$stmt = $connect->stmt_init();
		if($stmt->prepare($sql_query)) {	
			// Bind your variables to replace the ?s
			$stmt->bind_param('s', $ID);
			// Execute query
			$stmt->execute();
			// store result 
			$stmt->store_result();
			$stmt->bind_result($data['id_doa'], 
					$data['judul'],
					$data['isi']
					);
			$stmt->fetch();
			$stmt->close();
		}

		if(isset($_POST['btnCancel'])){
			header("location: doa.php");
		}
		
	?>
	<div class="col-md-12">
		<h1>Edit Doa</h1>
		<?php echo isset($error['update_doa']) ? $error['update_doa'] : '';?>
		<hr />
	</div>
	
	<div class="col-md-5">
		<form method="post"
			enctype="multipart/form-data">
			<label>Judul :</label><?php echo isset($error['judul']) ? $error['judul'] : '';?>
			<input type="text" class="form-control" name="judul" value="<?php echo $data['judul']; ?>"/>
			<br/>

			<label>Do'a :</label><?php echo isset($error['isi']) ? $error['isi'] : '';?>
			<textarea name="isi" id="isi" class="form-control" rows="50"><?php echo $data['isi']; ?></textarea>
			<script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
			<script type="text/javascript">                        
            CKEDITOR.replace( 'isi' );
       		 </script>

			<br/><br/>
			<input type="submit" class="btn-primary btn" value="Update" name="btnEdit"/>
			<input type="submit" class="btn-danger btn" value="Cancel" name="btnCancel"/>
		</form>
	</div>

	<div class="separator"> </div>
</div>
	
<?php include_once('includes/close_database.php'); ?>