<?php
session_start();

include("../validation.php");
$userClass = new UserClass();

if (!isset($_SESSION['id'])) {
	header("Location: homepage.php");
}

$id = $_SESSION['id'];
$fname = $lname = $gender = $email = $address = "";
$errorMessage = "";

try {
	$dbConnection = $userClass->DBConnect();
	$getInfo = $dbConnection->prepare('SELECT * FROM `Users` WHERE `id` = :id');
	$getInfo->bindValue(":id", $id,PDO::PARAM_INT);
	$getInfo->execute();

	while($row = $getInfo->fetch(PDO::FETCH_ASSOC)) {
    	$fname = $row['fname'];
    	$lname = $row['lname'];
    	$gender = $row['gender'];
    	$email = $row['email'];
    	$address = $row['address'];
	}
}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}


if (isset($_POST['Update'])) {
 
$fname = ucfirst($_POST['fname']);
$lname = ucwords($_POST['lname']);
$gender = $_POST['gender'];
$email = $_POST['email'];
$address = $_POST['address'];
$dob = date('Y-m-d', strtotime($_POST['bday']));

/* Regular expression check */
/*$pattern = "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";*/
$email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email);
//$password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);

if ($dob != "1970-01-01") {
    $update = $userClass->userUpdate1($fname, $lname, $gender, $email, $address, $dob, $id);

    if($update){
  
	   echo ("<SCRIPT LANGUAGE='JavaScript'>
	    window.alert('Your profile is successfully updated.')
	    window.location.href='homepage.php';
	    </SCRIPT>");
	  
	 }
	 else{
	  $errorMessage = "Email already exists";
	 }
}

else if ($dob == "1970-01-01") {
    $update = $userClass->userUpdate1($fname, $lname, $gender, $email, $address, $id);

    if($update){
  
	   echo ("<SCRIPT LANGUAGE='JavaScript'>
	    window.alert('Your profile is successfully updated.')
	    window.location.href='homepage.php';
	    </SCRIPT>");
	  
	 }
	 else{
	  $errorMessage = "Email already exists";
	 }
}

else{
 $errorMessage = "Please enter the valid details";
} 
 
}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Manage Profile</title>

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
		<a href='#shoppingcart'><span class='fa fa-shopping-cart'></span></a>
	</div>

	<!-- Section !-->
	<div class="section">
		<h2><b>MANAGE PROFILE</b></h2>
		<h3>Change Your Basic Information Settings</h3>
	</div>

	<!-- Main !-->
	<div class="mainn">
		<div class="login">
			<span class="error"> <?php echo $errorMessage;?> </span>
			<br>

			<form method="post">
				<div class="manageProfileForm">
					<div class="formLabel">
						<p><b>First Name</b></p>
						<p><b>Last Name</b></p>
						<p><b>Gender</b></p>
						<p><b>Email</b></p>
						<p><b>Address</b></p>
						<label><b>Date of Birth</b></label>
					</div>

					<div class="formInput">
						<input type="text" name="fname" value="<?php echo $fname;?>" autocomplete="off" required/>
						<input type="text" name="lname" value="<?php echo $lname;?>" autocomplete="off" required/>
						<select name="gender">
							<option value="male" <?php if($gender == "male"){ echo " selected='selected'"; } ?>>Male</option>
							<option value="female" <?php if($gender == "female"){ echo " selected='selected'"; } ?>>Female</option>
						</select>
						<input type="email" name="email" value="<?php echo $email;?>" autocomplete="off" required/>
						<input type="text" name="address" value="<?php echo $address;?>" autocomplete="off" required/>
						<input type="date" name="bday" class="dob">
					</div>
				</div>

	            <button name="Update" class="signUp">UPDATE</button>
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
				<a href='#''>Profile</a>
				<a href='#''>Checkout</a>
				<a href='./logout.php'>Log Out</a>	  
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

</script>


</body>
</html>