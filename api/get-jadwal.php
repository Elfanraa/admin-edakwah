
<?php 
 
 /*
 
 penulis: Muhammad yusuf
 website: http://www.kodingindonesia.com/
 
 */
 
	//Import File Koneksi Database
	require_once('conn.php');
	
	//Membuat SQL Query
	$sql = "SELECT * FROM jadwal_kajian";
	
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
			"Jam"=>$row['Jam'],
			"Tema"=>$row['Tema']

		));
	}
	
	//Menampilkan Array dalam Format JSON
	echo json_encode($result);
	
	mysqli_close($con);
?>