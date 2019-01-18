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
			
		if(empty($keyword)){
			$sql_query = "SELECT *
					FROM video
					ORDER BY id_video DESC";
		}else{
			$sql_query = "SELECT *
					FROM video
					WHERE judul_video LIKE ? 
					ORDER BY id_video DESC";
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
			$stmt->bind_result($data['id_video'], 
					$data['judul_video'],
					$data['nama_penceramah'],
					$data['video']
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
		
		if(empty($keyword)){
			$sql_query = "SELECT *
					FROM video
					ORDER BY id_video DESC LIMIT ?, ?";
		}else{
			$sql_query = "SELECT * 
					FROM video
					WHERE judul_video LIKE ? 
					ORDER BY id_video DESC LIMIT ?, ?";
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
			$stmt_paging->bind_result($data['id_video'], 
					$data['judul_video'],
					$data['nama_penceramah'],
					$data['video']
					);
			// for paging purpose
			$total_records_paging = $total_records; 
		}

		// if no data on database show "No Reservation is Available"
		if($total_records_paging == 0){
	
	?>
	<h1>Video Not Available
		<a href="add-video.php">
			<button class="btn btn-danger">Add New Video</button>
		</a>
	</h1>
	<hr />
	<?php 
		// otherwise, show data
		}else{
			$row_number = $from + 1;
	?>

	<div class="col-md-12">
		<h1>
			Video
			<a href="add-video.php">
				<button class="btn btn-danger">Add video</button>
			</a>
		</h1>
		<hr/>
	</div>
	<!-- search form -->
	<form class="list_header" method="get">
		<div class="col-md-12">
			<p class="pholder">Search by Name : </p>
		</div>

		<div class="col-md-3">
			<input type="text" class="form-control" name="keyword" />
		</div>

		<br>
		&nbsp;&nbsp;&nbsp;
		<input type="submit" class="btn btn-primary" name="btnSearch" value="Search" />
	</form>
	<!-- end of search form -->
	
	<br/>
	<div class="col-md-12">
	<div class="table-responsive">
	<table class='table table-hover table-condensed table-bordered'>
		<tr class="success">
			<th>No</th>
			<th>Judul</th>
			<th>Nama Penceramah</th>
			<th>Video</th>
			<th>Action</th>
		</tr>

	<?php 
	$no=1;
	while ($stmt_paging->fetch()){ ?>
		<tr>
			<td width="1%"><?php echo $no++;?></td>
			<td width="40%"><?php echo $data['judul_video'];?></td>
			<td width="15%"><?php echo $data['nama_penceramah'];?></td>
			<td width="426" height="240"><video src="<?php echo $data['video']; ?>" width="100%" height="100%"  controls></video></td>
			<td width="1%">
				<a href="edit-video.php?id=<?php echo $data['id_video'];?>">
				Edit
				</a>&nbsp;
				<a href="delete-video.php?id=<?php echo $data['id_video'];?>">
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
		$function->doPages($offset, 'video.php', '', $total_records, $keyword);?>
	</h4>
	</div>
	<div class="separator"> </div>
</div> 

<?php 
	$stmt->close();
	include_once('includes/close_database.php'); ?>
					
				