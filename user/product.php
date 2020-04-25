<?php
session_start();

$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$productID = substr(strstr($link, '?'), strlen('?'));

include("../validation.php");
$userClass = new UserClass();

if (isset($_SESSION['id']) && $_SESSION['id'] != "") {
	$id = $_SESSION['id'];
}

$_SESSION['link'] = $link;

$total = $quantity = 0;

if (isset($_POST['Cart'])) {
	$quantity = $_POST['quantity'];

	$check = $userClass->addItem($id, $productID, $quantity);

	if ($check) {
	echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('This product has been added to your cart.')
          	window.location.href='". $link . "';
            </SCRIPT>");
	}

	else {
		echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Server Error.')
            </SCRIPT>");
	}
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

<div class="content13">

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

	<?php
			$dbConnection = $userClass->DBConnect();

			$result = $dbConnection->prepare("SELECT * FROM `Products` WHERE `id` = :id");
			$result->bindParam(":id", $productID ,PDO::PARAM_STR);
			$result->execute();

			for($i=0; $row = $result->fetch(); $i++){

				$id = $row['id'];
				$sellerID = $row['seller_id'];
	?>

	<!-- Section !-->
	<div style="text-align: left; padding-left: 2vw;" class="sectionn">
		<div class="spacing">
			<a href="<?php echo'./searchProducts.php?search=' . $row['category'] ?>"><label><?php echo $row['category'] ?></label></a>
			<span> &#8250; </span>
			<a href="<?php echo'./searchProducts.php?search=' . $row['subCategory'] ?>"><label><?php echo $row['subCategory'] ?></label></a>
			<span> &#8250; </span>
			<a href="<?php echo'./searchProducts.php?search=' . $row['name'] ?>"><label><?php echo $row['name'] ?></label></a>
		</div>
	</div>

	<!-- Main !-->
	<div style="padding-bottom: 3vw" class="mainn">
	<?php 
		$result2 = $dbConnection->prepare("SELECT * FROM `productImages` WHERE `product_id` = :productID ORDER BY id ASC");
	    $result2->bindParam(":productID", $productID ,PDO::PARAM_INT);
	    $result2->execute();
	    $data=$result2->fetch(PDO::FETCH_OBJ);
	?>
		<img id="display" style="width: 30vw; height: 25vw; margin-top: 2vw; margin-bottom: 2vw;" src="<?php echo $data->source ?>">
		<br>
		<div style="flex: 0" class="thumbnail">
		<img onClick='document.getElementById("display").src = "<?php echo $data->source; ?>"' style="cursor: pointer; width: 7vw; height: 6vw;" src="<?php echo $data->source ?>">
		<?php 
			for($i=0; $row2 = $result2->fetch(); $i++){
				$image = $row2['source'];
		?>
			<img onClick='document.getElementById("display").src = "<?php echo $image; ?>"' style="cursor: pointer; width: 7vw; height: 6vw;" src="<?php echo $row2['source'] ?>">
			<?php } ?>
		</div>
	</div>

	<!-- Main2 !-->
	<div style="text-align: left; padding-right: 4vw; padding-top: 2vw;	" class="main2">
		<form method="post">
		<label><?php echo $row['name'] ?></label>
		<div class="allDetails">
			<?php
							$dbConnection3 = $userClass->DBConnect();

							$result3 = $dbConnection3->prepare("SELECT * FROM `Review` WHERE `product_id` = :productID ORDER BY id ASC");
							$result3->bindParam(":productID", $id ,PDO::PARAM_INT);
							$result3->execute();

							$Count = $result3->rowCount();

							if($Count  == 1 ) {
								for($i=0; $row3 = $result3->fetch(); $i++){
									$star1 = (1 * $row3['star1']);
									$star2 = (2 * $row3['star2']);
									$star3 = (3 * $row3['star3']);
									$star4 = (4 * $row3['star4']);
									$star5 = (5 * $row3['star5']);
									$totalStars = $star1 + $star2 + $star3 + $star4 + $star5;

									$total += $row3['star1'];
									$total += $row3['star2'];
									$total += $row3['star3'];
									$total += $row3['star4'];
									$total += $row3['star5'];

									$average = $totalStars / $total;

									echo '<div class="productRating">
									<i class="far fa-star"></i><label class="totalRating">' . number_format((float)$average, 1, '.', '') . '/5 (' . $total . ')
										</label>
									</div>';
								}
							}
			?>	
			<hr>
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
			<br><br><br>

			<div id="input_div">
			<?php 
			if ($row['stock'] == 0) {
			?>
			    <label>Quantity</label> 
			    <input type="hidden" name="available" id="available" value="<?php echo $row['stock'] ?>"/>
			    <input type="number" name="quantity" value="0" id="count" readonly>
			   
			    <label style="margin-left: 1vw; color: grey;">Restock soon</label>
			</div>
			<br>
			<?php 
			$result4 = $dbConnection->prepare("SELECT * FROM `Sellers` WHERE `id` = :id");
		    $result4->bindParam(":id", $sellerID ,PDO::PARAM_INT);
		    $result4->execute();
		    $data=$result4->fetch(PDO::FETCH_OBJ);
			?>
			<span>By <a style="color: #333" <?php echo 'href="./viewSeller.php?' . $sellerID .  '"'?> ><?php echo $data->store; ?></a></span> <a style="color: red; margin-left: 1vw" <?php echo 'href="./reportSeller.php?' . $sellerID .  '"'?> >Report seller</a>

			<br><br>
			<?php } else { ?>

			<label>Quantity</label> 
			    <input type="hidden" name="available" id="available" value="<?php echo $row['stock'] ?>"/>
			    <input style="margin-left: 1vw;" type="button" value="-" onclick="minus()">
			    <input type="number" name="quantity" value="1" id="count">
			    
			    <input type="button" value="+" onclick="plus()">
			    <label style="margin-left: 1vw; color: grey;"><?php echo $row['stock'] ?> left</label>
			</div>
			<br>
			<?php 
			$result4 = $dbConnection->prepare("SELECT * FROM `Sellers` WHERE `id` = :id");
		    $result4->bindParam(":id", $sellerID ,PDO::PARAM_INT);
		    $result4->execute();
		    $data2=$result4->fetch(PDO::FETCH_OBJ);
			?>

			<?php if (isset($_SESSION['id']) && $_SESSION['id'] != "") { ?>
			<span>By <a style="color: #333" <?php echo 'href="./viewSeller.php?' . $sellerID .  '"'?> ><?php echo $data2->store; ?></a></span> <a style="color: red; margin-left: 1vw" <?php echo 'href="./reportSeller.php?' . $sellerID .  '"'?> >Report seller</a>

			<?php } else { ?>
			<span>By <?php echo $data2->store; ?></span> <a style="color: red; margin-left: 1vw" <?php echo 'href="./login.php"'?>>Report seller</a>
			<?php } ?>


			<br><br>
			<?php if (isset($_SESSION['id']) && $_SESSION['id'] != "") { ?>
			<button name="Cart" class="cart" type="submit">Add to Cart</button>

			<?php } else { ?>
			<a name="Cart" class="cart2" href="./login.php">Add to Cart</a>
			<?php } ?>
			</form>

			<?php } ?>
		</div>
	</div>

	<div class="moreDetail">
		<h4>Product Details for <?php echo $row['name'] ?></h4>
		<p><?php echo nl2br($row['description']) ?></p>

		<div class="gap"></div>
	</div>

	<div class="review">
		<h4>Reviews for <?php echo $row['name'] ?></h4>

		<?php
				$dbConnection = $userClass->DBConnect();

				$result5 = $dbConnection->prepare("SELECT * FROM `Comments` WHERE `product_id` = :productID ORDER BY id ASC LIMIT 5");
				$result5->bindParam(":productID", $id ,PDO::PARAM_INT);
				$result5->execute();

				$Count = $result5->rowCount();

				if($Count > 0 ) {
					for($i=0; $row4 = $result5->fetch(); $i++) {
						$userID = $row4['user_id'];

				$result6 = $dbConnection->prepare("SELECT * FROM `Users` WHERE `id` = :id");
				$result6->bindParam(":id", $userID ,PDO::PARAM_INT);
				$result6->execute();

				$data3=$result6->fetch(PDO::FETCH_OBJ);
		?>

		<div class="reviewContent">
			<hr>
			<i class="far fa-star"></i><label class="totalRating"><?php echo $row4['rating'] ?></label>
			<br>
			<label>By <?php echo $row4['display_name'] ?></label>
			<p><?php echo $row4['comment'] ?></p>
		</div>

	<?php } } 

	else {
	?>

	<div style="text-align: center;" class="reviewContent">
			<hr>
			<h4>No reviews available yet</h4>
	</div>

	<?php } } ?>

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

    var available = document.getElementById("available").value;
    var countEl = document.getElementById("count");

    function plus(){
    	var count = countEl.value;
      if (count > 0 && count < available) {
        count++;
        countEl.value = count;
      }
    }
    function minus(){
    	var count = countEl.value;
      if (count > 1) {
        count--;
        countEl.value = count;
      }  
    }


</script>


</body>
</html>