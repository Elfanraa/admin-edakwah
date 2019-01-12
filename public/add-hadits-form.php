<?php
	include_once('includes/connect_database.php'); 
	include_once('functions.php'); 
?>
<div id="content" class="container col-md-12">
	<?php 

		if(isset($_POST['btnAdd'])){
			$judul_hadits = $_POST['judul_hadits'];
			$isi_hadits = $_POST['isi_hadits'];

			// get image info
			/*$menu_image = $_FILES['category_image']['name'];
			$image_error = $_FILES['category_image']['error'];
			$image_type = $_FILES['category_image']['type'];*/
			
			// create array variable to handle error
			$error = array();
			
			if(empty($judul_hadits)){
				$error['judul_hadits'] = " <span class='label label-danger'>Required!</span>";
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
				$sql_query = "INSERT INTO hadits (judul_hadits,isi_hadits)
						VALUES(?, ?)";
				
				/*$upload_image = 'upload/images/'.$menu_image;*/
				$stmt = $connect->stmt_init();
				if($stmt->prepare($sql_query)) {
					// Bind your variables to replace the ?s
					$stmt->bind_param('ss', 
								$judul_hadits, 
								$isi_hadits
								);
					// Execute query
					$stmt->execute();
					// store result 
					$result = $stmt->store_result();
					$stmt->close();
				}
				
				if($result){
					$error['add_hadits'] = " <h4><div class='alert alert-success'>
														* Success add new hadits
														<a href='hadits.php'>
														<i class='fa fa-check fa-lg'></i>
														</a></div>
												  </h4>";
				}else{
					$error['add_hadits'] = " <span class='label label-danger'>Failed add hadits</span>";
				}
			}
			

		/*if(isset($_POST['btnCancel'])){*/
			/*header("location: ongkir.php");*/
		/*}*/

		if(isset($_POST['btnCancel'])){
			header("location: hadits.php");
		}

		if(isset($_POST['btnClear'])){
			header("location: add_hadits.php");
		}		

	?>
	<div class="col-md-12">
		<h1>Add Hadits</h1>
		<?php echo isset($error['add_hadits']) ? $error['add_hadits'] : '';?>
		<hr />
	</div>
	
	<div class="col-md-12">
		<form method="post"
			enctype="multipart/form-data">
			<label>Judul Hadits :</label><?php echo isset($error['judul_hadits']) ? $error['judul_hadits'] : '';?>
			<input type="text" class="form-control" name="judul_hadits"/>
			<br/>

			<label>Isi Hadits :</label><?php echo isset($error['isi_hadits']) ? $error['isi_hadits'] : '';?>
			<textarea name="isi_hadits" id="isi_hadits" class="form-control" rows="50"></textarea>
			<script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
			<script type="text/javascript">                        
            CKEDITOR.replace( 'isi_hadits' );
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