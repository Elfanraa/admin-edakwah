<?php 

	
	//Mendapatkan Nilai Dari Variable ID Pegawai yang ingin ditampilkan
	$Id_kajian = $_GET['Id_kajian'];
	
	//Importing database
	require_once('conn.php');
	
	//Membuat SQL Query dengan pegawai yang ditentukan secara spesifik sesuai ID
	$sql = "SELECT * FROM jadwal_kajian WHERE Id_kajian";
	
	//Mendapatkan Hasil 
	$r = mysqli_query($con,$sql)or die( mysqli_error($con));
	
	//Memasukkan Hasil Kedalam Array
	$result = array();
	$row = mysqli_fetch_array($r);
	array_push($result,array(
			"Nama_ustad"=>$row['Nama_ustad'],
			"Hari"=>$row['Hari'],
			"Tanggal"=>$row['Tanggal'],
			"Tema"=>$row['Tema'],
			"Materi"=>$row['Materi']


		));
 
	//Menampilkan dalam format JSON
	echo json_encode(array('result'=>$result));
	
	mysqli_close($con);
?>