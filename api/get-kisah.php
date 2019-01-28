
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
	$sql = "SELECT * FROM kisah";
	
	//Mendapatkan Hasil
	$r = mysqli_query($con,$sql);
	
	//Membuat Array Kosong 
	$result = array();
	
	while($row = mysqli_fetch_array($r)){
		
		//Memasukkan Nama dan ID kedalam Array Kosong yang telah dibuat 
		array_push($result,array(
			"judul_kisah"=>$row['judul_kisah'],
			"isi_kisah"=>$row['isi_kisah']

		));
	}
	
	//Menampilkan Array dalam Format JSON
	echo json_encode($result);
	
	mysqli_close($con);
?>