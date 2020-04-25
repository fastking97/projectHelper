<?php 
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
session_start();

// check user login
if(empty($_SESSION['id3']))
{
    header("Location: adminLogin.php");
}

include("../validation.php");
$userClass = new UserClass();

$adminName = $_SESSION['username'];
$dir = "../seller/";

if (isset($_POST['Submit'])) {
	require '../PHPMailer/src/Exception.php';
	require '../PHPMailer/src/PHPMailer.php';
	require '../PHPMailer/src/SMTP.php';

	$email = $_POST['email'];

	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->SMTPDebug = true;
	$mail->SMTPAuth   = true; // SMTP authentication
	$mail->Host       = "ssl://smtp.gmail.com"; // SMTP server
	$mail->Port       = 465; // SMTP Port
	$mail->Username   = "fyp2018.msia@gmail.com"; // SMTP account username
	$mail->Password   = "finalyp2018";        // SMTP account password
	//The following code allows you to send mail automatically once the code is run
	$mail->SetFrom('noreply.admin@store.my', 'Admin FYP 2018'); // FROM
	$mail->AddReplyTo($email); // Reply TO

	$mail->AddAddress($email); // recipient email

	if ($_SESSION['reason'] == "warning") {
		$id = $_SESSION['seller'];
		$reason = $_POST['Reason'];

		$mail->Subject    = "Warning Alert"; // email subject
	$mail->Body       = 
'Dear user,
We had received plenty of complaints related to your store with reason(s) as below:

'.$reason.'

Please do consider to make changes and resolve the problems to avoid being ban or delete. 

Best regards,
Admin.

*This email has been generated automatically, please do not reply.';
		
		$message = $mail->Body;
		$subject = $mail->Subject;

		if(!$mail->Send()) {
		echo 'Message was not sent.';
		echo 'Mailer error: ' . $mail->ErrorInfo;
		} else {
			echo ("<SCRIPT LANGUAGE='JavaScript'>
	          window.alert('Message has been sent successfully.')
	          window.location.href='showSellers.php';
	          </SCRIPT>");

			$userClass->sellerInbox($id, $subject, $message);
		}

	}

	else if ($_SESSION['reason'] == "ban") {
		$id = $_SESSION['seller'];
		$reason = $_POST['Reason'];

		$mail->Subject    = "Temporary Ban"; // email subject
	$mail->Body       = 
'Dear user, 
With great regret that we have to temporary ban your account due to reason(s) below:

'.$reason.'

Your account will be banned within unspecified time. Please be patient until your account is being recovered by our team.

Best regards,
Admin.

*This email has been generated automatically, please do not reply.';

		$message = $mail->Body;
		$subject = $mail->Subject;

		if(!$mail->Send()) {
		echo 'Message was not sent.';
		echo 'Mailer error: ' . $mail->ErrorInfo;
		} else {
			$userClass->sellerInbox($id, $subject, $message);

			$update = $userClass->banSeller2($id);

			if($update) {
				echo ("<SCRIPT LANGUAGE='JavaScript'>
		                    window.alert('Message has been sent successfully.')
		                    window.location.href='showSellers.php';
		                    </SCRIPT>");
			}

			else {
				echo ("<SCRIPT LANGUAGE='JavaScript'>
		                    window.alert('Server Error.')
		                    </SCRIPT>");
			}
		}
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Admin</title>

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
			<div class='dropdown1'>
				<i class='fa fa-user'></i><a onclick='Function1()' class='LoginStatus'><?php echo $adminName ?></a>
					<div id='myDropdown1' class='dropdown-content1'>
						<span class='fa fa-lock'></span><a href='./logoutAdmin.php'>Log out</a>
					</div>
			</div>
		</div>
	</div>

	<div class="header2">
    	<a href="./adminDashboard.php"><label>Admin Dashboard</label></a>
  	</div>

  	<!-- Section !-->
	<div style="text-align: left; padding-left: 2vw; margin-bottom: 4vw; background-color: #FAFAFA;" class="sectionn">
		<h4>SEND MESSAGE</h4>
	</div>

	<div style="padding-bottom: 3vw; padding-top: 2vw; text-align: center;" class="mainn">
	<form method="post">
		<?php
			$dbConnection = $userClass->DBConnect();
			$result = $dbConnection->prepare("SELECT * FROM `Sellers` WHERE `id` = :id");
			$result->bindParam(':id', $_SESSION['seller'],PDO::PARAM_INT);
			$result->execute();
			$data=$result->fetch(PDO::FETCH_OBJ);
		?>

		<input type="hidden" name="email" value="<?php echo $data->email ?>"/>
		<h3>Message to: </h3>
		<label><?php echo $data->fname . " " . $data->lname ?></label>
		<br><br>
		<h3>Message Type: </h3>
		<?php 
			if ($_SESSION['reason'] == "ban") {
		?>
		<label>Temporary Ban</label>

		<?php } else if ($_SESSION['reason'] == "warning") { ?>

		<label>Warning Message</label>
		<?php } ?>

		<br><br><br>
		<label style="padding-top: 2vw; font-weight: bold; font-size: 20px;">Reason: </label>
		<br>
		<textarea style="width: 50vw" name="Reason"></textarea>
		<br>
		<button class="submitReview" name="Submit" type="submit">SUBMIT</button>
		<br>
	</form>
	</div>
</div>

<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function Function1() {
    document.getElementById("myDropdown1").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.LoginStatus')) {

    var dropdowns = document.getElementsByClassName("dropdown-content1");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

</script>

</body>
</html>