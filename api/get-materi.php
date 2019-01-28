
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
	$sql = "SELECT * FROM jadwal_kajian Order By Tanggal DESC";
	
	//Mendapatkan Hasil
	$r = mysqli_query($con,$sql);
	
	//Membuat Array Kosong 
	$result = array();
	
	while($row = mysqli_fetch_array($r)){
		
		//Memasukkan Nama dan ID kedalam Array Kosong yang telah dibuat 
		array_push($result,array(
			"Nama_ustad"=>$row['Nama_ustad'],
			"Hari"=>$row['Hari'],
			"Tanggal"=>$row['Tanggal'],
			"Tema"=>$row['Tema'],
			"Materi"=>$row['Materi']

			
		));
	}
	
	//Menampilkan Array dalam Format JSON
	echo json_encode($result);
	
	mysqli_close($con);
?>