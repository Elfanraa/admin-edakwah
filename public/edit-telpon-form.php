<?php
	include_once('includes/connect_database.php'); 
	include_once('functions.php'); 
?>
<div id="content" class="container col-md-12">
	<div id="content" class="container col-md-12">
	<?php 
	
		if(isset($_GET['id'])){
			$ID = $_GET['id'];
		}else{
			$ID = "";
		}
		
		// create array variable to store category data
		$category_data = array();
			
		$sql_query = "SELECT Foto FROM telepon WHERE id = ?";
		
		$stmt = $connect->stmt_init();
		if($stmt->prepare($sql_query)) {	
			// Bind your variables to replace the ?s
			$stmt->bind_param('s', $ID);
			// Execute query
			$stmt->execute();
			// store result 
			$stmt->store_result();
			$stmt->bind_result($previous_Foto_image);
			$stmt->fetch();
			$stmt->close();
		}
		
		
		
		if(isset($_POST['btnEdit'])){
			
			$Jabatan=$_POST['Jabatan'];
			$Nama=$_POST['Nama'];
			$Pangkat_korps=$_POST['Pangkat_korps'];
			$Agama=$_POST['Agama'];
			$Kesatuan=$_POST['Kesatuan'];
			$Matra=$_POST['Matra'];
			$Email=$_POST['Email'];
			$Alamat_kantor=$_POST['Alamat_kantor'];
			$No_telepon_kantor_1=$_POST['No_telepon_kantor_1'];
			$No_telepon_kantor_2=$_POST['No_telepon_kantor_2'];
			$No_fax=$_POST['No_fax'];
			$Alamat_Rumah=$_POST['Alamat_Rumah'];
			$No_telepon_rumah=$_POST['No_telepon_rumah'];
			$No_hp=$_POST['No_hp'];

				// get image info
			$Foto_image = $_FILES['Foto_image']['name'];
			$Foto_error = $_FILES['Foto_image']['error'];
			$Foto_type = $_FILES['Foto_image']['type'];
				
			// create array variable to handle error
			$error = array();
			
			if(empty($Jabatan)){
				$error['Jabatan'] = " <span class='label label-danger'>Required!</span>";
			}

			if(empty($Nama)){
				$error['Nama'] = " <span class='label label-danger'>Required!</span>";
			}


			if(empty($Pangkat_korps)){
				$error['Pangkat_korps'] = " <span class='label label-danger'>Required!</span>";
			}
				
			if(empty($Agama)){
				$error['Agama'] = " <span class='label label-danger'>Required!</span>";
			}

			if(empty($Kesatuan)){
				$error['Kesatuan'] = " <span class='label label-danger'>Required!</span>";
			}

			if(empty($Matra)){
				$error['Matra'] = " <span class='label label-danger'>Required!</span>";
			}

			if(empty($Email)){
				$error['Email'] = " <span class='label label-danger'>Required!</span>";
			}	

			if(empty($Alamat_kantor)){
				$error['Alamat_kantor'] = " <span class='label label-danger'>Required!</span>";
			}

			if(empty($No_telepon_kantor_1)){
				$error['No_telepon_kantor_1'] = " <span class='label label-danger'>Required!</span>";
			}

			if(empty($No_telepon_kantor_2)){
				$error['No_telepon_kantor_2'] = " <span class='label label-danger'>Required!</span>";
			}

			if(empty($No_fax)){
				$error['No_fax'] = " <span class='label label-danger'>Required!</span>";
			}

			if(empty($Alamat_Rumah)){
				$error['Alamat_kantor'] = " <span class='label label-danger'>Required!</span>";
			}

			if(empty($No_telepon_rumah)){
				$error['No_telepon_rumah'] = " <span class='label label-danger'>Required!</span>";
			}

			if(empty($No_hp)){
				$error['No_hp'] = " <span class='label label-danger'>Required!</span>";
			}

			// common image file extensions
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			
			// get image file extension
			error_reporting(E_ERROR | E_PARSE);
			$extension = end(explode(".", $_FILES["Foto_image"]["name"]));
			
			if(!empty($Foto_image)){
				if(!(($Foto_type == "image/gif") || 
					($Foto_type == "image/jpeg") || 
					($Foto_type == "image/jpg") || 
					($Foto_type == "image/x-png") ||
					($Foto_type == "image/png") || 
					($Foto_type == "image/pjpeg")) &&
					!(in_array($extension, $allowedExts))){
					
					$error['Foto_image'] = "*<span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
				}
			}
			
					
			if(!empty($Jabatan) && 
				!empty($Nama) && 
				!empty($Pangkat_korps) && 
				!empty($Agama) &&
				!empty($Kesatuan) && 
				!empty($Matra) && 
				!empty($Email) && 
				!empty($Alamat_kantor) && 
				!empty($No_telepon_kantor_1) && 
				!empty($No_telepon_kantor_2) && 
				!empty($No_fax) && 
				!empty($Alamat_Rumah) && 
				!empty($No_telepon_rumah) && 
				!empty($No_hp) && 
				empty($error['Foto_image'])
			){
				
				if(!empty($Foto_image)){
					
					// create random image file name
					$string = '0123456789';
					$file = preg_replace("/\s+/", "_", $_FILES['Foto_image']['name']);
					$function = new functions;
					$Foto_image = $function->get_random_string($string, 4)."-".date("Y-m-d").".".$extension;
				
					// delete previous image
					$delete = unlink("$previous_Foto_image");
					
					// upload new image
					$upload = move_uploaded_file($_FILES['Foto_image']['tmp_name'], 'upload/images/'.$Foto_image);
	  
					// updating all data
					$sql_query = "UPDATE telepon 
							SET Foto=?,
								Jabatan=?,
								Nama=?,
								Pangkat_korps=?,
								Agama=?,
								Kesatuan=?,
								Matra=?,
								Email=?,
								Alamat_kantor=?,
								No_telepon_kantor_1=?,
								No_telepon_kantor_2=?,
								No_fax=?,
								Alamat_Rumah=?,
								No_telepon_rumah=?,
								No_hp=?
								
							WHERE id = ?";
					
					$upload_image = 'upload/images/'.$Foto_image;
					$stmt = $connect->stmt_init();
					if($stmt->prepare($sql_query)) {	
						// Bind your variables to replace the ?s
						$stmt->bind_param('ssssssssssssssss', 
									$upload_image,
									$Jabatan,
									$Nama,
									$Pangkat_korps,
									$Agama,
									$Kesatuan,
									$Matra,
									$Email,
									$Alamat_kantor,
									$No_telepon_kantor_1,
									$No_telepon_kantor_2,
									$No_fax,
									$Alamat_Rumah,
									$No_telepon_rumah,
									$No_hp,
									$ID);
						// Execute query
						$stmt->execute();
						// store result 
						$update_result = $stmt->store_result();
						$stmt->close();
					}
				}else{
					
					// updating all data except image file
					$sql_query = "UPDATE telepon 
							SET Jabatan=?,
								Nama=?,
								Pangkat_korps=?,
								Agama=?,
								Kesatuan=?,
								Matra=?,
								Email=?,
								Alamat_kantor=?,
								No_telepon_kantor_1=?,
								No_telepon_kantor_2=?,
								No_fax=?,
								Alamat_Rumah=?,
								No_telepon_rumah=?,
								No_hp=?
							WHERE id = ?";
							
					$stmt = $connect->stmt_init();
					if($stmt->prepare($sql_query)) {	
						// Bind your variables to replace the ?s
						$stmt->bind_param('sssssssssssssss', 
									$Jabatan,
									$Nama,
									$Pangkat_korps,
									$Agama,
									$Kesatuan,
									$Matra,
									$Email,
									$Alamat_kantor,
									$No_telepon_kantor_1,
									$No_telepon_kantor_2,
									$No_fax,
									$Alamat_Rumah,
									$No_telepon_rumah,
									$No_hp,
									$ID);
						// Execute query
						$stmt->execute();
						// store result 
						$update_result = $stmt->store_result();
						$stmt->close();
					}
				}
					
			

				if($update_result){
					$error['update_telpon'] = " <h4><div class='alert alert-success'>
														* Success Update Data
														<a href='telpon.php'>
														<i style='color:#3c763d' class='icon fa fa-check'></i>
														</a></div>
												  </h4>";
				}else{
					$error['update_telpon'] = " <span class='label label-danger'>Gagal Update Data</span>";
				}
			}
			
		}
		
		// create array variable to store previous data
		$data = array();
			
		$sql_query = "SELECT * FROM telepon WHERE id = ?";
			
		$stmt = $connect->stmt_init();
		if($stmt->prepare($sql_query)) {	
			// Bind your variables to replace the ?s
			$stmt->bind_param('s', $ID);
			// Execute query
			$stmt->execute();
			// store result 
			$stmt->store_result();
			$stmt->bind_result($data['id'],
					$data['Jabatan'],
					$data['Foto_image'],  
					$data['Nama'],
					$data['Pangkat_korps'], 
					$data['Agama'],
					$data['Kesatuan'], 
					$data['Matra'],
					$data['Alamat_kantor'],
					$data['No_telepon_kantor_1'],
					$data['No_telepon_kantor_2'],
					$data['No_fax'],
					$data['Alamat_Rumah'],
					$data['No_telepon_rumah'],
					$data['No_hp'],
					$data['Email']);
			$stmt->fetch();
			$stmt->close();
		}

		if(isset($_POST['btnCancel'])){
			header("location: telpon.php");
		}
		
			
	?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

	<div class="col-md-12">
		<h1>Edit Nomor Telepon</h1>
		<?php echo isset($error['update_telpon']) ? $error['update_telpon'] : '';?>
		<hr />
	</div>
	
	<div class="col-md-12">
		<form method="post"enctype="multipart/form-data">

			<label style="padding-left : 16px">Image :</label><?php echo isset($error['Foto_image']) ? $error['Foto_image'] : '';?>
			<input type="file" name="Foto_image" id="Foto_image" /><br />

			<img src="<?php echo $data['Foto_image']; ?>" width="280" height="270"/> 
			<br/>
			<br/>
			
				<div class="col-md-6">
				
					<label>Jabatan :</label><?php echo isset($error['Jabatan']) ? $error['Jabatan'] : '';?>
					<input type="text" class="form-control" name="Jabatan" value="<?php echo $data['Jabatan']; ?>"/><br />

					<label>Nama :</label><?php echo isset($error['Nama']) ? $error['Nama'] : '';?>
					<input type="text" class="form-control" name="Nama" value="<?php echo $data['Nama']; ?>"/>
					<br/>

					<label>Pangkat / korps :</label><?php echo isset($error['Pangkat_korps']) ? $error['Pangkat_korps'] : '';?>
					<input type="text" class="form-control" name="Pangkat_korps" value="<?php echo $data['Pangkat_korps']; ?>"/>
					<br/>

					<label>Agama :</label><?php echo isset($error['Agama']) ? $error['Agama'] : '';?>
					<input type="text" class="form-control" name="Pangkat_korps" value="<?php echo $data['Agama']; ?>"/>
					<br/>

					<label>Kesatuan :</label><?php echo isset($error['Kesatuan']) ? $error['Kesatuan'] : '';?>
					<input type="text" class="form-control" name="Kesatuan" value="<?php echo $data['Kesatuan']; ?>" />
					<br/>
					
					<label>Matra :</label><?php echo isset($error['Matra']) ? $error['Matra'] : '';?>
					<input type="text" class="form-control" name="Matra" value="<?php echo $data['Matra']; ?>"/>
					<br/>

					<label>Email :</label><?php echo isset($error['Email']) ? $error['Email'] : '';?>
					<input type="text" class="form-control" name="Email" value="<?php echo $data['Email']; ?>"/>
					<br/>
				</div>

					<div class="col-md-6">
						<label>Alamat_kantor :</label><?php echo isset($error['Alamat_kantor']) ? $error['Alamat_kantor'] : '';?>
						<input type="text" class="form-control" name="Alamat_kantor" value="<?php echo $data['Alamat_kantor']; ?>"/>
						<br/>

						<label>Nomor Telepon Kantor 1 :</label><?php echo isset($error['No_telepon_kantor_1']) ? $error['No_telepon_kantor_1'] : '';?>
						<input type="text" class="form-control" name="No_telepon_kantor_1" value="<?php echo $data['No_telepon_kantor_1']; ?>"/>
						<br/>
						
						<label>Nomor Telepon Kantor 2 :</label><?php echo isset($error['No_telepon_kantor_2']) ? $error['No_telepon_kantor_2'] : '';?>
						<input type="text" class="form-control" name="No_telepon_kantor_2" value="<?php echo $data['No_telepon_kantor_2']; ?>"/>
						<br/>
						
						<label>No FAX :</label><?php echo isset($error['No_fax']) ? $error['No_fax'] : '';?>
						<input type="text" class="form-control" name="No_fax" value="<?php echo $data['No_fax']; ?>"/>
						<br/>
						
						<label>Alamat Rumah :</label><?php echo isset($error['Alamat_Rumah']) ? $error['Alamat_Rumah'] : '';?>
						<input type="text" class="form-control" name="Alamat_Rumah" value="<?php echo $data['Alamat_Rumah']; ?>"/>
						<br/>
						
						<label>Nomor Telepon Rumah :</label><?php echo isset($error['No_telepon_rumah']) ? $error['No_telepon_rumah'] : '';?>
						<input type="text" class="form-control" name="No_telepon_rumah" value="<?php echo $data['No_telepon_rumah']; ?>"/>
						<br/>

						<label>No HP :</label><?php echo isset($error['No_hp']) ? $error['No_hp'] : '';?>
						<input type="text" class="form-control" name="No_hp" value="<?php echo $data['No_hp']; ?>"/>
						<br/>
					
					</div>
				<div class="col-md-12">
					<input type="submit" class="btn-primary btn" value="Update" name="btnEdit"/>
					<input type="submit" class="btn-danger btn" value="Cancel" name="btnCancel"/>
				</div>
				</form>
			</div>

	<div class="separator"> </div>
</div>
	
<?php include_once('includes/close_database.php'); ?>