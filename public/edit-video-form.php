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
			
		$sql_query = "SELECT video 
				FROM video 
				WHERE id_video = ?";
				
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
			$judul_video = $_POST['judul_video'];
			$nama_penceramah = $_POST['nama_penceramah'];
			
			// get image info
			$menu_video = $_FILES['category_video']['name'];
			$video_error = $_FILES['category_video']['error'];
			$video_type = $_FILES['category_video']['type'];
				
			// create array variable to handle error
			$error = array();
				
			if(empty($judul_video)){
				$error['judul_video'] = " <span class='label label-danger'>Required!</span>";
			}
			
			// common image file extensions
			$allowedExts = array("mp4", "avi", "3gp", "mpeg" , "mov");
			
			// get image file extension
			error_reporting(E_ERROR | E_PARSE);
			$extension = end(explode(".", $_FILES["category_video"]["name"]));
			
			if(!empty($menu_image)){
				if(!(($video_type == "video/mp4") || 
				($video_type == "video/avi") || 
				($video_type == "video/3gp") || 
				($video_type == "video/mpeg") ||
				($video_type == "video/mov")) &&
				!(in_array($extension, $allowedExts))){
					
					$error['category_video'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
				}
			}
				
			if(!empty($judul_video) && empty($error['category_video'])){
					
				if(!empty($menu_video)){
					
					// create random image file name
					$string = '0123456789';
					$file = preg_replace("/\s+/", "_", $_FILES['category_video']['name']);
					$function = new functions;
					$category_video = $function->get_random_string($string, 4)."-".date("Y-m-d").".".$extension;
				
					// delete previous image
					$delete = unlink("$previous_category_image");
					
					// upload new image
					$upload = move_uploaded_file($_FILES['category_video']['tmp_name'], 'upload/video/'.$category_video);
	  
					$sql_query = "UPDATE video 
							SET judul_video = ?, nama_penceramah = ?, video = ?
							WHERE id_video = ?";
							
					$upload_video = 'upload/video/'.$category_video;
					$stmt = $connect->stmt_init();
					if($stmt->prepare($sql_query)) {	
						// Bind your variables to replace the ?s
						$stmt->bind_param('ssss', 
									$judul_video,
									$nama_penceramah, 
									$upload_video,
									$ID);
						// Execute query
						$stmt->execute();
						// store result 
						$update_result = $stmt->store_result();
						$stmt->close();
					}
				}else{
					
					$sql_query = "UPDATE video 
							SET judul_video = ?
							WHERE id_video = ?";
					
					$stmt = $connect->stmt_init();
					if($stmt->prepare($sql_query)) {	
						// Bind your variables to replace the ?s
						$stmt->bind_param('ss', 
									$judul_video, 
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
					$error['update_video'] = " <h4><div class='alert alert-success'>
														Success update video
														<a href='video.php'>
														<i class='fa fa-check fa-lg'></i>
														</a></div>
												  </h4>";
				}else{
					$error['update_video'] = " <span class='label label-danger'>Failed update video</span>";
				}
			}
				
		}
			
		// create array variable to store previous data
		$data = array();
		
		$sql_query = "SELECT * 
				FROM video 
				WHERE id_video = ?";
		
		$stmt = $connect->stmt_init();
		if($stmt->prepare($sql_query)) {	
			// Bind your variables to replace the ?s
			$stmt->bind_param('s', $ID);
			// Execute query
			$stmt->execute();
			// store result 
			$stmt->store_result();
			$stmt->bind_result($data['id_video'], 
					$data['judul_video'],
					$data['nama_penceramah'],
					$data['video']
					);
			$stmt->fetch();
			$stmt->close();
		}

		if(isset($_POST['btnCancel'])){
			header("location: video.php");
		}
		
	?>

	<div class="col-md-12">
		<h1>Edit Video</h1>
		<?php echo isset($error['update_video']) ? $error['update_video'] : '';?>
		<hr />
	</div>
	
	<div class="col-md-5">
		<form method="post"
			enctype="multipart/form-data">
			<label>Judul Video :</label><?php echo isset($error['judul_video']) ? $error['judul_video'] : '';?>
			<input type="text" class="form-control" name="judul_video" value="<?php echo $data['judul_video']; ?>"/>
			<br/>

			<label>Nama Penceramah :</label><?php echo isset($error['nama_penceramah']) ? $error['nama_penceramah'] : '';?>
			<input type="text" class="form-control" name="nama_penceramah" value="<?php echo $data['nama_penceramah']; ?>"/>
			<br/>

			<label>Video :</label><?php echo isset($error['category_video']) ? $error['category_video'] : '';?>
			<input type="file" name="category_video" id="category_video" /><br />
			<video src="<?php echo $data['category_video']; ?>"></video>
			<br/><br/>
			<input type="submit" class="btn-primary btn" value="Update" name="btnEdit"/>
			<input type="submit" class="btn-danger btn" value="Cancel" name="btnCancel"/>
		</form>
	</div>

	<div class="separator"> </div>
</div>
	
<?php include_once('includes/close_database.php'); ?>