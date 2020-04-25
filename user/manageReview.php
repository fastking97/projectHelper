<?php
session_start();

include("../validation.php");
$userClass = new UserClass();
$id = $_SESSION['id'];

$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$productID = substr(strstr($link, '='), strlen('='));

$total = 0;

if (!isset($_SESSION['id'])) {
	header("Location: homepage.php");
}

if (isset($_POST['Submit'])) {
	$detail = $_POST['detail'];
	$productRating = $_POST['rating'];


	if ($_POST['reviewAs'] == "reveal")
		$reviewName = $_SESSION['fullname'];

	else if ($_POST['reviewAs'] == "anonymous")
		$reviewName = $_POST['reviewAs'];

	$userClass->addComment($id, $productID, $productRating, $detail, $reviewName);
	$check = $userClass->checkProduct($productID);

	if ($check)
		$userClass->updateReview($productID, $productRating);

	else 
		$userClass->insertReview($productID, $productRating);

	echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Thank you for reviewing this product.')
          	window.location.href='userOrder.php';
            </SCRIPT>");
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Product</title>

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
		<h4>WRITE REVIEW</h4>
	</div>

	<!-- Main !-->
	<div style="padding-bottom: 3vw; padding-top: 2vw; text-align: center;" class="mainn">
	<form method="post">
		<?php
			$dbConnection = $userClass->DBConnect();
			$result = $dbConnection->prepare("SELECT * FROM `Products` WHERE `id` = :id");
			$result->bindParam(':id', $productID,PDO::PARAM_INT);
			$result->execute();
			$data=$result->fetch(PDO::FETCH_OBJ);

			$result2 = $dbConnection->prepare("SELECT * FROM `ProductImages` WHERE `product_id` = :id");
			$result2->bindParam(":id", $productID,PDO::PARAM_INT);
			$result2->execute();
			$data2=$result2->fetch(PDO::FETCH_OBJ);
		?>
		<img style="width: 12vw; height: 12vw" <?php echo 'src="' . $data2->source . '"' ?> >
		<h4><?php echo $data->name ?></h4>
		<label>Product Rating</label>
		<br>
		<select class="rating" name="rating">
			<option value="1">1 star</option>
			<option value="2">2 star</option>
			<option value="3">3 star</option>
			<option value="4">4 star</option>
			<option value="5">5 star</option>
		</select>
		<br><br>

		<label style="padding-top: 2vw;">Review Detail</label>
		<br>
		<textarea style="width: 50vw" name="detail" onfocus="expand(this)"></textarea>
		<br>
		<label style="padding-top: 2vw;">Review as</label>
		<br>
		<select style="margin-bottom: 2vw" class="rating" name="reviewAs">
			<option value="reveal"><?php echo $_SESSION['fullname']; ?></option>
			<option value="anonymous">Anonymous</option>
		</select>
		<br>
		<button class="submitReview" name="Submit" type="submit">SUBMIT</button>
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