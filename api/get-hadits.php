
<?php 
 
 /*
 
 penulis: Muhammad yusuf
 website: http://www.kodingindonesia.com/
 
 */
 
	//Import File Koneksi Database
	require_once('conn.php');

	header('Content-Type:application/json;charset=utf8'); 
	mysqli_set_charset($con,"utf8");
	
	//Membuat SQL Query
	$sql = "SELECT * FROM hadits";
	
	//Mendapatkan Hasil
	$r = mysqli_query($con,$sql);
	
	//Membuat Array Kosong 
	$result = array();
	
	while($row = mysqli_fetch_array($r)){
		
		//Memasukkan Nama dan ID kedalam Array Kosong yang telah dibuat 
		array_push($result,array(
			"judul_hadits"=>$row['judul_hadits'],
			"isi_hadits"=>$row['isi_hadits']

		));
	}
	
	//Menampilkan Array dalam Format JSON
	echo json_encode($result);
	
	mysqli_close($con);
?>