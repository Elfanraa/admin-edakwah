<?php
	include_once('includes/connect_database.php'); 
	include_once('functions.php'); 
?>
<div id="content" class="container col-md-12">
	<?php 

		if(isset($_POST['btnAdd'])){
			$judul_inspirasi = $_POST['judul_inspirasi'];
			$isi_inspirasi = $_POST['isi_inspirasi'];

			// get image info
			/*$menu_image = $_FILES['category_image']['name'];
			$image_error = $_FILES['category_image']['error'];
			$image_type = $_FILES['category_image']['type'];*/
			
			// create array variable to handle error
			$error = array();
			
			if(empty($judul_inspirasi)){
				$error['judul_inspirasi'] = " <span class='label label-danger'>Required!</span>";
			}
			
			// common image file extensions
			/*$allowedExts = array("gif", "jpeg", "jpg", "png");*/
			
			// get image file extension
			/*error_reporting(E_ERROR | E_PARSE);*/
			/*$extension = end(explode(".", $_FILES["category_image"]["name"]));*/
					
			/*if($image_error > 0){*/
				/*$error['category_image'] = " <span class='label label-danger'>Not Uploaded!!</span>";*/
			/*}else if(!(($image_type == "image/gif") || */
				/*($image_type == "image/jpeg") || */
				/*($image_type == "image/jpg") || */
				/*($image_type == "image/x-png") ||*/
				/*($image_type == "image/png") || */
				/*($image_type == "image/pjpeg")) &&*/
				/*!(in_array($extension, $allowedExts))){
			*/
				/*$error['category_image'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
			}*/
			
			/*if(!empty($category_name) && empty($error['category_image'])){*/
				
				// create random image file name
				/*$string = '0123456789';*/
				/*$file = preg_replace("/\s+/", "_", $_FILES['category_image']['name']);*/
				/*$function = new functions;*/
				/*$menu_image = $function->get_random_string($string, 4)."-".date("Y-m-d").".".$extension;*/
					
				// upload new image
				/*$upload = move_uploaded_file($_FILES['category_image']['tmp_name'], 'upload/images/'.$menu_image);*/
		
				// insert new data to menu table
				$sql_query = "INSERT INTO inspirasi (judul_inspirasi,isi_inspirasi)
						VALUES(?, ?)";
				
				/*$upload_image = 'upload/images/'.$menu_image;*/
				$stmt = $connect->stmt_init();
				if($stmt->prepare($sql_query)) {
					// Bind your variables to replace the ?s
					$stmt->bind_param('ss', 
								$judul_inspirasi, 
								$isi_inspirasi
								);
					// Execute query
					$stmt->execute();
					// store result 
					$result = $stmt->store_result();
					$stmt->close();
				}
				
				if($result){
					$error['add_inspirasi'] = " <h4><div class='alert alert-success'>
														* Success add new inspirasi
														<a href='inspirasi.php'>
														<i style='color:#3c763d' class='icon fa fa-check'></i>
														</a></div>
												  </h4>";
				}else{
					$error['add_inspirasi'] = " <span class='label label-danger'>Failed add inspirasi</span>";
				}
			}
			

		/*if(isset($_POST['btnCancel'])){*/
			/*header("location: ongkir.php");*/
		/*}*/

		if(isset($_POST['btnCancel'])){
			header("location: inspirasi.php");
		}

		if(isset($_POST['btnClear'])){
			header("location: add_inspirasi.php");
		}		

	?>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<div class="col-md-12">
		<h1>Add Cerita Inspirasi</h1>
		<?php echo isset($error['add_inspirasi']) ? $error['add_inspirasi'] : '';?>
		<hr />
	</div>
	
	<div class="col-md-12">
		<form method="post"
			enctype="multipart/form-data">
			<label>Judul Cerita Inspirasi :</label><?php echo isset($error['judul_inspirasi']) ? $error['judul_inspirasi'] : '';?>
			<input type="text" class="form-control" name="judul_inspirasi"/>
			<br/>

			<label>Isi Cerita Inspirasi :</label><?php echo isset($error['isi_inspirasi']) ? $error['isi_inspirasi'] : '';?>
			<textarea name="isi_inspirasi" id="isi_inspirasi" class="form-control" rows="50"></textarea>
			<script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
			<script type="text/javascript">                        
            CKEDITOR.replace( 'isi_inspirasi' );
       		 </script>

			
			<br/>
			<input type="submit" class="btn-primary btn" value="Submit" name="btnAdd"/>
			<input type="submit" class="btn-warning btn" value="Clear" onclick="reset()"  />
			<script>
			funcion reset(){
				location.reload();
			}
			</script>

			<input type="submit" class="btn-danger btn" value="Cancel" name="btnCancel"/>
		</form>
	</div>

	<div class="separator"> </div>
</div>
	
<?php include_once('includes/close_database.php'); ?>