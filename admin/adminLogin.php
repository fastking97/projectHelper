<?php
session_start();

include("../validation.php");
$userClass = new UserClass();

$errorMessage = "" ;

if (isset($_POST['Login'])) {
 
 $username=$_POST['username'];
 $password=$_POST['password'];
  
 if(strlen(trim($username))>1 && strlen(trim($password))>1 ){
  
  $id=$userClass->adminLogin($username,$password);
        if($id){
   $url='adminDashboard.php';
   header("Location: $url"); // Page redirecting to adminDashboard.php 
  }
  else{
   $errorMessage = "Please enter the valid credential" ;
  }
  
 }
 else{
  $errorMessage = "Please Enter the valid details" ;
  
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
			<h4>Admin Only</h4>
		</div>
	</div>
	
	<div class="header2">
	</div>

	<!-- Section !-->
	<div class="section">
		<h2><b>ADMIN LOGIN</b></h2>
	</div>

	<!-- Main !-->
	<div class="main">
		<div class="login">
			<span class="error"><?php echo $errorMessage;?></span>

			<form method="post">
				<div class="loginForm">
					<div class="formLabel">
						<p><b>Username</b></p>
						<label><b>Password</b></label>
					</div>

					<div class="formInput">
			            <input type="text" name="username" autocomplete="off" required/>
			            <input id="pwd" type="password" name="password" autocomplete="off" required/>
		       	 	</div>

		       	 	<div class="formButton">
		       	 		<input onclick="valueChange(); showPwd();" type="button" value="SHOW" id="showPwdBtn"></input>
		       	 	</div>
        		</div>
        		<button name="Login" class="signIn">SIGN IN</button>
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
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

</script>


</body>
</html>