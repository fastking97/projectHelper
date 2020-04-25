<?php

include("../validation.php");
$userClass = new UserClass();

$errorMessage = "";

if (isset($_POST['Login'])) {
 
 $email=$_POST['email'];
 $password=$_POST['password'];
  
 if(strlen(trim($email))>1 && strlen(trim($password))>1 ){
  
  $id=$userClass->sellerLogin($email,$password);
        if($id == 0){
   $url='sellerDashboard.php';
   header("Location: $url"); // Page redirecting to sellerDashboard.php 
  }
  else if ($id == -1){
   echo ("<SCRIPT LANGUAGE='JavaScript'>
	    window.alert('Your account is still on hold. Please try again later.')
	    window.location.href='sell-with-us.php';
	    </SCRIPT>");
  }

  else if ($id == -2){
   echo ("<SCRIPT LANGUAGE='JavaScript'>
	    window.alert('Your account is temporary banned. Check your email for more information.')
	    window.location.href='sell-with-us.php';
	    </SCRIPT>");
  }

  else {
   echo ("<SCRIPT LANGUAGE='JavaScript'>
	    window.alert('Your account is disapporved / removed. Please create a new account.')
	    window.location.href='sell-with-us.php';
	    </SCRIPT>");
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
	<title>Sell With Us</title>

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

<div class="content6">

	<!-- Header !-->
	<div class="header">
		<div class="userAccount">
			<h4>Seller Centre</h4>
		</div>
	</div>

	<div class="header2">
			<a href="../user/homepage.php"><label>Application Homepage</label></a>
	</div>

	<!-- Section !-->
	<div class="section">
		<h2><b>BE OUR POWER SELLER</b></h2>
		<p>What Are You Waiting For!</p>
	</div>

	<!-- Main !-->
	<div class="main">
		<div class="sellWithUs">
			<h1>Don't Be Afraid to Start</h1>
			<p>Manage your store efficiently at Application Name</p>
			<img src="../icons/store.png">
		</div>
	</div>

	<!-- Main2 !-->
	<div class="main2">
		<div class="sellerLogin">
			<h3>APPLICATION SELLER CENTRE</h3>
			<form method="post">
				<span class="error"> <?php echo $errorMessage;?></span>
				<br>

				<span class="far fa-envelope"></span>
				<input type="email" id="fname" name="email" placeholder="Email" required/>
				
				<span class="fa fa-lock"></span>
				<input type="Password" id="emaill" name="password" placeholder="Password" required/>
				<br>
				<a href="./forgot-password.php">Forgot your password?</a>
				<br><br>
				<input type="submit" name="Login" value="LOGIN">
				<br><br>
				<a href="../seller/signupSeller.php">No Account ? Create one here</a>
			</form>
		</div>
	</div>
</div>


</body>
</html>