<?php 

	
	//Mendapatkan Nilai Dari Variable ID Pegawai yang ingin ditampilkan
	$id_inspirasi = $_GET['id_inspirasi'];
	
	//Importing database
	require_once('conn.php');
	
	//Membuat SQL Query dengan pegawai yang ditentukan secara spesifik sesuai ID
	$sql = "SELECT * FROM inspirasi WHERE id_inspirasi";
	
	//Mendapatkan Hasil 
	$r = mysqli_query($con,$sql)or die( mysqli_error($con));
	
	//Memasukkan Hasil Kedalam Array
	$result = array();
	$row = mysqli_fetch_array($r);
	array_push($result,array(
			"judul_inspirasi"=>$row['judul_inspirasi'],
			"isi_inspirasi"=>$row['isi_inspirasi']


		));
 
	//Menampilkan dalam format JSON
	echo json_encode(array('result'=>$result));
	
	mysqli_close($con);
?>