<?php
session_start();

include("../validation.php");
$userClass = new UserClass();

$errorMessage = "" ;
$link = $_SESSION['link'];

if (isset($_SESSION['id'])) {
	header("Location: homepage.php");
}

if (isset($_POST['Login'])) {
 
 $email=$_POST['email'];
 $password=$_POST['password'];
  
 if(strlen(trim($email))>1 && strlen(trim($password))>1 ){
  
  $id=$userClass->userLogin($email,$password);
        if($id){
   $url=$link;
   header("Location: $url"); // Page redirecting to homepage.php 
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
	<title>Login</title>

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

<div class="content12">

	<!-- Header !-->
	<div id="anchorHeader" class="header">
		<?php
		if (isset($_SESSION['id']) && $_SESSION['id'] != "") {
			echo "<div class='userAccount'>
			<div class='dropdown1'>
				<i class='fa fa-user'></i><a onclick='Function1()' class='LoginStatus'>".$_SESSION['fullname']."</a>
					<div id='myDropdown1' class='dropdown-content1'>
						<span class='fa fa-user'></span><a href='./manageProfile.php'>Manage Profile</a>
						<span class='fas fa-box'></span><a href='./userOrder.php'>My Orders</a>
						<span class='fa fa-lock'></span><a href='./logout.php'>Log out</a>
					</div>
			</div>
		</div>";
		}

		else {
			echo "<div class='userAccount'>
			<div class='dropdown1'>
				<i class='fa fa-user'></i><a onclick='Function1()' class='LoginStatus'>MY ACCOUNT</a>
					<div id='myDropdown1' class='dropdown-content1'>
						<span class='fa fa-lock'></span><a href='./login.php'>Sign In</a>
					</div>
			</div>
		</div>";
		}
		
		?>

		<div class="searchBox">
				<form method="get" class="searchBar" action="searchProducts.php">
					<input class="search-txt" type="text" name="search" placeholder="What Are You Looking For?">
					<button class="search-btn" href="./searchProducts.php">
					<i class="fa fa-search"></i></button>
				</form>
		</div>
	</div>

	<!-- Navigation !-->
	<div class="navigation">
		<ul>
		  <li><a class="active" href="./homepage.php">HOME</a></li>
		  <li><a href="./aboutUs.php">ABOUT US</a></li>
		  <li><a href="./contactUs.php">CONTACT US</a></li>
		  <li><a href="./sellerCentre.html">SELLER CENTRE</a></li>
		</ul>
	</div>

	<!-- Icon Navigation !-->
	<div class="iconNavigation">
		<?php
		if (!isset($_SESSION['id'])) {
			echo "<a href='./login.php'><span class='fa fa-shopping-cart'></span></a>";
		}

		else {
			echo "<a href='#shoppingcart'><span class='fa fa-shopping-cart'></span></a>";
		}

		?>
	</div>

	<!-- Section !-->
	<div class="section">
		<h2><b>LOG IN TO YOUR ACCOUNT</b></h2>
	</div>

	<!-- Main !-->
	<div class="main">
		<div class="login">
			<span class="error"> <?php echo $errorMessage;?></span>
			
			<form method="post">
				<div class="loginForm">
					<div class="formLabel">
						<p><b>Email</b></p>
						<label><b>Password</b></label>
					</div>

					<div class="formInput">
			            <input type="email" name="email" autocomplete="off" required/>
			            <input id="pwd" type="password" name="password" autocomplete="off" required/>
		       	 	</div>

		       	 	<div class="formButton">
		       	 		<input onclick="valueChange(); showPwd();" type="button" value="SHOW" id="showPwdBtn"></input>
		       	 	</div>
        		</div>
        		<a href="./forgot-password.php">Forgot your password?</a>
        		<br><br>

        		<button name="Login" class="signIn">SIGN IN</button>
        		<br>

	            <a href="./signup.php">No Account ? Create one here</a>
	            <br><br>
        	</form>
		</div>
	</div>

	<!-- Footer !-->
	<div class="footer">
		<div class="footer_content">
			<h4>Application Name</h4>
			<div class="vertical-menu">
			  <a href="./aboutUs.php">About Us</a>
			  <a href="./contactUs.php">Contact Us</a>
			  <a href="./sellerCentre">Sell with Us</a>
			</div>
		</div>

		<div class="footer_content">
			<h4>My Account</h4>
			<div class="vertical-menu">
			<?php
			if (!isset($_SESSION['id'])) {
				echo "<a href='./login.php'>Profile</a>
					  <a href='./login.php'>Checkout</a>
					  <a href='./login.php'>Sign In</a>
					  <a href='./signup.php'>Registration</a>";
			}

			else {
				echo "<a href='#''>Profile</a>
					  <a href='#''>Checkout</a>
					  <a href='./logout.php'>Log Out</a>";
			}	

			?>
			  
			</div>
		</div>

		<div class="footer_content2">
			<h4>Contact Information</h4>
			<p>NAME</p>
			<p>H/P</p>
			<p>Email</p>
		</div>

		<div class="footer_content3">
			<p>Copyright © All Right Reserved</p>
		</div>
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