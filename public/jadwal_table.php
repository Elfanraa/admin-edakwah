<?php
	include_once('includes/connect_database.php'); 
	include_once('functions.php'); 
	
?>

<div id="content" class="container col-md-12">
	<?php 
		// create object of functions class
		$function = new functions;
		
		// create array variable to store data from database
		$data = array();
		
		if(isset($_GET['keyword'])){	
			// check value of keyword variable
			$keyword = $function->sanitize($_GET['keyword']);
			$bind_keyword = "%".$keyword."%";
		}else{
			$keyword = "";
			$bind_keyword = $keyword;
		}
		
		// get all data from pemesanan table
		if(empty($keyword)){
			$sql_query = "SELECT * 
				FROM jadwal_kajian  
				ORDER BY Tanggal DESC";
		}else{
			$sql_query = "SELECT *
				FROM jadwal_kajian 
				WHERE Nama_ustad LIKE ? 
				ORDER BY Tanggal DESC";
		}
			
		$stmt = $connect->stmt_init();
		if($stmt->prepare($sql_query)) {	
			// Bind your variables to replace the ?s
			if(!empty($keyword)){
				$stmt->bind_param('s', $bind_keyword);
			}
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
					
			// get total records
			$total_records = $stmt->num_rows;
		}
		
		// check page parameter
		if(isset($_GET['page'])){
			$page = $_GET['page'];
		}else{
			$page = 1;
		}
		
		// number of data that will be display per page
		$offset = 1;
							
		//lets calculate the LIMIT for SQL, and save it $from
		if ($page){
			$from 	= ($page * $offset) - $offset;
		}else{
			//if nothing was given in page request, lets load the first page
			$from = 0;	
		}
		
		// get all data from pemesanan table
		if(empty($keyword)){
			$sql_query = "SELECT *
				FROM jadwal_kajian
				ORDER BY tanggal DESC 
				LIMIT ?, ?";
		}else{
			$sql_query = "SELECT *
				FROM jadwal_kajian
				WHERE Nama_ustad LIKE ? 
				ORDER BY tanggal ASC 
				LIMIT ?, ?";
		}
		
		$stmt_paging = $connect->stmt_init();
		if($stmt_paging ->prepare($sql_query)) {
			// Bind your variables to replace the ?s
			if(empty($keyword)){
				$stmt_paging ->bind_param('ss', $from, $offset);
			}else{
				$stmt_paging ->bind_param('sss', $bind_keyword, $from, $offset);
			}
			// Execute query
			$stmt_paging ->execute();
			// store result 
			$stmt_paging ->store_result();
			
			$stmt_paging ->bind_result($data['id_kajian'], 
					$data['Nama_ustad'],
					$data['Hari'],					
					$data['Tanggal'], 
					$data['Jam'], 
					$data['Tema'],
					$data['Materi']
					);
			
			// for paging purpose
			$total_records_paging = $total_records; 
		}
						
		// if no data on database show "Tidak Ada Pemesanan"
		if($total_records_paging == 0){
	?>
	<h1>Jadwal Kajian Tidak Ditemukan
		<a href="add-jadwal.php">
			<button class="btn btn-danger">Add New Jadwal</button>
		</a>
	</h1>

	<hr />
	
	<?php
		// otherwise, show data
		}else{ $row_number = $from + 1;?>
	
	<div>


	<div class="col-md-12 ">
		<h1>Jadwal Kajian
		<!-- <a href="add-category.php"> -->
			<a href="add-jadwal.php">
				<button class="btn btn-danger">Add Jadwal Kajian</button>
			</a></h1>
		<hr/>
	</div>

	<!-- search form -->
	<form class="list_header" method="get">
		<div class="col-md-12">
			<p class="pholder">Search by Name : </p>
		</div>
		
		<div class="col-md-3">
			<input type="text" class="form-control" name="keyword"/>
		</div>
		<br>
			&nbsp;&nbsp;&nbsp;
			<input type="submit" class="btn btn-primary" name="btnSearch" value="Search"/>
	</form> 
	<!-- end of search form -->
	
	<br>
	<div class="col-md-12">
	<div class="table-responsive">
	<table class='table table-hover table-condensed table-bordered'>
		<tr class="success">
			<th>No</th>
			<th>Nama Penceramah</th>
			<th>Hari</th>
			<th>Tanggal</th>
			<th>Jam Kajian</th>
			<th>Tema Kajian</th>
			<th>Materi</th>
			<!-- <th>Phone</th>
			<th>Status</th> -->
			<th>Action</th>
		</tr>
		<?php
			$no=1; 
			// get all data using while loop
			while ($stmt_paging->fetch()){ 
				?>
			<tr>
				<td><?php echo $no++; ?></td>
				<td width="18%"><?php echo $data['Nama_ustad'];?></td>
				<!-- <td><?php echo $data['Alamat'];?></td> -->
				<td width="7%"><?php echo $data['Hari'];?></td>
				<td width="8%"><?php echo $data['Tanggal'];?></td>
				<td width="9%"><?php echo $data['Jam'];?></td>
				<td width="15%"><?php echo $data['Tema'];?></td>
				<td><?php echo substr($data['Materi'],0,800) ;?>
				<?php echo "....."  ?>
				<a href="jadwal-detail.php?id=<?php echo $data['id_kajian'];?>">
						[ Read More ]
					</a>&nbsp; 
				</td>
				<td>
					<a href="edit-jadwal.php?id=<?php echo $data['id_kajian'];?>">
						Edit
					</a>&nbsp;

					 

					<a href="delete-jadwal.php?id=<?php echo $data['id_kajian'];?>">
						Delete
					</a>
				</td>
			</tr>
		<?php } }?>
	</table>
	</div>
	</div>
	
	<div class="col-md-12">
	
	<h4>
		<?php 
			// for pagination purpose
			$function->doPages($offset, 'jadwal.php', '', $total_records, $keyword);
		?>
	</h4>
	
	</div>
	<div class="separator"> </div>
</div> 
</div>

<?php 
	$stmt->close();
	include_once('includes/close_database.php'); ?>
					
				