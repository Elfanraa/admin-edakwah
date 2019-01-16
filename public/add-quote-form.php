<?php
	include_once('includes/connect_database.php'); 
	include_once('functions.php'); 
?>
<div id="content" class="container col-md-12">
	<?php 
		if(isset($_POST['btnAdd'])){
			$judul_quote = $_POST['judul_quote'];
			
			// get image info
			$quote_image = $_FILES['quote_image']['name'];
			$quote_error = $_FILES['quote_image']['error'];
			$quote_type = $_FILES['quote_image']['type'];
			
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
					
			if($image_error > 0){
				$error['quote_image'] = " <span class='label label-danger'>Not Uploaded!!</span>";
			}else if(!(($quote_type == "image/gif") || 
				($quote_type == "image/jpeg") || 
				($quote_type == "image/jpg") || 
				($quote_type == "image/x-png") ||
				($quote_type == "image/png") || 
				($quote_type == "image/pjpeg")) &&
				!(in_array($extension, $allowedExts))){
			
				$error['quote_image'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!</span>";
			}
			
			if(!empty($judul_quote) && empty($error['quote_image'])){
				
				// create random image file name
				$string = '0123456789';
				$file = preg_replace("/\s+/", "_", $_FILES['quote_image']['name']);
				$function = new functions;
				$menu_image = $function->get_random_string($string, 4)."-".date("Y-m-d").".".$extension;
					
				// upload new image
				$upload = move_uploaded_file($_FILES['quote_image']['tmp_name'], 'upload/images/'.$quote_image);
		
				// insert new data to menu table
				$sql_query = "INSERT INTO quote (judul_quote, quote_image)
						VALUES(?, ?)";
				
				$upload_image = 'upload/images/'.$quote_image;
				$stmt = $connect->stmt_init();
				if($stmt->prepare($sql_query)) {	
					// Bind your variables to replace the ?s
					$stmt->bind_param('ss', 
								$judul_quote, 
								$upload_image
								);
					// Execute query
					$stmt->execute();
					// store result 
					$result = $stmt->store_result();
					$stmt->close();
				}
				
				if($result){
					$error['add_quote'] = " <h4><div class='alert alert-success'>
														* Success add new quote
														<a href='quote.php'>
														<i style='color:#3c763d' class='icon fa fa-check'></i>
														</a></div>
												  </h4>";
				}else{
					$error['add_quote'] = " <span class='label label-danger'>Failed add quote</span>";
				}
			}
			
		}

		if(isset($_POST['btnCancel'])){
			header("location: quote.php");
		}

	?>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<div class="col-md-12">
		<h1>Add Kutipan</h1>
		<?php echo isset($error['add_quote']) ? $error['add_quote'] : '';?>
		<hr />
	</div>
	
	<div class="col-md-5">
		<form method="post"
			enctype="multipart/form-data">
			<label>Judul Quote :</label><?php echo isset($error['judul_quote']) ? $error['judul_quote'] : '';?>
			<input type="text" class="form-control" name="judul_quote"/>
			<br/>
			<label>Image :</label><?php echo isset($error['quote_image']) ? $error['quote_image'] : '';?>
			<input type="file" name="quote_image" id="quote_image" />
			<br/>
			<input type="submit" class="btn-primary btn" value="Submit" name="btnAdd"/>
			<input type="reset" class="btn-warning btn" value="Clear"/>
			<input type="submit" class="btn-danger btn" value="Cancel" name="btnCancel"/>
		</form>
	</div>

	<div class="separator"> </div>
</div>
	
<?php include_once('includes/close_database.php'); ?>