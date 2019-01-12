<?php
	include_once('includes/connect_database.php'); 
	include_once('functions.php'); 
?>
<div id="content" class="container col-md-12">
	<?php 
		if(isset($_POST['btnAdd'])){
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
					
			if($image_error > 0){
				$error['category_video'] = " <span class='label label-danger'>Not Uploaded!!</span>";
			}else if(!(($video_type == "video/mp4") || 
				($video_type == "video/avi") || 
				($video_type == "video/3gp") || 
				($video_type == "video/mpeg") ||
				($video_type == "video/mov")) &&
				!(in_array($extension, $allowedExts))){
			
				$error['category_video'] = " <span class='label label-danger'>video type must mp4, avi, 3gp, mpeg, or mov!</span>";
			}
			
			if(!empty($judul_video) && empty($error['category_video'])){
				
				// create random image file name
				$string = '0123456789';
				$file = preg_replace("/\s+/", "_", $_FILES['category_video']['name']);
				$function = new functions;
				$menu_video = $function->get_random_string($string, 4)."-".date("Y-m-d").".".$extension;
					
				// upload new image
				$upload = move_uploaded_file($_FILES['category_video']['tmp_name'], 'upload/video/'.$menu_video);
		
				// insert new data to menu table
				$sql_query = "INSERT INTO video (judul_video,nama_penceramah, video)
						VALUES(?, ?, ?)";
				
				$upload_video = 'upload/video/'.$menu_video;
				$stmt = $connect->stmt_init();
				if($stmt->prepare($sql_query)) {	
					// Bind your variables to replace the ?s
					$stmt->bind_param('sss', 
								$judul_video,
								$nama_penceramah, 
								$upload_video
								);
					// Execute query
					$stmt->execute();
					// store result 
					$result = $stmt->store_result();
					$stmt->close();
				}
				
				if($result){
					$error['add_video'] = " <h4><div class='alert alert-success'>
														* Success add new video
														<a href='video.php'>
														<i class='fa fa-check fa-lg'></i>
														</a></div>
												  </h4>";
				}else{
					$error['add_video'] = " <span class='label label-danger'>Failed add video</span>";
				}
			}
			
		}

		if(isset($_POST['btnCancel'])){
			header("location: video.php");
		}

	?>
	<div class="col-md-12">
		<h1>Add Video</h1>
		<?php echo isset($error['add_video']) ? $error['add_video'] : '';?>
		<hr />
	</div>
	
	<div class="col-md-5">
		<form method="post"
			enctype="multipart/form-data">
			<label>Judul Video :</label><?php echo isset($error['judul_video']) ? $error['judul_video'] : '';?>
			<input type="text" class="form-control" name="judul_video"/>
			<br/>
			<label>Nama Penceramah :</label><?php echo isset($error['nama_penceramah']) ? $error['nama_penceramah'] : '';?>
			<input type="text" class="form-control" name="nama_penceramah"/>
			<br/>
			<label>Video :</label><?php echo isset($error['category_video']) ? $error['category_video'] : '';?>
			<input type="file" name="category_video" id="category_video" />
			<br/>
			<input type="submit" class="btn-primary btn" value="Submit" name="btnAdd"/>
			<input type="reset" class="btn-warning btn" value="Clear"/>
			<input type="submit" class="btn-danger btn" value="Cancel" name="btnCancel"/>
		</form>
	</div>

	<div class="separator"> </div>
</div>
	
<?php include_once('includes/close_database.php'); ?>