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
		/*$sql_query = "SELECT Value 
				FROM tbl_setting 
				WHERE Variable = 'Currency'";
		
		$stmt = $connect->stmt_init();
		if($stmt->prepare($sql_query)) {	
			// Execute query
			$stmt->execute();
			// store result 
			$stmt->store_result();
			$stmt->bind_result($currency);
			$stmt->fetch();
			$stmt->close();
		}	*/
		
		// get all data from menu table and category table
		$sql_query = "SELECT * 
				FROM telepon WHERE id=?
				";
		
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
					$data['Foto'],  
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
					$data['Email']

					);
			$stmt->fetch();
			$stmt->close();
		}
		
	?>

<div class="col-md-9 col-md-offset-2">
	<h1>Detail Data Nomor Telepon</h1>
	<form method="post">
		<table table class='table table-bordered table-condensed'>

			<tr class="row">
				<th class="detail">Foto</th>
				<td class="detail"><img src="<?php echo $data['Foto']; ?>" width="260" height="240"/></td>
			</tr>

			<tr class="row">
				<th class="detail">Jabatan</th>
				<td class="detail"><?php echo $data['Jabatan']; ?></td>
			</tr>

			<tr class="row">
				<th class="detail">Nama</th>
				<td class="detail"><?php echo $data['Nama']; ?></td>
			</tr>
			
				<tr class="row">
				<th class="detail">Pangkat / Korps</th>
				<td class="detail"><?php echo $data['Pangkat_korps']; ?></td>
			</tr>
			<tr class="row">
				<th class="detail">Agama</th>
				<td class="detail"><?php echo $data['Agama']; ?></td>
			</tr>
			<tr class="row">
				<th class="detail">Kesatuan</th>
				<td class="detail"><?php echo $data['Kesatuan']; ?></td>
			</tr>

			<tr class="row">
				<th class="detail">Matra</th>
				<td class="detail"><?php echo $data['Matra']; ?></td>
			</tr>

			<tr class="row">
				<th class="detail">Alamat Kantor</th>
				<td class="detail"><?php echo $data['Alamat_kantor']; ?></td>
			</tr>

			<tr class="row">
				<th class="detail">Nomor Telepon Kantor 1</th>
				<td class="detail"><?php echo $data['No_telepon_kantor_1']; ?></td>
			</tr>

			<tr class="row">
				<th class="detail">Nomor Telepon Kantor 2</th>
				<td class="detail"><?php echo $data['No_telepon_kantor_2']; ?></td>
			</tr>

			<tr class="row">
				<th class="detail">Nomor FAX</th>
				<td class="detail"><?php echo $data['No_fax']; ?></td>
			</tr>

			<tr class="row">
				<th class="detail">Alamat Rumah</th>
				<td class="detail"><?php echo $data['Alamat_Rumah']; ?></td>
			</tr>

			<tr class="row">
				<th class="detail">Nomor Telepon Rumah</th>
				<td class="detail"><?php echo $data['No_telepon_rumah']; ?></td>
			</tr>

			<tr class="row">
				<th class="detail">Nomor HP</th>
				<td class="detail"><?php echo $data['No_hp']; ?></td>
			</tr>

			<tr class="row">
				<th class="detail">Email</th>
				<td class="detail"><?php echo $data['Email']; ?></td>
			</tr>
			
		</table>
		
	</form>
	<div id="option_menu">
			<a href="edit-telpon.php?id=<?php echo $ID; ?>"><button class="btn btn-primary">Edit</button></a>
			<a href="delete-telpon.php?id=<?php echo $ID; ?>"><button class="btn btn-danger">Delete</button></a>
	</div>
	
	</div>
				
	<div class="separator"> </div>
</div>
			
<?php include_once('includes/close_database.php'); ?>