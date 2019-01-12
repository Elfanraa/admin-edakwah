<?php


function email($to,$subject,$message){

		
		$mail=new PHPMailer();
		$mail->CharSet = 'UTF-8';

		$mail->IsSMTP();
		$mail->Host       = 'smtp.gmail.com';
		$mail->SMTPSecure = 'ssl';
		$mail->Port       = 465;
		$mail->SMTPDebug  = 0;
		$mail->SMTPAuth   = true;

		$mail->Username   = 'elidakonfeksi@gmail.com';
		$mail->Password   = 'konfeksi23';
		//$mail->addCustomHeader($from);
		$mail->SetFrom('elidakonfeksi@gmail.com');

		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
		$mail->addAddress($to);

		$mail->send();
		//send the message, check for errors
		// if (!$mail->send()) {
		//     echo "Mailer Error: " . $mail->ErrorInfo;
		// } else {
		//     echo "Message sent!";
		// }

}


?>