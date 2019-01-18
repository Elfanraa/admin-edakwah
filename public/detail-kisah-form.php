<?php
	include_once('includes/connect_database.php'); 
?>

<div id="content" class="container col-md-12">
	<?php 
		if(isset($_GET['id'])){
			$ID = $_GET['id'];
		}else{
			$ID = "";
		}
		
		// create array variable to store data from database
		$data = array();
		
		// get currency symbol from setting table
		$sql_query = "SELECT * 
				FROM kisah
				WHERE id_kisah";
		
		$stmt = $connect->stmt_init();
		if($stmt->prepare($sql_query)) {	
			// Execute query
			$stmt->execute();
			// store result 
			$stmt->store_result();
			//$stmt->bind_result($currency);
			$stmt->fetch();
			$stmt->close();
		}	
		
		// get all data from menu table and category table
		$sql_query = "SELECT * 
				FROM kisah
				WHERE id_kisah=?";
				
		
		$stmt = $connect->stmt_init();
		if($stmt->prepare($sql_query)) {	
			// Bind your variables to replace the ?s
			$stmt->bind_param('s', $ID);
			// Execute query
			$stmt->execute();
			// store result 
			$stmt->store_result();
			$stmt->bind_result($data['id_kisah'], 
					$data['judul_kisah'],
					$data['isi_kisah']
					);
			$stmt->fetch();
			$stmt->close();
		}
		
	?>

<div class="col-md-9 col-md-offset-2">
	<h1>Kisah Nabi Detail</h1>
	<form method="post">
		<table table class='table table-bordered table-condensed' border="2px" >
			<!-- <tr class="row">
				<th class="detail">ID</th>
				<td class="detail"><?php echo $data['Id_kajian']; ?></td>
			</tr> -->
			<tr class="row">
				<th class="detail">Judul Kisah</th>
				<td class="detail"><?php echo $data['judul_kisah']; ?></td>
			</tr>
				<tr class="row">
				<th class="detail">Kisah</th>
				<td class="detail"><?php echo $data['isi_kisah']; ?></td>
			</tr>
			<!-- <tr class="row">
				<th class="detail">Hari</th>
				<td class="detail"><?php echo $data['Hari'] ?></td>
			</tr>
			<tr class="row">
				<th class="detail">Jam</th>
				<td class="detail"><?php echo $data['Jam']; ?></td>
			</tr>

			<tr class="row">
				<th class="detail">Materi</th>
				<td class="detail"><?php echo $data['Materi']; ?></td>
			</tr> -->
			<!-- <tr class="row">
				<th class="detail">Image</th>
				<td class="detail"><img src="<?php echo $data['Menu_image']; ?>" width="200" height="150"/></td>
			</tr>
			<tr class="row">
				<th class="detail">Description</th>
				<td class="detail"><?php echo $data['Description']; ?></td>
			</tr> -->
		</table>
		
	</form>
	<div id="option_menu">
			<a href="edit-kisah.php?id=<?php echo $data['id_kisah'];?>"><button class="btn btn-primary">Edit</button></a>
			<a href="delete-kisah.php?id=<?php echo $data['id_kisah'];?>"><button class="btn btn-danger">Delete</button></a>
	</div>
	
	</div>
				
	<div class="separator"> </div>
</div>
			
<?php include_once('includes/close_database.php'); ?>