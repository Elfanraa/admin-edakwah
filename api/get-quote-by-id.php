<?php 

	
	//Mendapatkan Nilai Dari Variable ID Pegawai yang ingin ditampilkan
	$id_quote = $_GET['id_quote'];
	
	//Importing database
	require_once('conn.php');
	
	//Membuat SQL Query dengan pegawai yang ditentukan secara spesifik sesuai ID
	$sql = "SELECT * FROM quote WHERE id_quote";
	
	//Mendapatkan Hasil 
	$r = mysqli_query($con,$sql)or die( mysqli_error($con));
	
	//Memasukkan Hasil Kedalam Array
	$result = array();
	$row = mysqli_fetch_array($r);
	array_push($result,array(
			"judul_quote"=>$row['judul_quote'],
			"quote_image"=>$row['quote_image']


		));
 
	//Menampilkan dalam format JSON
	echo json_encode($result);
	
	mysqli_close($con);
?>