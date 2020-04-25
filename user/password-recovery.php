<?php
include("../validation.php");
$userClass = new UserClass();

$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$token = substr(strstr($link, '='), strlen('='));
$email = $errorMessage = "";

// Check token and check expiry
$check = $userClass->checkToken1($email, $token);

if ($check == -1) {
	echo ("<SCRIPT LANGUAGE='JavaScript'>
                window.alert('Your recovery link has expired.')
                window.location.href='login.php';
                </SCRIPT>");
}	

else if ($check == -2) {
	echo ("<SCRIPT LANGUAGE='JavaScript'>
                window.alert('The link is no longer available.')
                window.location.href='login.php';
                </SCRIPT>");
}

else if ($check == 0) {
	if (isset($_POST['Reset'])) {
		$password = $_POST['password'];
		$confirm_password = $_POST['confirm_password'];

		if ($_POST['password'] != $_POST['confirm_password'])
		{
			$errorMessage = "Password is not match!";
		}

		else {
			$id = $userClass->updatePassword1($email, $password);

			if($id){
				// Delete any existing tokens for this user
				$userClass->deleteToken1($email);
			    echo ("<SCRIPT LANGUAGE='JavaScript'>
			   				window.alert('Your password is successfully updated.')
			                window.location.href='login.php';
			                </SCRIPT>");
			  
			 }
			 else{
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
		<span class="error"> <?php echo $errorMessage;?> </span>
		<h2><b>PASSWORD RECOVERY</b></h2>
	</div>

	<!-- Main !-->
	<div class="main">
		<div class="login">
			<p>Please enter your new password</p>
			<form method="post">
				<div class="loginForm">
					<div class="formLabel">
						<p><b>New Password</b></p>
						<label><b>Confirm Password</b></label>
					</div>

					<div class="formInput">
			            <input id="pwd" type="password" name="password" autocomplete="off" required/>
            			<input id="pwd2" type="password" name="confirm_password" autocomplete="off" required/>
		       	 	</div>

		       	 	<div class="formButton">
		       	 		<input onclick="valueChange(); showPwd();" type="button" value="SHOW" id="showPwdBtn"></input>
		       	 	</div>
        		</div>

        		<button name="Reset" class="signIn">RESET</button>
        		<br>

	            <a href="./sell-with-us.php">Remember password? Login here</a>
	            <br><br>
        	</form>
		</div>
	</div>
</div>

<script>
function valueChange()
{
    var elem = document.getElementById("showPwdBtn");
    if (elem.value=="SHOW") {
    	elem.value = "HIDE";
    	document.getElementById("showPwdBtn").style.background = "#32CD32";
    }
    else {
    	elem.value = "SHOW";
    	document.getElementById("showPwdBtn").style.background = "#333";
    } 
}

function showPwd() {
    var x = document.getElementById("pwd");
    var y = document.getElementById("pwd2");
    if (x.type === "password" && y.type === "password") {
        x.type = "text";
        y.type = "text";
    } else {
        x.type = "password";
        y.type = "password";
    }
}

</script>


</body>
</html>