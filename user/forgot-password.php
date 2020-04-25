<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
session_start();

include("../validation.php");
$userClass = new UserClass();

// Create tokens
$token = bin2hex(random_bytes(32));

$url = 'localhost/project/user/password-recovery.php?token='. $token;

// Token expiration
date_default_timezone_set('Asia/Jakarta');
$expires = strtotime(date("H:i:s", strtotime("+1 hour")));

if (isset($_POST['Submit'])) {
	$email = $_POST['email'];

	// Delete any existing tokens for this user
	$userClass->deleteToken1($email);

	// Insert reset token into database
	$userClass->insertToken1($email, $token, $expires);

	require '../PHPMailer/src/Exception.php';
	require '../PHPMailer/src/PHPMailer.php';
	require '../PHPMailer/src/SMTP.php';

	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->SMTPDebug = true;
	$mail->SMTPAuth   = true; // SMTP authentication
	$mail->Host       = "ssl://smtp.gmail.com"; // SMTP server
	$mail->Port       = 465; // SMTP Port
	$mail->Username   = "fyp2018.msia@gmail.com"; // SMTP account username
	$mail->Password   = "finalyp2018";        // SMTP account password
	//The following code allows you to send mail automatically once the code is run
	$mail->SetFrom('fyp2018.msia@gmail.com', 'FYP 2018'); // FROM
	$mail->AddReplyTo($email); // Reply TO

	$mail->AddAddress($email); // recipient email
	$mail->Subject    = "Password Update Request"; // email subject
	$mail->Body       = 
'Dear user, 
Recently a request was submitted to reset a password for your account. If this was a mistake, just ignore this email and nothing will happen.
To reset your password, visit the following link: 

http://'.$url.'

Best regards,
FYP 2018.

*This email has been generated automatically, please do not reply.';

	if(!$mail->Send()) {
	echo 'Message was not sent.';
	echo 'Mailer error: ' . $mail->ErrorInfo;
	} else {
		echo ("<SCRIPT LANGUAGE='JavaScript'>
          window.alert('Recovery link has been sent to your email.')
          window.location.href='login.php';
          </SCRIPT>");
	}
}



?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Reset Password</title>

	<!-- Favicon !-->
	<link rel="icon" href="../icons/shopping-icon.png">

	<!-- Font Awesome !-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="../css/main.css">
	<link rel="stylesheet" type="text/css" href="../css/grid.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">

</head>
<body>

<div class="content8">

	<!-- Header !-->
	<div class="header">
	  <div class="userAccount">
	    <h4>Password Recovery</h4>
	   </div>
	</div>

	<div class="header2">
	    <a href="../user/homepage.php"><label>Application Homepage</label></a>
	</div>

	<!-- Section !-->
	<div class="section">
		<h2><b>RESET PASSWORD</b></h2>
	</div>

	<!-- Main !-->
	<div class="main">
		<div class="login">
			<p>Please enter your email address. You will revceive a link to create a new password via email.</p>
			<form method="post">
				<div class="resetPwdForm">
					<div class="formLabel">
						<p><b>Email</b></p>
					</div>

					<div class="formInput">
						<input type="email" name="email" autocomplete="off" required/>
					</div>
				</div>

	            <button name="Submit" type="submit" class="signIn">SUBMIT</button>

	            <br>

	            <a href="./login.php">Remember password? Login here</a>
	            <br><br>
        	</form>
		</div>
	</div>
</div>


</body>
</html>