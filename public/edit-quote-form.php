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
			
		$sql_query = "SELECT quote_image 
				FROM quote 
				WHERE id_quote = ?";
				
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
			$judul_quote = $_POST['judul_quote'];
			
			// get image info
			$menu_image = $_FILES['quote_image']['name'];
			$image_error = $_FILES['quote_image']['error'];
			$image_type = $_FILES['quote_image']['type'];
				
			// create array variable to handle error
			$error = array();
				
			if(empty($judul_quote)){
				$error['judul_quote'] = " <span class='label label-danger'>Required!</span>";
			}
			
			// common image file extensions
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			
			// get image file extension
			error_reporting(E_ERROR | E_PARSE);
			$extension = end(explode(".", $_FILES["quote_image"]["name"]));
			
			if(!empty($menu_image)){
				if(!(($image_type == "image/gif") || 
					($image_type == "image/jpeg") || 
					($image_type == "image/jpg") || 
					($image_type == "image/x-png") ||
					($image_type == "image/png") || 
					($image_type == "image/pjpeg")) &&
					!(in_array($extension, $allowedExts))){
					
					$error['quote_image'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
				}
			}
				
			if(!empty($judul_quote) && empty($error['quote_image'])){
					
				if(!empty($menu_image)){
					
					// create random image file name
					$string = '0123456789';
					$file = preg_replace("/\s+/", "_", $_FILES['quote_image']['name']);
					$function = new functions;
					$quote_image = $function->get_random_string($string, 4)."-".date("Y-m-d").".".$extension;
				
					// delete previous image
					$delete = unlink("$previous_category_image");
					
					// upload new image
					$upload = move_uploaded_file($_FILES['quote_image']['tmp_name'], 'upload/images/'.$quote_image);
	  
					$sql_query = "UPDATE quote 
							SET judul_quote = ?, quote_image = ?
							WHERE id_quote = ?";
							
					$upload_image = 'upload/images/'.$quote_image;
					$stmt = $connect->stmt_init();
					if($stmt->prepare($sql_query)) {	
						// Bind your variables to replace the ?s
						$stmt->bind_param('sss', 
									$judul_quote, 
									$upload_image,
									$ID);
						// Execute query
						$stmt->execute();
						// store result 
						$update_result = $stmt->store_result();
						$stmt->close();
					}
				}else{
					
					$sql_query = "UPDATE quote 
							SET judul_quote = ?
							WHERE id_quote = ?";
					
					$stmt = $connect->stmt_init();
					if($stmt->prepare($sql_query)) {	
						// Bind your variables to replace the ?s
						$stmt->bind_param('ss', 
									$judul_quote, 
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
					$error['update_quote'] = " <h4><div class='alert alert-success'>
														Success update quote
														<a href='quote.php'>
														<i style='color:#3c763d' class='icon fa fa-check'></i>
														</a></div>
												  </h4>";
				}else{
					$error['update_quote'] = " <span class='label label-danger'>Failed update quote</span>";
				}
			}
				
		}
			
		// create array variable to store previous data
		$data = array();
		
		$sql_query = "SELECT * 
				FROM quote 
				WHERE id_quote = ?";
		
		$stmt = $connect->stmt_init();
		if($stmt->prepare($sql_query)) {	
			// Bind your variables to replace the ?s
			$stmt->bind_param('s', $ID);
			// Execute query
			$stmt->execute();
			// store result 
			$stmt->store_result();
			$stmt->bind_result($data['id_quote'], 
					$data['judul_quote'],
					$data['quote_image']
					);
			$stmt->fetch();
			$stmt->close();
		}

		if(isset($_POST['btnCancel'])){
			header("location: quote.php");
		}
		
	?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

	<div class="col-md-12">
		<h1>Edit Quote</h1>
		<?php echo isset($error['update_quote']) ? $error['update_quote'] : '';?>
		<hr />
	</div>
	
	<div class="col-md-5">
		<form method="post"
			enctype="multipart/form-data">
			<label>Judul_quote :</label><?php echo isset($error['judul_quote']) ? $error['judul_quote'] : '';?>
			<input type="text" class="form-control" name="judul_quote" value="<?php echo $data['judul_quote']; ?>"/>
			<br/>
			<label>Image :</label><?php echo isset($error['quote_image']) ? $error['quote_image'] : '';?>
			<input type="file" name="quote_image" id="quote_image" /><br />
			<img src="<?php echo $data['quote_image']; ?>" width="280" height="190"/>
			<br/><br/>
			<input type="submit" class="btn-primary btn" value="Update" name="btnEdit"/>
			<input type="submit" class="btn-danger btn" value="Cancel" name="btnCancel"/>
		</form>
	</div>

	<div class="separator"> </div>
</div>
	
<?php include_once('includes/close_database.php'); ?>