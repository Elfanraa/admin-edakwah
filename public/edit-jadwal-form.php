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
			
		$sql_query = "SELECT Nama_ustad 
				FROM jadwal_kajian 
				WHERE Id_kajian = ?";
				
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
				
			if(!empty($nama_ustad) && empty($error['category_image'])){
					
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
	  
					$sql_query = "UPDATE jadwal_kajian 
							SET Nama_ustad = ?, Hari = ?, Tanggal = ?, Jam = ?, Tema = ?, Materi = ? 
							WHERE Id_kajian = ?";
							
					$upload_image = 'upload/images/'.$category_image;
					$stmt = $connect->stmt_init();
					if($stmt->prepare($sql_query)) {	
						// Bind your variables to replace the ?s
						$stmt->bind_param('sssssss', 
									$nama_ustad, 
									$hari,
									$tanggal,
									$jam,
									$tema,
									$materi,
									$ID);
						// Execute query
						$stmt->execute();
						// store result 
						$update_result = $stmt->store_result();
						$stmt->close();
					}
				}else{
					
					$sql_query = "UPDATE jadwal_kajian 
							SET Nama_ustad = ?, Hari = ?, Tanggal = ?, Jam = ?, Tema = ?, Materi = ?
							WHERE Id_kajian = ?";
					
					$stmt = $connect->stmt_init();
					if($stmt->prepare($sql_query)) {	
						// Bind your variables to replace the ?s
						$stmt->bind_param('sssssss', 
									$nama_ustad,
									$hari,
									$tanggal,
									$jam,
									$tema,
									$materi, 
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
					$error['update_jadwal'] = " <h4><div class='alert alert-success'>
														Success update category
														<a href='jadwal.php'>
														<i class='fa fa-check fa-lg'></i>
														</a></div>
												  </h4>";
				}else{
					$error['update_jadwal'] = " <span class='label label-danger'>Failed update category</span>";
				}
			}
				
		}
			
		// create array variable to store previous data
		$data = array();
		
		$sql_query = "SELECT * 
				FROM jadwal_kajian 
				WHERE Id_kajian = ?";
		
		$stmt = $connect->stmt_init();
		if($stmt->prepare($sql_query)) {	
			// Bind your variables to replace the ?s
			$stmt->bind_param('s', $ID);
			// Execute query
			$stmt->execute();
			// store result 
			$stmt->store_result();
			$stmt->bind_result($data['Id_kajian'], 
					$data['Nama_ustad'],
					$data['Hari'],
					$data['Tanggal'],
					$data['Jam'],
					$data['Tema'],
					$data['Materi']
					);
			$stmt->fetch();
			$stmt->close();
		}

		if(isset($_POST['btnCancel'])){
			header("location: jadwal.php");
		}
		
	?>
	<!-- <div class="col-md-12">
		<h1>Edit Category</h1>
		<?php echo isset($error['update_ongkir']) ? $error['update_ongkir'] : '';?>
		<hr />
	</div>
	
	<div class="col-md-5">
		<form method="post"
			enctype="multipart/form-data">
			<label>Nama Ustad :</label><?php echo isset($error['nama_ustad']) ? $error['nama_ustad'] : '';?>
			<input type="text" class="form-control" name="nama_ustad" value="<?php echo $data['nama_ustad']; ?>"/>
			<br/>

			<label>Hari :</label><?php echo isset($error['hari']) ? $error['hari'] : '';?>
			<input type="text" class="form-control" name="hari" value="<?php echo $data['hari']; ?>"/>
			<br/>

			<label>Berat :</label><?php echo isset($error['berat']) ? $error['berat'] : '';?>
			<input type="text" class="form-control" name="berat" value="<?php echo $data['Berat']; ?>"/>
			<br/>

			<label>Harga</label><?php echo isset($error['harga']) ? $error['harga'] : '';?>
			<input type="text" class="form-control" name="harga" value="<?php echo $data['Harga']; ?>"/>
			<br/>
			<label>Image :</label><?php echo isset($error['category_image']) ? $error['category_image'] : '';?>
			<input type="file" name="category_image" id="category_image" /><br />
			<img src="<?php echo $data['Category_image']; ?>" width="280" height="190"/>
			<br/><br/>
			<input type="submit" class="btn-primary btn" value="Update" name="btnEdit"/>
			<input type="submit" class="btn-danger btn" value="Cancel" name="btnCancel"/>
		</form>
	</div> -->

	<div class="col-md-12">
		<h1>Add Jadwal</h1>
		<?php echo isset($error['update_jadwal']) ? $error['update_jadwal'] : '';?>
		<hr />
	</div>
	
	<div class="col-md-3">
		<form method="post"
			enctype="multipart/form-data">
			<label>Nama Ustad :</label><?php echo isset($error['nama_ustad']) ? $error['nama_ustad'] : '';?>
			<input type="text" class="form-control" name="nama_ustad" value="<?php echo $data['Nama_ustad']; ?>" />
			<br/>

			<label>Hari :</label><?php echo isset($error['hari']) ? $error['hari'] : '';?>
			<input type="text" class="form-control" name="hari"value="<?php echo $data['Hari']; ?>"/>
			<br/>

			<label>Tanggal :</label><?php echo isset($error['tanggal']) ? $error['tanggal'] : '';?>
			<input type="date" class="form-control" name="tanggal" value="<?php echo $data['Tanggal']; ?>"/>
			<br/>

			<label>Jam :</label><?php echo isset($error['jam']) ? $error['jam'] : '';?>
			<input type="time" class="form-control" name="jam" value="<?php echo $data['Jam']; ?>"/>
			<br/>
			
			<label>Tema :</label><?php echo isset($error['tema']) ? $error['tema'] : '';?>
			<input type="text" class="form-control" name="tema" value="<?php echo $data['Tema']; ?>" />
			<br/>
			
			
						</div>

			<div class="col-md-9">
			
			</br>
			<label>Materi :</label><?php echo isset($error['materi']) ? $error['materi'] : '';?>
			<textarea name="materi" id="materi" class="form-control" rows="16"><?php echo $data['Materi']; ?></textarea>
			<script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
			<script type="text/javascript">                        
            CKEDITOR.replace( 'materi' );
       		 </script>
       		</br>

       		<div class="col-md-12" align="center">
       		 <input type="submit" class="btn-primary btn" value="Update" name="btnEdit" style="width: 180px"    />

       		 <!-- &nbsp; &nbsp; &nbsp; <input type="reset" class="btn-warning btn" value="Clear" style="width: 180px" />
 -->

			&nbsp; &nbsp; &nbsp; <input type="submit" class="btn-danger btn" value="Back" name="btnCancel" style="width: 180px" />
       		 </div>



		</form>
	</div>

	<div class="separator"> </div>
</div>
	
<?php include_once('includes/close_database.php'); ?>