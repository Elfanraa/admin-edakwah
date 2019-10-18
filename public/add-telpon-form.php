<?php
	include_once('includes/connect_database.php'); 
	include_once('functions.php'); 
?>
<div id="content" class="container col-md-12">
	 <?php 
		if(isset($_POST['btnAdd'])){

			$Jabatan=$_POST['Jabatan'];
			$Nama=$_POST['Nama'];
			$Pangkat_korps=$_POST['Pangkat_korps'];
			$Agama=$_POST['Agama'];
			$Kesatuan=$_POST['Kesatuan'];
			$Matra=$_POST['Matra'];
			$Alamat_kantor=$_POST['Alamat_kantor'];
			$No_telepon_kantor_1=$_POST['No_telepon_kantor_1'];
			$No_telepon_kantor_2=$_POST['No_telepon_kantor_2'];
			$No_fax=$_POST['No_fax'];
			$Alamat_Rumah=$_POST['Alamat_Rumah'];
			$No_telepon_rumah=$_POST['No_telepon_rumah'];
			$No_hp=$_POST['No_hp'];
			$Email=$_POST['Email'];

			
			// get image info
			$Foto_image = $_FILES['Foto_image']['name'];
			$Foto_error = $_FILES['Foto_image']['error'];
			$Foto_type = $_FILES['Foto_image']['type'];
			
			// create array variable to handle error
			$error = array();
			
			if(empty($Nama)){
				$error['Nama'] = " <span class='label label-danger'>Required!</span>";
			}
			
			// common image file extensions
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			
			// get image file extension
			error_reporting(E_ERROR | E_PARSE);
			$extension = end(explode(".", $_FILES["Foto_image"]["name"]));
					
			if($Foto_error > 0){
				$error['Foto_image'] = " <span class='label label-danger'>Not Uploaded!!</span>";
			}else if(!(($Foto_type == "image/gif") || 
				($Foto_type == "image/jpeg") || 
				($Foto_type == "image/jpg") || 
				($Foto_type == "image/x-png") ||
				($Foto_type == "image/png") || 
				($Foto_type == "image/pjpeg")) &&
				!(in_array($extension, $allowedExts))){
			
				$error['Foto_image'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
			}
			
			if(!empty($Nama) && empty($error['Foto_image'])){
				
				// create random image file name
				$string = '0123456789';
				$file = preg_replace("/\s+/", "_", $_FILES['Foto_image']['name']);
				$function = new functions;
				$menu_image = $function->get_random_string($string, 4)."-".date("Y-m-d").".".$extension;
					
				// upload new image
				$upload = move_uploaded_file($_FILES['Foto_image']['tmp_name'], 'upload/images/'.$Foto_image);
		
				// insert new data to menu table
				$sql_query = "INSERT INTO telepon (Jabatan,
								Nama,
								Foto,
								Pangkat_korps,
								Agama,
								Kesatuan,
								Matra,
								Alamat_kantor,
								No_telepon_kantor_1,
								No_telepon_kantor_2,
								No_fax,
								Alamat_Rumah,
								No_telepon_rumah,
								No_hp,
								Email)
						VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				
				$upload_image = 'upload/images/'.$Foto_image;
				$stmt = $connect->stmt_init();
				if($stmt->prepare($sql_query)) {	
					// Bind your variables to replace the ?s
					$stmt->bind_param('sssssssssssssss', 
								$Jabatan,
								$Nama,
								$upload_image,
								$Pangkat_korps,
								$Agama,
								$Kesatuan,
								$Matra,
								$Alamat_kantor,
								$No_telepon_kantor_1,
								$No_telepon_kantor_2,
								$No_fax,
								$Alamat_Rumah,
								$No_telepon_rumah,
								$No_hp,
								$Email

								);
					// Execute query
					$stmt->execute();
					// store result 
					$result = $stmt->store_result();
					$stmt->close();
				}
				
				if($result){
					$error['add_telpon'] = " <h4><div class='alert alert-success'>
														* Success Tambah Data
														<a href='telpon.php'>
														<i style='color:#3c763d' class='icon fa fa-check'></i>
														</a></div>
												  </h4>";
				}else{
					$error['add_telpon'] = " <span class='label label-danger'>Gagal Tambah Data</span>";
				}
			}
			
		}

		if(isset($_POST['btnCancel'])){
			header("location: telpon.php");
		}

	?>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<div class="col-md-12">
		<h1>Tambah Nomor Telepon</h1>
		<?php echo isset($error['add_telpon']) ? $error['add_telpon'] : '';?>
		<hr />
	</div>
	

	<div class="col-md-12">
		<form method="post"enctype="multipart/form-data">

			<label style="padding-left : 16px">Image :</label><?php echo isset($error['Foto_image']) ? $error['Foto_image'] : '';?>
			<input style="padding-left : 16px"  type="file" name="Foto_image" id="Foto_image" />
			<br/>
			
				<div class="col-md-6">
				
					<label>Jabatan :</label><?php echo isset($error['Jabatan']) ? $error['Jabatan'] : '';?>
					<input type="text" class="form-control" name="Jabatan"/>
					<br/>

					<label>Nama :</label><?php echo isset($error['Nama']) ? $error['Nama'] : '';?>
					<input type="text" class="form-control" name="Nama"/>
					<br/>

					<label>Pangkat / korps :</label><?php echo isset($error['Pangkat_korps']) ? $error['Pangkat_korps'] : '';?>
					<input type="text" class="form-control" name="Pangkat_korps"/>
					<br/>

					<label>Agama :</label><?php echo isset($error['Agama']) ? $error['Agama'] : '';?>
					<select class="form-control" name="Agama">
					<option value="Islam">Islam</option>
					<option value="Kristen">Kristen</option>
					<option value="Hindu">Hindu</option>
					<option value="Budha">Budha</option>
					<option value="Lainnya">Lainnya</option>
					</select>
					<br/>

					<label>Kesatuan :</label><?php echo isset($error['Kesatuan']) ? $error['Kesatuan'] : '';?>
					<input type="text" class="form-control" name="Kesatuan"/>
					<br/>
					
					<label>Matra :</label><?php echo isset($error['Matra']) ? $error['Matra'] : '';?>
					<input type="text" class="form-control" name="Matra"/>
					<br/>

					<label>Email :</label><?php echo isset($error['Email']) ? $error['Email'] : '';?>
					<input type="text" class="form-control" name="Email"/>
					<br/>
				</div>

					<div class="col-md-6">
						<label>Alamat_kantor :</label><?php echo isset($error['Alamat_kantor']) ? $error['Alamat_kantor'] : '';?>
						<input type="text" class="form-control" name="Alamat_kantor"/>
						<br/>

						<label>Nomor Telepon Kantor 1 :</label><?php echo isset($error['No_telepon_kantor_1']) ? $error['No_telepon_kantor_1'] : '';?>
						<input type="text" class="form-control" name="No_telepon_kantor_1"/>
						<br/>
						
						<label>Nomor Telepon Kantor 2 :</label><?php echo isset($error['No_telepon_kantor_2']) ? $error['No_telepon_kantor_2'] : '';?>
						<input type="text" class="form-control" name="No_telepon_kantor_2"/>
						<br/>
						
						<label>No FAX :</label><?php echo isset($error['No_fax']) ? $error['No_fax'] : '';?>
						<input type="text" class="form-control" name="No_fax"/>
						<br/>
						
						<label>Alamat Rumah :</label><?php echo isset($error['Alamat_Rumah']) ? $error['Alamat_Rumah'] : '';?>
						<input type="text" class="form-control" name="Alamat_Rumah"/>
						<br/>
						
						<label>Nomor Telepon Rumah :</label><?php echo isset($error['No_telepon_rumah']) ? $error['No_telepon_rumah'] : '';?>
						<input type="text" class="form-control" name="No_telepon_rumah"/>
						<br/>

						<label>No HP :</label><?php echo isset($error['No_hp']) ? $error['No_hp'] : '';?>
						<input type="text" class="form-control" name="No_hp"/>
						<br/>
					
					</div>
				<div class="col-md-12">

						<input type="submit" class="btn-primary btn" value="Submit" name="btnAdd"/>
					<input type="reset" class="btn-warning btn" value="Clear"/>
					<input type="submit" class="btn-danger btn" value="Cancel" name="btnCancel"/>
				</form>
			</div>
	<div class="separator"> </div>
</div>
	
<?php include_once('includes/close_database.php'); ?>