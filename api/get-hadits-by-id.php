<?php 

	
	//Mendapatkan Nilai Dari Variable ID Pegawai yang ingin ditampilkan
	$id_hadits = $_GET['id_hadits'];
	
	//Importing database
	require_once('conn.php');
	
	//Membuat SQL Query dengan pegawai yang ditentukan secara spesifik sesuai ID
	$sql = "SELECT * FROM hadits WHERE id_hadits";
	
	//Mendapatkan Hasil 
	$r = mysqli_query($con,$sql)or die( mysqli_error($con));
	
	//Memasukkan Hasil Kedalam Array
	$result = array();
	$row = mysqli_fetch_array($r);
	array_push($result,array(
			"judul_hadits"=>$row['judul_hadits'],
			"isi_hadits"=>$row['isi_hadits']


		));
 
	//Menampilkan dalam format JSON
	echo json_encode($result);
	
	mysqli_close($con);
?>