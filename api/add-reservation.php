<?php
	include_once('../includes/connect_database.php'); 
	include_once('../includes/variables.php');
	include_once('../library/class.phpmailer.php');
	include_once('../library/PHPMailerAutoload.php');
	include_once('../includes/sending_email.php');

	
	// get data from android app
	$name = $_POST['name'];
	$alamat = $_POST['alamat'];
	$kota = $_POST['kota'];
	$provinsi = $_POST['provinsi'];
	$name2 = $_POST['name2'];
	$date_n_time = $_POST['date_n_time'];
	$phone = $_POST['phone'];
	$order_list = $_POST['order_list'];
	$comment = $_POST['comment'];
	$email = $_POST['email'];

	$email_customer = $email;
	
	$sql_query = "set names 'utf8'";
	$stmt = $connect->stmt_init();
	if($stmt->prepare($sql_query)) {	
		// Execute query
		$stmt->execute();
		// store result 
		$stmt->close();
	}

	
	// insert data into reservation table
	$sql_query = "INSERT INTO tbl_reservation(Name, Alamat, Kota, Provinsi, Number_of_people, Date_n_Time, Phone_number, Order_list, Comment, Email) 
					VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	
	$stmt = $connect->stmt_init();
	if($stmt->prepare($sql_query)) {	
		// Bind your variables to replace the ?s
		$stmt->bind_param('ssssssssss', 
					$name,
					$alamat,	
					$kota,	
					$provinsi,	
					$name2, 
					$date_n_time, 
					$phone, 
					$order_list,
					$comment,
					$email
					);
		// Execute query
		$stmt->execute();
		$result = $stmt->affected_rows;
		// store result 
		//$result = $stmt->store_result();
		$stmt->close();
	}

	// Dapatkan last ID sebagai ID Pesanan

	$sql_query_id = "SELECT ID, Order_list
			FROM tbl_reservation ORDER BY ID DESC LIMIT 1";

	$stmt = $connect->stmt_init();
	if($stmt->prepare($sql_query_id)) {	
		// Execute query
		$stmt->execute();
		// store result 
		$stmt->store_result();
		$stmt->bind_result($ID,$Order_list);
		$stmt->fetch();
		$stmt->close();
	}



	// akhir dari ID pesanan


	
	// get admin email from user table
	$sql_query = "SELECT Email 
			FROM tbl_user";
	
	$stmt = $connect->stmt_init();
	if($stmt->prepare($sql_query)) {	
		// Execute query
		$stmt->execute();
		// store result 
		$stmt->store_result();
		$stmt->bind_result($email);
		$stmt->fetch();
		$stmt->close();
	}
	
	// if new reservation has been successfully added to reservation table 
	
	if($result){

		// send notification to admin via email 

		$to = null;
		$subject = null;
		$message = null;

		$to = $email;
		$subject = $reservation_subject;
		$message = $reservation_message;
		email($to,$subject,$message);



		

		//send email to android

		$to = null;
		$subject = null;
		$message = null;

		$order_list = strrchr($Order_list,'Total');

		$to = $email_customer;
		$subject = 'Checkout Berhasil';
		$message = '<html><body>
					<h1><strong>No. Pesanan Anda: TOHE'.$ID.'</strong></h1>
						<h3>Silahkan Lakukan Pembayaran Sesuai Order Anda</h3>
						<p>
						'.$order_list.'
						</p>
						<h3>ke salah satu No. Rekening dibawah ini:</h3>
						<ol>
						<li>&nbsp;BANK BCA : No. Rek. 0070104172 a.n Husna Zattil Hikmah</li>
						<li>&nbsp;BANK BRI : No. Rek. 7081-01-008259-53-3 a.n Sonia Elida</li>
						<li>&nbsp;Setelah melakukan Pembayaran, Silahkan Lakukan Konfirmasi melalui no Whatsapp 08161495268 atau email zattilhikmah@gmail.com disertai bukti tranfer dan no pesanan Anda</li>
						</ol>
						<p>&nbsp;</p>
						<p>&nbsp;</p>
					</body><html>';

		email($to,$subject,$message);


		echo "OK";
	}else{
		echo "Failed";
	}

	include_once('../includes/close_database.php');
?>