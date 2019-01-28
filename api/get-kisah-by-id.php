<?php 

	
	//Mendapatkan Nilai Dari Variable ID Pegawai yang ingin ditampilkan
	$id_kisah = $_GET['id_kisah'];
	
	//Importing database
	require_once('conn.php');
	
	//Membuat SQL Query dengan pegawai yang ditentukan secara spesifik sesuai ID
	$sql = "SELECT * FROM kisah WHERE id_kisah";
	
	//Mendapatkan Hasil 
	$r = mysqli_query($con,$sql)or die( mysqli_error($con));
	
	//Memasukkan Hasil Kedalam Array
	$result = array();
	$row = mysqli_fetch_array($r);
	array_push($result,array(
			"judul_kisah"=>$row['judul_kisah'],
			"isi_kisah"=>$row['isi_kisah']

		));
 
	//Menampilkan dalam format JSON
	echo json_encode($result);
	
	mysqli_close($con);
?>