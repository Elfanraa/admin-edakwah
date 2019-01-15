<?php
	include_once('includes/connect_database.php'); 
	include_once('functions.php'); 
?>
<div id="content" class="container col-md-12">
	<?php 

		if(isset($_POST['btnAdd'])){
			$nama_ustad = $_POST['nama_ustad'];
			$hari = $_POST['hari'];
			$tanggal = $_POST['tanggal'];
			$jam = $_POST['jam'];
			$tema = $_POST['tema'];
			$materi = $_POST['materi'];

			
			// get image info
			/*$menu_image = $_FILES['category_image']['name'];
			$image_error = $_FILES['category_image']['error'];
			$image_type = $_FILES['category_image']['type'];*/
			
			// create array variable to handle error
			$error = array();
			
			if(empty($nama_ustad)){
				$error['nama_ustad'] = " <span class='label label-danger'>Required!</span>";
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
				$sql_query = "INSERT INTO jadwal_kajian (nama_ustad, hari, tanggal, jam, tema, materi)
						VALUES(?, ?, ?, ?, ?, ?)";
				
				/*$upload_image = 'upload/images/'.$menu_image;*/
				$stmt = $connect->stmt_init();
				if($stmt->prepare($sql_query)) {
					// Bind your variables to replace the ?s
					$stmt->bind_param('ssssss', 
								$nama_ustad, 
								$hari,
								$tanggal,
								$jam,
								$tema,
								$materi
								);
					// Execute query
					$stmt->execute();
					// store result 
					$result = $stmt->store_result();
					$stmt->close();
				}
				
				if($result){
					$error['add_jadwal'] = " <h4><div class='alert alert-success'>
														* Success add new jadwal kajian
														<a href='jadwal.php'>
														<i class=fas fa-check'></i>
														</a></div>
												  </h4>";
				}else{
					$error['add_jadwal'] = " <span class='label label-danger'>Failed add jadwal kajian</span>";
				}
			}
			

		/*if(isset($_POST['btnCancel'])){*/
			/*header("location: ongkir.php");*/
		/*}*/

		if(isset($_POST['btnCancel'])){
			header("location: jadwal.php");
		}		

	?>
	<div class="col-md-12">
		<h1>Add Jadwal</h1>
		<?php echo isset($error['add_jadwal']) ? $error['add_jadwal'] : '';?>
		<hr />
	</div>
	
	<div class="col-md-3">
		<form method="post"
			enctype="multipart/form-data">
			<label>Nama Ustad :</label><?php echo isset($error['nama_ustad']) ? $error['nama_ustad'] : '';?>
			<input type="text" class="form-control" name="nama_ustad"/>
			<br/>

			<label>Hari :</label><?php echo isset($error['hari']) ? $error['hari'] : '';?>
			<input type="text" class="form-control" name="hari"/>
			<br/>

			<label>Tanggal :</label><?php echo isset($error['tanggal']) ? $error['tanggal'] : '';?>
			<input type="date" class="form-control" name="tanggal"/>
			<br/>

			<label>Jam :</label><?php echo isset($error['jam']) ? $error['jam'] : '';?>
			<input type="time" class="form-control" name="jam"/>
			<br/>
			
			<label>Tema :</label><?php echo isset($error['tema']) ? $error['tema'] : '';?>
			<input type="text" class="form-control" name="tema"/>
			<br/>
			
			
						</div>

			<div class="col-md-9">
			
			</br>
			<label>Materi :</label><?php echo isset($error['materi']) ? $error['materi'] : '';?>
			<textarea name="materi" id="materi" class="form-control" rows="16"></textarea>
			<script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
			<script type="text/javascript">                        
            CKEDITOR.replace( 'materi' );
       		 </script>
       		</br>

       		<div class="col-md-12" align="center">
       		 <input type="submit" class="btn-primary btn" value="Add" name="btnAdd" style="width: 180px"    />



			&nbsp; &nbsp; &nbsp; <input type="submit" class="btn-warning btn"  style="width: 180px" value="Clear" onclick="reset()"  />
			<script>
			funcion reset(){
				location.reload();
			}
			</script>


			&nbsp; &nbsp; &nbsp; <input type="submit" class="btn-danger btn" value="Cancel" name="btnCancel" style="width: 180px" />
       		 </div>



		</form>
	</div>
	


	<div class="separator"> </div>
</div>
	
<?php include_once('includes/close_database.php'); ?>