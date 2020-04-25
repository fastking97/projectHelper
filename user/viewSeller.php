<?php
session_start();

include("../validation.php");
$userClass = new UserClass();
$id = $_SESSION['id'];

$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$userID = substr(strstr($link, '?'), strlen('?'));

$total = 0;

if (!isset($_SESSION['id'])) {
	header("Location: homepage.php");
}

if (isset($_POST['Update'])) {
	$address = $_POST['new'];

	$userClass->updateAddress($userID, $address);

	echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Your address has been updated.')
          	window.location.href='userOrder.php';
            </SCRIPT>");
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Seller Profile</title>

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

<div class="content">

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
			echo "<a href='./shoppingCart.php'><span class='fa fa-shopping-cart'></span></a>";
		}

		?>
	</div>

	<!-- Section !-->
	<div style="text-align: left; padding-left: 2vw;" class="sectionn">
	<?php
		$dbConnection = $userClass->DBConnect();
		$result = $dbConnection->prepare("SELECT * FROM `Sellers` WHERE `id` = :id");
		$result->bindParam(':id', $userID,PDO::PARAM_INT);
		$result->execute();
		$data=$result->fetch(PDO::FETCH_OBJ);
	?>
		<h4><?php echo $data->store ?></h4>
	</div>

	<!-- Main !-->
	<div style="padding-bottom: 3vw; padding-top: 2vw; text-align: center;" class="mainn">
	<form method="post">
		<h4>Seller Name</h4>
		<label><?Php echo $data->fname . " " . $data->lname ?></label>
		<br><br>

		<h4>Student ID</h4>
		<label><?Php echo $data->IDNum ?></label>
		<br><br>

		<h4>Contact Number</h4>
		<label><?Php echo $data->contact ?></label>
		<br><br>
		
	</form>
	</div>


	<!-- Footer !-->
	<div class="footer">
		<div class="gap"></div>
		<div class="footer_content">
			<h4>Application Name</h4>
			<div class="vertical-menu">
			  <a href="./aboutUs.php">About Us</a>
			  <a href="./contactUs.php">Contact Us</a>
			  <a href="./sellerCentre.html">Sell with Us</a>
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
				echo "<a href='./manageProfile.php''>Profile</a>
					  <a href='./shoppingCart.php>Checkout</a>
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

    function expand(area) {
      area.style.color = "#333";
      area.style.height = "10vw";
    }

</script>


</body>
</html>