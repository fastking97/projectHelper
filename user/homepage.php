<?php
session_start();
include("../validation.php");
$userClass = new UserClass();

date_default_timezone_set('Asia/Jakarta');
$current = date('Y-m-d');
$totalStars = 0;

if (isset($_SESSION['id']) && $_SESSION['id'] != "") {
$id = $_SESSION['id'];
}

$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$_SESSION['link'] = $link;

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Start Smart Buy Smart</title>

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
<div class="content2">

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

	<!-- Image Slideshow !-->
	<div class="imageSlide">
		<div class='slide1'></div>
  		<div class='slide2'></div>
	</div>

	<!-- Why Us !-->
	<div class="WhyUs">
		<div class="whyUsMenu">
			<div class="whySection1">
				<i class="fas fa-shield-alt"></i>
				<h3>SECURE</h3>
				<p>This is a very long description1 to test out how fit the content will be</p>
			</div>

			<div class="whySection2">
				<i class="fas fa-bus"></i>
				<h3>FREE SHIPPING</h3>
				<p>This is a very long description2 to test out how fit the content will be</p>
			</div>

			<div class="whySection3">
				<i class="fas fa-credit-card"></i>
				<h3>MONEY BACK</h3>
				<p>This is a very long description3 to test out how fit the content will be</p>
			</div>

			<div class="whySection4">
				<i class="fas fa-users"></i>
				<h3>COMMUNITY</h3>
				<p>This is a very long description4 to test out how fit the content will be</p>
			</div>

		</div>
	</div>

	<!-- Section !-->
	<div class="section">
		<a href="./allCategory.php">Show All Category</a>
		<br><br>
		<div class="slider">
  <input type="radio" name="slider" title="slide1" checked="checked" class="slider__nav"/>
  <input type="radio" name="slider" title="slide2" class="slider__nav"/>
  <div class="slider__inner">
    <div class="gridMenu">
			<a href="./searchProducts.php?search=TV & Home Appliances">
			<div class="gridCategory">
				<img src="../icons/tv.png">
				<br>
				<label>TV & <br>Home Appliances</label>
			</div>
			</a>
			
			<a href="./searchProducts.php?search=Home & Lifestyle">
			<div class="gridCategory">
				<img src="../icons/living-room.png">
				<br>
				<label>Home & Lifestyle</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Groceries & Pets">
			<div class="gridCategory">
				<img src="../icons/groceries.png">
				<br>
				<label>Groceries & Pets</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Women Fashion">
			<div class="gridCategory">
				<img src="../icons/dress.png">
				<br>
				<label>Women's Fashion</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Men Fashion">
			<div class="gridCategory">
				<img src="../icons/formal-shirt.png">
				<br>
				<label>Men's Fashion</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Baby Fashion">
			<div class="gridCategory">
				<img src="../icons/baby-dress.png">
				<br>
				<label>Baby's Fashion</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Automotive & Motorcycles">
			<div class="gridCategory">
				<img src="../icons/car-icon.png">
				<br>
				<label>Automotive & <br>
				Motorcycles</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Sports & Travel">
			<div class="gridCategory">
				<img src="../icons/bike.png">
				<br>
				<label>Sports & Travel</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Electronic Devices">
			<div class="gridCategory">
				<img src="../icons/responsive.png">
				<br>
				<label>Electronic Devices</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Electronic Accessories">
			<div class="gridCategory">
				<img src="../icons/ipod.png">
				<br>
				<label>Electronic <br>Accessories</label>
			</div>
			</a>
	</div>

	<div class="gridMenu2">
			<a href="./searchProducts.php?search=Babies & Toys">
			<div class="gridCategory2">
				<img src="../icons/teddy-bear.png">
				<br>
				<label>Babies & Toys</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=DIY Gifts">
			<div class="gridCategory2">
				<img src="../icons/surprise.png">
				<br>
				<label>DIY Gifts</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Health & Beauty">
			<div class="gridCategory2">
				<img src="../icons/cosmetics.png">
				<br>
				<label>Health & Beauty</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Hobby & Collection">
			<div class="gridCategory2">
				<img src="../icons/puzzle.png">
				<br>
				<label>Hobby & Collection</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Souvenir & Party">
			<div class="gridCategory2">
				<img src="../icons/key-ring.png">
				<br>
				<label>Souvenir & Party</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Books & Utensils">
			<div class="gridCategory2">
				<img src="../icons/pencil-case.png">
				<br>
				<label>Books & Utensils</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Vouchers & Tickets">
			<div class="gridCategory2">
				<img src="../icons/ticket.png">
				<br>
				<label>Vouchers & Tickets</label>
			</div>
			</a>
	</div>
    <div class="slider__contents">
      <h2 class="slider__caption">Slide 4</h2>
      <p class="slider__txt">Content 4</p>
    </div>
  </div>
</div>
	</div>

	<!-- Main !-->
	<div style="padding-left:2vw; padding-right:2vw; text-align: left;" class="main">
		<h2>Latest Item</h2>
		<div class="productContent2">
			<?php
			$dbConnection = $userClass->DBConnect();
			$dbConnection2 = $userClass->DBConnect();

			$result = $dbConnection->prepare("SELECT * FROM `Products` WHERE `post_date` <= :current ORDER BY id DESC LIMIT 5");
			$result->bindParam(":current", $current ,PDO::PARAM_STR);
			$result->execute();

			for($i=0; $row = $result->fetch(); $i++){
				if (strlen($row["name"]) >= 26)
				$name = mb_strimwidth($row["name"], 0, 53, "...");

				else if (strlen($row["name"]) <= 25)
				$name = $row['name'] . " " . str_repeat("&nbsp;", 53);

				$id = $row['id'];
				$result2 = $dbConnection2->prepare("SELECT * FROM `ProductImages` WHERE `product_id` = :productID");
				$result2->bindParam(":productID", $id ,PDO::PARAM_INT);
				$result2->execute();
				$data=$result2->fetch(PDO::FETCH_OBJ);
		?>	
			<form method="post">
			<a href="<?php echo './product.php?' . $id ?>">
			<div title="<?php echo $row['name'] ?>" class="product3">
					<img src="<?php echo $data->source ?>">

					<div class="productSection">
						<div class="productTitle">
							<input type="hidden" name="id" value="<?php echo $id ?>"/>
							<p><?php echo $name ?></p>
						</div>

						<div class="productPrice">
							<?php 
							if ($row["sale_price"] != 0)
							{
								echo "<label class='retailPrice'><strike>RM " . $row['price'] . "</strike></label>";
								echo "<label class='salePrice'>RM ". $row['sale_price'] . "</label>	";
							}

							else if ($row["sale_price"] == 0)
							{
								echo "<label class='retailPrice'>RM " . $row['price'] . "</label>";
							}
							?>
							
						</div>	
					
							<?php
							$dbConnection3 = $userClass->DBConnect();

							$result3 = $dbConnection3->prepare("SELECT * FROM `Review` WHERE `product_id` = :productID ORDER BY id ASC");
							$result3->bindParam(":productID", $id ,PDO::PARAM_INT);
							$result3->execute();

							$Count = $result3->rowCount();

							if($Count  == 1 ) {
								for($i=0; $row = $result3->fetch(); $i++){
									$star1 = (1 * $row['star1']);
									$star2 = (2 * $row['star2']);
									$star3 = (3 * $row['star3']);
									$star4 = (4 * $row['star4']);
									$star5 = (5 * $row['star5']);
									$total = $star1 + $star2 + $star3 + $star4 + $star5;

									$totalStars += $row['star1'];
									$totalStars += $row['star2'];
									$totalStars += $row['star3'];
									$totalStars += $row['star4'];
									$totalStars += $row['star5'];

									$average = $total / $totalStars;

									echo '<div class="productRating">
									<i class="far fa-star"></i><label class="totalRating">' . number_format((float)$average, 1, '.', '') . '/5 (' . $totalStars . ')
										</label>
									</div>';
								}
							}
						?>	
						
					</div>
			</div>
			</a>
			</form>

			<?php } ?> 
		</div>
	</div>

	<!-- Footer !-->
	<div class="footer">
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
					  <a href='./shoppingCart.php'>Checkout</a>
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

</script>


</body>
</html>