<?php
	include_once('includes/connect_database.php'); 
	include_once('functions.php'); 
?>

<?php

	//Total jadwal count
	$sql_user = "SELECT COUNT(*) as num FROM pengguna";
	$total_user = mysqli_query($connect, $sql_user);
	$total_user = mysqli_fetch_array($total_user);
	$total_user = $total_user['num'];

	$sql_telp = "SELECT COUNT(*) as num FROM telepon";
	$total_tlp = mysqli_query($connect, $sql_telp);
	$total_tlp = mysqli_fetch_array($total_tlp);
	$total_tlp = $total_tlp['num'];
/*
	$sql_user = "SELECT COUNT(*) as num FROM tbl_user";
	$total_user = mysqli_query($connect, $sql_user);
	$total_user = mysqli_fetch_array($total_user);
	$total_user = $total_user['num'];*/

	/*//Total info count
	$sql_info = "SELECT COUNT(*) as num FROM info";
	$total_info = mysqli_query($connect, $sql_info);
	$total_info = mysqli_fetch_array($total_info);
	$total_info = $total_info['num'];

	//Total doa count
	$sql_doa = "SELECT COUNT(*) as num FROM doa";
	$total_doa = mysqli_query($connect, $sql_doa);
	$total_doa = mysqli_fetch_array($total_doa);
	$total_doa = $total_doa['num'];

	//Total hadits count
	$sql_hadits = "SELECT COUNT(*) as num FROM hadits";
	$total_hadits = mysqli_query($connect, $sql_hadits);
	$total_hadits = mysqli_fetch_array($total_hadits);
	$total_hadits = $total_hadits['num'];

	//Total kisah nabi count
	$sql_kisah = "SELECT COUNT(*) as num FROM kisah";
	$total_kisah = mysqli_query($connect, $sql_kisah);
	$total_kisah = mysqli_fetch_array($total_kisah);
	$total_kisah = $total_kisah['num'];

	//Total video count
	$sql_video = "SELECT COUNT(*) as num FROM video";
	$total_video = mysqli_query($connect, $sql_video);
	$total_video = mysqli_fetch_array($total_video);
	$total_video = $total_video['num'];

	//Total inspirasi count
	$sql_inspirasi = "SELECT COUNT(*) as num FROM inspirasi";
	$total_inspirasi = mysqli_query($connect, $sql_inspirasi);
	$total_inspirasi = mysqli_fetch_array($total_inspirasi);
	$total_inspirasi = $total_inspirasi['num'];

	//Total quote count
	$sql_quote = "SELECT COUNT(*) as num FROM quote";
	$total_quote = mysqli_query($connect, $sql_quote);
	$total_quote = mysqli_fetch_array($total_quote);
	$total_quote = $total_quote['num'];*/

?> 
<div id="content" class="container col-md-12">

<div class="col-md-12">
		<h1>Dashboard</h1>
		<hr/>
	</div>
	<div class="col-md-16">

		<!-- <a href="telpon.php">
			<div class="col-sm-7 col-md-2">
	            <div class="thumbnail"style="width: 200px;height: 178px">    
	              <div class="caption" >
	              <center>
	              <img src="images/user.png" width="100" height="100"> 
	              <br>
	              <b><p class="detail" style="font-size: 15px;">Users </p></b>
	                <h4>(<?php echo $total_user;?>)</h4>          
	                </center>
	              </div>
	            </div>
	         </div>
	    </a> -->

	    <a href="user.php">
			<div class="col-sm-7 col-md-2">
	            <div class="thumbnail"style="width: 200px;height: 178px">    
	              <div class="caption" >
	              <center>
	              <img src="images/user.png" width="100" height="100"> 
	              <br>
	              <b><p class="detail" style="font-size: 15px;">Daftar User</p></b>
	                <h4>(<?php echo $total_user;?>)</h4>          
	                </center>
	              </div>
	            </div>
	         </div>
	    </a>

	    <a href="telpon.php">
			<div class="col-sm-7 col-md-2">
	            <div class="thumbnail"style="width: 200px;height: 178px">    
	              <div class="caption" >
	              <center>
	              <img src="images/kontak.png" width="100" height="100"> 
	              <br>
	              <b><p class="detail" style="font-size: 15px;">Daftar Nomor Telepon </p></b>
	                <h4>(<?php echo $total_tlp;?>)</h4>          
	                </center>
	              </div>
	            </div>
	         </div>
	    </a>

	   <!--  <a href="doa.php">
			<div class="col-sm-7 col-md-2">
	            <div class="thumbnail">    
	              <div class="caption">
	              <center>
	              <img src="images/doa.png" width="100" height="100">
	              <br>
	              <b><p class="detail" style="font-size: 16px;">Doa </p></b>
	                <h4>(<?php echo $total_doa;?>)</h4>
	                </center>
	              </div>
	            </div>
	         </div>
	    </a>

	    <a href="kisah.php">
			<div class="col-sm-7 col-md-2">
	            <div class="thumbnail">    
	              <div class="caption">
	              <center>
	              <img src="images/kisah.png" width="100" height="100">
	              <br>
	              <b><p class="detail" style="font-size: 16px;">Kisah Nabi </p></b>
	                <h4>(<?php echo $total_kisah;?>)</h4>
	                </center>
	              </div>
	            </div>
	         </div>
	    </a>

	    <a href="video.php">
			<div class="col-sm-7 col-md-2">
	            <div class="thumbnail">    
	              <div class="caption">
	              <center>
	              <img src="images/video.png" width="100" height="100">
	              <br>
	              <b><p class="detail" style="font-size: 16px;">Video </p></b>
	                <h4>(<?php echo $total_video;?>)</h4>
	                </center>
	              </div>
	            </div>
	         </div>
	    </a>

	</div>

	<div class="col-md-12">

		<a href="hadits.php">
			<div class="col-sm-7 col-md-2">
	            <div class="thumbnail">    
	              <div class="caption">
	              <center>
	              <img src="images/hadits.png" width="100" height="100">
	              <br>
	              <b><p class="detail" style="font-size: 16px;">Hadits </p></b>
	                <h4>(<?php echo $total_hadits;?>)</h4>
	                </center>
	              </div>
	            </div>
	         </div>
	    </a>

	    <a href="inspirasi.php">
			<div class="col-sm-7 col-md-2">
	            <div class="thumbnail">    
	              <div class="caption">
	              <center>
	              <img src="images/inspirasi.png" width="100" height="100">
	              <br>
	              <b><p class="detail" style="font-size: 16px;">Cerita Inspirasi </p></b>
	                <h4>(<?php echo $total_inspirasi;?>)</h4>
	                </center>
	              </div>
	            </div>
	         </div>
	    </a>

	    <a href="quote.php">
			<div class="col-sm-7 col-md-2">
	            <div class="thumbnail">    
	              <div class="caption">
	              <center>
	              <img src="images/quote.png" width="100" height="100">
	              <br>
	              <b><p class="detail" style="font-size: 16px;">Quote </p></b>
	                <h4>(<?php echo $total_quote;?>)</h4>
	                </center>
	              </div>
	            </div>
	         </div>
	    </a>

	    <a href="info.php">
			<div class="col-sm-7 col-md-2">
	            <div class="thumbnail">    
	              <div class="caption">
	              <center>
	              <img src="images/info.png" width="100" height="100">
	              <br>
	              <b><p class="detail" style="font-size: 16px;">Info Kegiatan </p></b>
	                <h4>(<?php echo $total_info;?>)</h4>
	                </center>
	              </div>
	            </div>
	         </div>
	    </a>

	</div> -->

	 	

        
</div>

<?php include_once('includes/close_database.php'); ?>