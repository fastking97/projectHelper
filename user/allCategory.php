<?php 
session_start();
$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$_SESSION['link'] = $link;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>All Category</title>

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

<div class="content5">

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
		  <li><a href="./sell-with-us.php">SELLER CENTRE</a></li>
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

	<!-- Current Direction !-->
	<div class="current">
		<a href="./homepage.php">Homepage</a>
		<span> &#8250; </span>
		<label>All Category</label>
		<hr>
	</div>

	<!-- Main !-->
	<div class="main3">
		 <div class="gridMenu2">
			<a href="./searchProducts.php?search=TV & Home Appliances">
			<div class="gridCategory3">
				<img src="../icons/tv.png">
				<br>
				<label>TV & <br>Home Appliances</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Home & Lifestyle">
			<div class="gridCategory3">
				<img src="../icons/living-room.png">
				<br>
				<label>Home & Lifestyle</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Groceries & Pets">
			<div class="gridCategory3">
				<img src="../icons/groceries.png">
				<br>
				<label>Groceries & Pets</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Women Fashion">
			<div class="gridCategory3">
				<img src="../icons/dress.png">
				<br>
				<label>Women's Fashion</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Men Fashion">
			<div class="gridCategory3">
				<img src="../icons/formal-shirt.png">
				<br>
				<label>Men's Fashion</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Baby Fashion">
			<div class="gridCategory3">
				<img src="../icons/baby-dress.png">
				<br>
				<label>Baby's Fashion</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Automotive & Motorcycles">
			<div class="gridCategory3">
				<img src="../icons/car-icon.png">
				<br>
				<label>Automotive & <br>
				Motorcycles</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Sports & Travel">
			<div class="gridCategory3">
				<img src="../icons/bike.png">
				<br>
				<label>Sports & Travel</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Electronic Devices">
			<div class="gridCategory3">
				<img src="../icons/responsive.png">
				<br>
				<label>Electronic Devices</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Electronic Accessories">
			<div class="gridCategory3">
				<img src="../icons/ipod.png">
				<br>
				<label>Electronic <br>Accessories</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Babies & Toys">
			<div class="gridCategory3">
				<img src="../icons/teddy-bear.png">
				<br>
				<label>Babies & Toys</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=DIY Gifts">
			<div class="gridCategory3">
				<img src="../icons/surprise.png">
				<br>
				<label>DIY Gifts</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Health & Beauty">
			<div class="gridCategory3">
				<img src="../icons/cosmetics.png">
				<br>
				<label>Health & Beauty</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Hobby & Collection">
			<div class="gridCategory3">
				<img src="../icons/puzzle.png">
				<br>
				<label>Hobby & Collection</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Souvenir & Party">
			<div class="gridCategory3">
				<img src="../icons/key-ring.png">
				<br>
				<label>Souvenir & Party</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Books & Utensils">
			<div class="gridCategory4">
				<img src="../icons/pencil-case.png">
				<br>
				<label>Books & Utensils</label>
			</div>
			</a>

			<a href="./searchProducts.php?search=Vouchers & Tickets">
			<div class="gridCategory4">
				<img src="../icons/ticket.png">
				<br>
				<label>Vouchers & Tickets</label>
			</div>
			</a>
		</div>
	</div>

	<!-- Anchor !-->
	<div class="anchor">
		<a href="#alphabetA">A</a>
		<span> &#8901; </span>
		<a href="#alphabetB">B</a>
		<span> &#8901; </span>

		<span class="null"> C </span>
		<span> &#8901; </span>

		<a href="#alphabetD">D</a>
		<span> &#8901; </span>

		<a href="#alphabetE">E</a>
		<span> &#8901; </span>
		<span class="null"> F </span>
		<span> &#8901; </span>

		<a href="#alphabetG">G</a>
		<span> &#8901; </span>

		<a href="#alphabetH">H</a>
		<span> &#8901; </span>
		
		<span class="null"> I </span>
		<span> &#8901; </span>
		<span class="null"> J </span>
		<span> &#8901; </span>
		<span class="null"> K </span>
		<span> &#8901; </span>
		<span class="null"> L </span>
		<span> &#8901; </span>

		<a href="#alphabetM">M</a>
		<span> &#8901; </span>

		<span class="null"> N </span>
		<span> &#8901; </span>
		<span class="null"> O </span>
		<span> &#8901; </span>
		<span class="null"> P </span>
		<span> &#8901; </span>
		<span class="null"> Q </span>
		<span> &#8901; </span>
		<span class="null"> R </span>
		<span> &#8901; </span>

		<a href="#alphabetS">S</a>
		<span> &#8901; </span>
		<a href="#alphabetT">T</a>
		<span> &#8901; </span>

		<span class="null"> U </span>
		<span> &#8901; </span>

		<a href="#alphabetV">V</a>
		<span> &#8901; </span>

		<a href="#alphabetW">W</a>
		<span> &#8901; </span>

		<span class="null"> X </span>
		<span> &#8901; </span>
		<span class="null"> Y </span>
		<span> &#8901; </span>
		<span class="null"> Z </span>

	</div>

	<!-- Detail !-->
	<div id="detaill" class="detail">
		<div id="alphabetA" class="detailArea">
			<h1>A</h1>
			<hr>

			<a href="./searchProducts.php?search=Automotive & Motorcycle">Automotive & Motorcycle</a>
			<div class="categoryContent">
				<a href="./searchProducts.php?search=Automotive">Automotive</a>
				<a href="./searchProducts.php?search=Service & Installations">Service & Installations</a>
				<a href="./searchProducts.php?search=Auto Oils & Fluids">Auto Oils & Fluids</a>
				<a href="./searchProducts.php?search=Interior Accessories">Interior Accessories</a>
				<a href="./searchProducts.php?search=Exterior Accessories">Exterior Accessories</a>
				<a href="./searchProducts.php?search=Car Audio">Car Audio</a>
				<a href="./searchProducts.php?search=Auto Care">Auto Care</a>
				<a href="./searchProducts.php?search=Riding Gear">Riding Gear</a>
				<a href="./searchProducts.php?search=Moto Parts & Accessories">Moto Parts & Accessories</a>
				<a href="./searchProducts.php?search=Motorcycle">Motorcycle</a>
			</div>
		</div>

		<div id="alphabetB" class="detailArea">
			<h1>B</h1>
			<hr>

			<a href="./searchProducts.php?search=Baby Fashion">Baby's Fashion</a>
			<div class="categoryContent">
				<a href="./searchProducts.php?search=New Born Unisex">New Born Unisex (0 - 6 months old)</a>
				<a href="./searchProducts.php?search=New Born Body Suits">New Born Body Suits</a>
				<a href="./searchProducts.php?search=New Born Sets & Packs">New Born Sets & Packs</a>
				<a href="./searchProducts.php?search=Girls Clothing">Girls' Clothing</a>
				<a href="./searchProducts.php?search=Girls Shoes">Girls' Shoes</a>
				<a href="./searchProducts.php?search=Girls Swimwear">Girls' Swimwear</a>
				<a href="./searchProducts.php?search=Boys Clothing">Boys' Clothing</a>
				<a href="./searchProducts.php?search=Boys Shoes">Boys' Shoes</a>
				<a href="./searchProducts.php?search=Boys Swimwear">Boys' Swimwear</a>
			</div>

			<a href="./searchProducts.php?search=Babies & Toys">Babies & Toys</a>
			<div class="categoryContent">
				<a href="./searchProducts.php?search=Feeding">Feeding</a>
				<a href="./searchProducts.php?search=Milk Formula & Body">Milk Formula & Food</a>
				<a href="./searchProducts.php?search=Baby Gear">Baby Gear</a>
				<a href="./searchProducts.php?search=Diapering & Potty">Diapering & Potty</a>
				<a href="./searchProducts.php?search=Nursery">Nursery</a>
				<a href="./searchProducts.php?search=Baby Personal Care">Baby Personal Care</a>
				<a href="./searchProducts.php?search=Baby & Toddler Toys">Baby & Toddler Toys</a>
				<a href="./searchProducts.php?search=Collectible, RC & Vehicle">Collectible, RC & Vehicle</a>
				<a href="./searchProducts.php?search=Sports & Outdoot Play">Sports & Outdoor Play</a>
			</div>

			<a href="./searchProducts.php?search=Books & Utensils">Books & Utensils</a>
			<div class="categoryContent">
				<a href="./searchProducts.php?search=Reading Books">Reading Books</a>
				<a href="./searchProducts.php?search=Stationaries">Stationaries</a>
				<a href="./searchProducts.php?search=Magazines">Magazines</a>
				<a href="./searchProducts.php?search=Organizers">Organizers</a>
				<a href="./searchProducts.php?search=Comics">Comics</a>
				<a href="./searchProducts.php?search=Office Supplies">Office Supplies</a>
				<a href="./searchProducts.php?search=Notebooks & Papers">Notebooks & Papers</a>
				<a href="./searchProducts.php?search=Drawing & Painting Equipments">Drawing & Painting Equipments</a>
			</div>

			<div id="alphabetD" class="detailArea">
			<h1>D</h1>
			<hr>

			<a href="./searchProducts.php?search=DIY Gifts">DIY Gifts</a>
			<div class="categoryContent">
				<a href="./searchProducts.php?search=DIY">DIY</a>
			</div>
		</div>

		<div id="alphabetE" class="detailArea">
			<h1>E</h1>
			<hr>

			<a href="./searchProducts.php?search=Electronic Devices">Electronic Devices</a>
			<div class="categoryContent">
				<a href="./searchProducts.php?search=Mobiles">Mobiles</a>
				<a href="./searchProducts.php?search=Tablets">Tablets</a>
				<a href="./searchProducts.php?search=Laptops">Laptops</a>
				<a href="./searchProducts.php?search=Desktops">Desktops</a>
				<a href="./searchProducts.php?search=Gaming Consoles">Gaming Consoles</a>
				<a href="./searchProducts.php?search=Car Cameras">Car Cameras</a>
				<a href="./searchProducts.php?search=Action, Video Cameras">Action/Video Cameras</a>
				<a href="./searchProducts.php?search=Security Cameras">Security Cameras</a>
				<a href="./searchProducts.php?search=Digital Cameras">Digital Cameras</a>
				<a href="./searchProducts.php?search=Gadgets">Gadgets</a>
			</div>

			<a href="./searchProducts.php?search=Electronic Accessories">Electronic Accessories</a>
			<div class="categoryContent">
				<a href="./searchProducts.php?search=Mobile Accessories">Mobile Accessories</a>
				<a href="./searchProducts.php?search=Portable Audio">Portable Audio</a>
				<a href="./searchProducts.php?search=Wearables">Wearables</a>
				<a href="./searchProducts.php?search=Console Accessories">Console Accessories</a>
				<a href="./searchProducts.php?search=Camera Accessories">Camera Accessories</a>
				<a href="./searchProducts.php?search=Computer Accessories">Computer Accessories</a>
				<a href="./searchProducts.php?search=Storage">Storage</a>
				<a href="./searchProducts.php?search=">Printers</a>
				<a href="./searchProducts.php?search=Computer Components">Computer Components</a>
				<a href="./searchProducts.php?search=Tablet Accessories">Tablet Accessories</a>
			</div>
		</div>

		<div id="alphabetG" class="detailArea">
			<h1>G</h1>
			<hr>

			<a href="./searchProducts.php?search=Groceries & Pets">Groceries & Pets</a>
			<div class="categoryContent">
				<a href="./searchProducts.php?search=Beverages">Beverages</a>
				<a href="./searchProducts.php?search=Cereal & Confectionery">Cereal & Confectionery</a>
				<a href="./searchProducts.php?search=Dried & Canned Food">Dried & Canned Food</a>
				<a href="./searchProducts.php?search=Frozen, Frozen & Chilled">Fresh,Frozen & Chilled</a>
				<a href="./searchProducts.php?search=Laundry & Household">Laundry & Household</a>
				<a href="./searchProducts.php?search=Cats">Cats</a>
				<a href="./searchProducts.php?search=Dogs">Dogs</a>
				<a href="./searchProducts.php?search=Fish">Fish</a>
			</div>
		</div>

		<div id="alphabetM" class="detailArea">
			<h1>M</h1>
			<hr>

			<a href="./searchProducts.php?search=Men Fashion">Men's Fashion</a>
			<div class="categoryContent">
				<a href="./searchProducts.php?search=Casual Tops">Casual Tops</a>
				<a href="./searchProducts.php?search=Jackets & Coats">Jackets & Coats</a>
				<a href="./searchProducts.php?search=Shirts">Shirts</a>
				<a href="./searchProducts.php?search=Pants">Pants</a>
				<a href="./searchProducts.php?search=Jeans">Jeans</a>
				<a href="./searchProducts.php?search=Snekars">Snekars</a>
				<a href="./searchProducts.php?search=Formal Shoes">Formal Shoes</a>
				<a href="./searchProducts.php?search=Boots">Boots</a>
				<a href="./searchProducts.php?search=Bags">Bags</a>
				<a href="./searchProducts.php?search=Accessories">Accessories</a>
			</div>
		</div>

		<div id="alphabetS" class="detailArea">
			<h1>S</h1>
			<hr>

			<a href="./searchProducts.php?search=Sports & Travel">Sports & Travel</a>
			<div class="categoryContent">
				<a href="./searchProducts.php?search=Luggage">Luggage</a>
				<a href="./searchProducts.php?search=Laptop Bags">Laptop Bags</a>
				<a href="./searchProducts.php?search=Travel Accessories">Travel Accessories</a>
				<a href="./searchProducts.php?search=Exercise & Fitness">Exercise & Fitness</a>
				<a href="./searchProducts.php?search=Outdoor Recreation">Outdoor Recreation</a>
				<a href="./searchProducts.php?search=Women Clothing">Women's Clothing & Shoes</a>
				<a href="./searchProducts.php?search=Men Clothing & Shoes">Men's Clothing & Shoes</a>
				<a href="./searchProducts.php?search=Racket Sports">Racket Sports</a>
				<a href="./searchProducts.php?search=Water Sports">Water Sports</a>
				<a href="./searchProducts.php?search=Sport Accessories">Sport Accessories</a>
			</div>

			<a href="./searchProducts.php?search=Souvenir & Party">Souvenir & Party</a>
			<div class="categoryContent">
				<a href="./searchProducts.php?search=Others">Others</a>
				<a href="./searchProducts.php?search=Event Equipments">Event Equipments</a>
				<a href="./searchProducts.php?search=Wedding Souvenirs">Wedding Souvenirs</a>
			</div>
		</div>

		<div id="alphabetT" class="detailArea">
			<h1>T</h1>
			<hr>

			<a href="./searchProducts.php?search=TV & Home Appliances">TV & Home Appliances</a>
			<div class="categoryContent">
				<a href="./searchProducts.php?search=TV & Video Devices">TV & Video Devices</a>
				<a href="./searchProducts.php?search=TV Accessories">TV Accessories</a>
				<a href="./searchProducts.php?search=Home Audio">Home Audio</a>
				<a href="./searchProducts.php?search=Large Appliances">Large Appliances</a>
				<a href="./searchProducts.php?search=Small Kitchen Appliances">Small Kitchen Appliances</a>
				<a href="./searchProducts.php?search=Cooling & Air Treatment">Cooling & Air Treatment</a>
				<a href="./searchProducts.php?search=Vacuums & Floor Care">Vacuums & Floor Care</a>
				<a href="./searchProducts.php?search=Iron & Sewing Machines">Iron & Sewing Machines</a>
				<a href="./searchProducts.php?search=Parts & Accessories">Parts & Accessories</a>
			</div>
		</div>

		<div id="alphabetV" class="detailArea">
			<h1>V</h1>
			<hr>

			<a href="./searchProducts.php?search=Vouchers & Tickets">Vouchers & Tickets</a>
			<div class="categoryContent">
				<a href="./searchProducts.php?search=Mobile Reloads & Sim Cards">Mobile Reloads & Sim Cards</a>
				<a href="./searchProducts.php?search=Retail Vouchers">Retail Vouchers</a>
				<a href="./searchProducts.php?search=Restaurant & Spa Vouchers">Restaurant & Spa Vouchers</a>
				<a href="./searchProducts.php?search=Services">Services</a>
				<a href="./searchProducts.php?search=Bill Payments">Bill Payments</a>
				<a href="./searchProducts.php?search=Other Vouchers & Tickets">Other Vouchers & Tickets</a>
				<a href="./searchProducts.php?search=Event & Travel Vouchers">Event & Travel Vouchers</a>
			</div>
		</div>

		<div id="alphabetW" class="detailArea">
			<h1>W</h1>
			<hr>

			<a href="./searchProducts.php?search=Women Fashion">Women's Fashion</a>
			<div class="categoryContent">
				<a href="./searchProducts.php?search=Dresses">Dresses</a>
				<a href="./searchProducts.php?search=Tops">Tops</a>
				<a href="./searchProducts.php?search=Pants & Leggings">Pants & Leggings</a>
				<a href="./searchProducts.php?search=Jackets & Coats">Jackets & Coats</a>
				<a href="./searchProducts.php?search=Flat Shoes">Flat Shoes</a>
				<a href="./searchProducts.php?search=Sandals">Sandals</a>
				<a href="./searchProducts.php?search=Snekars">Sneakers</a>
				<a href="./searchProducts.php?search=Lingerie, Sleep & Lounge">Lingerie, Sleep & Lounge</a>
				<a href="./searchProducts.php?search=Muslim Wear">Muslim Wear</a>
				<a href="./searchProducts.php?search=Bags">Bags</a>
			</div>
		</div>

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

</script>


</body>
</html>