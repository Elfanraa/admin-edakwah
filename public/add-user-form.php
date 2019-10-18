<?php
	include_once('includes/connect_database.php'); 
	include_once('functions.php'); 
?>
 <div id="content" class="container col-md-12">
	<?php 

		if(isset($_POST['btnAdd'])){
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			// create array variable to handle error
			$error = array();
			
			if(empty($username)){
				$error['username'] = " <span class='label label-danger'>Required!</span>";
			}

			if(empty($password)){
				$error['password'] = " <span class='label label-danger'>Required!</span>";
			}
			
			
				$sql_query = "INSERT INTO pengguna (username,password)
						VALUES(?, ?)";
				
				/*$upload_image = 'upload/images/'.$menu_image;*/
				$stmt = $connect->stmt_init();
				if($stmt->prepare($sql_query)) {
					// Bind your variables to replace the ?s
					$stmt->bind_param('ss', 
								$username, 
								$password
								);
					// Execute query
					$stmt->execute();
					// store result 
					$result = $stmt->store_result();
					$stmt->close();
				}
				
				if($result){
					$error['add_user'] = " <h4><div class='alert alert-success'>
														* Success Tambah User
														<a href='user.php'>
														<i style='color:#3c763d' class='icon fa fa-check'></i>
														</a></div>
												  </h4>";
				}else{
					$error['add_user'] = " <span class='label label-danger'>Gagal Tambah User</span>";
				}
			}
			

		if(isset($_POST['btnCancel'])){
			header("location: user.php");
		}

		if(isset($_POST['btnClear'])){
			header("location: add_user.php");
		}		

	?>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<div class="col-md-12">
		<h1>Tambah User</h1>
		<?php echo isset($error['add_user']) ? $error['add_user'] : '';?>
		<hr />
	</div>
	

	<div class="col-md-12">
		<form method="post"enctype="multipart/form-data">
				<div class="col-md-6">
				
					<label>Username</label><?php echo isset($error['username']) ? $error['username'] : '';?>
					<input type="text" class="form-control" name="username"/>
					<br/>

					<label>Password</label><?php echo isset($error['password']) ? $error['password'] : '';?>
					<input type="text" class="form-control" name="password"/>
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