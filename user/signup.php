<?php

include("../validation.php");
$userClass = new UserClass();

$emailErr = $genderErr = ""; 
$errorMessage = "";

if (isset($_SESSION['id'])) {
	header("Location: homepage.php");
}

if (isset($_POST['Register'])) {
 
$fname = ucfirst($_POST['fname']);
$lname = ucwords($_POST['lname']);
$gender = $_POST['gender'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$address = $_POST['address'];
$dob = date('Y-m-d', strtotime($_POST['bday']));

/* Regular expression check */
$email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email);
//$password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);

if ($_POST['gender'] == "none") {
        $genderErr = 'Please select your gender!';
}

if ($_POST['password'] != $_POST['confirm_password'])
{
	$errorMessage = "Password is not match!";
}

else if($email_check && $_POST['gender'] != "none" && $_POST['password'] == $_POST['confirm_password']){
 
     $id = $userClass->userRegistration($fname, $lname, $gender, $email, $password, $address, $dob);
 
 if($id){
   $userClass->emailRecovery1($email);
   echo ("<SCRIPT LANGUAGE='JavaScript'>
                window.location.href='login.php';
                </SCRIPT>");
  
 }
 else{
  $emailErr = "Email already exists";
 }
 
 
}

else{
 $emailErr = "Please enter the valid details";
} 
 
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Create an Account</title>

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
		<h2><b>CREATE AN ACCOUNT</b></h2>
	</div>

	<!-- Main !-->
	<div class="main">
		<div class="login">
			<span class="error"> <?php echo $errorMessage;?> </span>
			<h3>User Registration</h3>
			<a href="./login.php">Already have an account? Log in instead!</a>
			<br><br>

			<form method="post">

				<div class="signupUserForm">
					<div class="formLabel">
						<p><b>First Name</b></p>
						<p><b>Last Name</b></p>
						<p><b>Gender</b></p>
			            <p><b>Email</b></p>
			            <p><b>Password Strength</b></p>
			            <p><b>Password</b></p>
			            <p><b>Confirm Password</b></p>
			            <p><b>Address</b></p>
			            <label><b>Date of Birth</b></label>
					</div>

					<div class="formInput">
						<input type="text" name="fname" autocomplete="off" required/>
						<input type="text" name="lname" autocomplete="off" required/>
						<select name="gender">
							<option value="none">-- Select 	--</option>
							<option value="male">Male</option>
							<option value="female">Female</option>
						</select>
			            <input type="email" name="email" autocomplete="off" required/>
			            <label id="msg"></label>
			            <input id="pwd" type="password" name="password" autocomplete="off" onkeyup='validatePassword(this.value);' required/>
			            <input id="pwd2" type="password" name="confirm_password" autocomplete="off" required/>
			            <input type="text" name="address" autocomplete="off" required/>
			            <input type="date" name="bday" class="dob" required>
					</div>

			        <div id="position" class="formButton3">
			            <input onclick="valueChange(); showPwd();" type="button" value="SHOW" id="showPwdBtn"></input>
			        </div>

				</div>
	            	<button name="Register" class="signUp">SIGN UP</button>
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
    var y = document.getElementById("pwd2");
    if (x.type === "password" && y.type === "password") {
        x.type = "text";
        y.type = "text";
    } else {
        x.type = "password";
        y.type = "password";
    }
}

  function validatePassword(password) {
                
                // Do not show anything when the length of password is zero.
                if (password.length === 0) {
                    document.getElementById("msg").innerHTML = "";
                    document.getElementById("msg").style.paddingBottom = "4.5vw";
                    document.getElementById("position").style.marginBottom = "4.6vw";
                    return;
                }
                
                // Display it
                var color = "";
                var strength = "";

                if (password.length < 8)
                {
                	strength = "Very Weak";
                    color = "red";
                    document.getElementById("msg").style.paddingBottom = "2.9vw";
                }

                else if (password.length >= 8 && password.length < 16)
                {
                	strength = "Moderate";
                    color = "orange";
                    document.getElementById("msg").style.paddingBottom = "2.9vw";
                }

                else if (password.length >= 16)
                {
                	strength = "Strong";
                    color = "green";
                    document.getElementById("msg").style.paddingBottom = "2.9vw";
                }
                
                document.getElementById("msg").innerHTML = strength;
                document.getElementById("msg").style.color = color;
}

</script>


</body>
</html>