<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	
	$mail = new PHPMailer(true);
	$nombre = $_POST['nombre'];
	$correo = $_POST['correo'];
	$asunto = $_POST['asunto'];
	$mensaje = $_POST['mensaje'];

	try {
    //Server settings----
    	$mail->SMTPDebug = 0;                      					//Enable verbose debug output
    	$mail->isSMTP();                                            //Send using SMTP
    	$mail->Host       = 'smtp.gmail.com';                     	//Set the SMTP server to send through
    	$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    	$mail->Username   = $_ENV['EMAIL_PAGE'];            //SMTP username
    	$mail->Password   = $_ENV['PASSWORD_EMAIL_PAGE'];                         //SMTP password
    	$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    	$mail->Port       = $_ENV['EMAIL_PORT'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

   	//Admin
    	$mail->setFrom($_ENV['EMAIL_PAGE'], 'Contacto');//correo desde el cual se enviaran los mensajes de contacto
    	$mail->addAddress($_ENV['EMAIL_PAGE']);		//correo al cual le llegaran los mensasjes de contacto(pagina)
   
    	//Content
    	$mail->isHTML(true);                                  		//Set email format to HTML
    	$mail->Subject = $asunto;									//Asunto del contacto
    	$mail->Body    = $mensaje . '; Responder a: ' . $nombre . ' al correo: ' . $correo;//Mensaje del contacto
    	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    	$mail->send();

    //User
    	$mail->ClearAddresses();
    	$mail->setFrom($_ENV['EMAIL_PAGE'], 'Apimacizo');//correo desde el cual se enviaran los mensajes de contacto
    	$mail->addAddress($correo);							//correo al cual le llegaran los mensasjes de contacto(usuario)

    	//Content
    	$mail->isHTML(true);                                  		//Set email format to HTML
    	$mail->Subject = 'Respuesta';									//Asunto del contacto
    	$mail->Body    = 'Hemos recibido su mensaje pronto le daremos respuesta';					//Mensaje del contacto
    	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    	$mail->send();

	} catch (Exception $e) {
    	echo 'error: '.$mail->ErrorInfo;
	}
?>
