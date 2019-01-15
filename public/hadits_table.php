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
				FROM hadits  
				ORDER BY judul_hadits DESC";
		}else{
			$sql_query = "SELECT *
				FROM hadits 
				WHERE judul_hadits LIKE ? 
				ORDER BY judul_hadits DESC";
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
			$stmt->bind_result($data['id_hadits'], 
					$data['judul_hadits'],
					$data['isi_hadits']
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
		$offset = 7;
							
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
				FROM hadits 
				ORDER BY judul_hadits DESC 
				LIMIT ?, ?";
		}else{
			$sql_query = "SELECT *
				FROM hadits 
				WHERE judul_hadits LIKE ? 
				ORDER BY judul_hadits ASC 
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
			
			$stmt_paging ->bind_result($data['id_hadits'], 
					$data['judul_hadits'],
					$data['isi_hadits']
					);
			
			// for paging purpose
			$total_records_paging = $total_records; 
		}
						
		// if no data on database show "Tidak Ada Pemesanan"
		if($total_records_paging == 0){
	?>
	<h1>There is No Order</h1>
	<hr />
	
	<?php
		// otherwise, show data
		}else{ $row_number = $from + 1;?>
	
	<div>

	<div class="col-md-12">
		<h1>Hadits
		<!-- <a href="add-category.php"> -->
			<a href="add-hadits.php">
				<button class="btn btn-danger">Add Hadits</button>
			</a></h1>
		<hr/>
	</div>

	<!-- search form -->
	<!-- <form class="list_header" method="get">
		<div class="col-md-12">
			<p class="pholder">Search by Name : </p>
		</div>
		
		<div class="col-md-3">
			<input type="text" class="form-control" name="keyword"/>
		</div>
		<br>
			&nbsp;&nbsp;&nbsp;
			<input type="submit" class="btn btn-primary" name="btnSearch" value="Search"/>
	</form> -->
	<!-- end of search form -->
	
	<br>
	<div class="col-md-12">
	<div class="table-responsive">
	<table class='table table-hover table-condensed table-bordered'>
		<tr class="success">
			<th>Judul Hadits</th>
			<th>Isi Hadits</th>
			<!-- <th>Tanggal</th>
			<th>Jam Kajian</th>
			<th>Tema Kajian</th>
			<th>Materi</th> -->
			<!-- <th>Phone</th>
			<th>Status</th> -->
			<th>Action</th>
		</tr>
		<?php
			// get all data using while loop
			while ($stmt_paging->fetch()){ ?>
			<tr>
				<td><?php echo $data['judul_hadits'];?></td>
				<td><?php echo $data['isi_hadits'];?></td> 
				<!-- <td><?php echo $data['Email'];?></td>
				<td><?php echo $data['Number_of_people'];?></td>
				<td><?php echo $data['Date_n_Time'];?></td>
				<td><?php echo $data['Phone_number'];?></td>
				<td><?php echo $data['Status'] == 1 ? "<span class='label label-primary'>PROCESSED</span>" : "<span class='label label-danger'>NOT PROCESSED</span>";?></td> -->
				<td>
					<a href="edit-hadits.php?id=<?php echo $data['id_hadits'];?>">
						Edit
					</a>&nbsp;

					<a href="delete-hadits.php?id=<?php echo $data['id_hadits'];?>">
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
			$function->doPages($offset, 'hadits.php', '', $total_records, $keyword);
		?>
	</h4>
	
	</div>
	<div class="separator"> </div>
</div> 
</div>

<?php 
	$stmt->close();
	include_once('includes/close_database.php'); ?>
					
				