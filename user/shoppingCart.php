<?php
session_start();

include("../validation.php");
$userClass = new UserClass();
$id = $_SESSION['id'];

$total = 0;

if (isset($_POST['Cancel'])) {
	$cartID = $_POST['cartID'];
 
 	$Confirmation = "<script> window.confirm('Do you want to cancel update your product?');
        </script>";

    echo $Confirmation;

        if ($Confirmation == true) {
        $userClass->removeItem($cartID);
        echo ("<SCRIPT LANGUAGE='JavaScript'>
        	window.alert('The product has been removed from your cart.')
            window.location.href='shoppingCart.php';
            </SCRIPT>");
    }    
}

else if (isset($_POST['Checkout'])) {
	$dbConnection = $userClass->DBConnect();

	$result = $dbConnection->prepare("SELECT * FROM `Cart` WHERE `user_id` = :id");
	$result->bindParam(":id", $id ,PDO::PARAM_STR);
	$result->execute();

	for($i=0; $row = $result->fetch(); $i++){
		$productID = $row['product_id'];
		$quantity = $row['quantity'];

	$userClass->addCheckout($id, $productID, $quantity);
	$userClass->addOrder($id, $productID, $quantity);
	$userClass->removeItem2($id);
  }
  	echo ("<SCRIPT LANGUAGE='JavaScript'>
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
		<h4>My Cart</h4>
	</div>

	<!-- Main !-->
	<div style="padding-bottom: 3vw; padding-top: 2vw;" class="mainn">
		<table style="text-align: center;" border="1" cellspacing="5" cellpadding="5" width="100%">
	<thead>
		<tr>
			<th></th>
			<th width="20%">Product Name</th>
			<th>Category</th>
			<th>Price</th>
			<th width="7%;">Quantity</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>

	<?php
			$dbConnection = $userClass->DBConnect();

			$result = $dbConnection->prepare("SELECT * FROM `Cart` WHERE `user_id` = :id");
			$result->bindParam(":id", $id ,PDO::PARAM_STR);
			$result->execute();

			$Count = $result->rowCount();

			if ($Count == 0)
			{
				echo ("<SCRIPT LANGUAGE='JavaScript'>
                    window.alert('Your cart is empty.')
                    window.location.href='homepage.php';
                    </SCRIPT>");
			}

			else {
			for($i=0; $row = $result->fetch(); $i++){

				$productID = $row['product_id'];
				$quantity = $row['quantity'];

			$dbConnection2 = $userClass->DBConnect();
			$result2 = $dbConnection2->prepare("SELECT * FROM `Products` WHERE `id` = :id ORDER BY id ASC");
			$result2->bindParam(':id', $productID,PDO::PARAM_INT);
			$result2->execute();
			for($x=0; $row2 = $result2->fetch(); $x++){

			$result3 = $dbConnection->prepare("SELECT * FROM `ProductImages` WHERE `product_id` = :id");
			$result3->bindParam(":id", $productID,PDO::PARAM_INT);
			$result3->execute();
			$data=$result3->fetch(PDO::FETCH_OBJ);
			$cartID = $row['id'];
	?>

	<form method="post">
		<tr>
			<td><img style="width: 10vw; height: 10vw;" src="<?php echo $data->source ?>"></td>
			<td><label><?php echo $row2["name"]; ?></label></td>
			<td><label><?php echo $row2['category']; ?></label></td>
			<?php
			if ($row2['sale_price'] == 0) {
				$total = $total + ($quantity * $row2['price']);
			?>
			<label><b>RM <?php echo $row2['price']; ?></b></label>

			<?php } else { 
				$total = $total + ($quantity * $row2['sale_price']); ?>
			<td>
				<label><strike><b>RM <?php echo $row2['price']; ?></strike></b></label>
				<br>
				<label style="color: orange"><b>RM <?php echo $row2['sale_price']; ?></b></label>
			</td>

			<?php } ?>
		
			<td><label><?php echo $quantity; ?></label></td>
			<td>
				<input type="hidden" name="cartID" value="<?php echo $cartID ?>"/>
				<input type="submit" name="Cancel" value="Cancel Item"/>
			</td>
		</tr>
		
	</tbody>
	<?php } } } ?>
	</table>
	<label style="padding-top: 1vw;"><b>TOTAL PRICE: RM <?php echo $total ?></b></label>

	<button type="submit" class="checkout" name="Checkout">CHECKOUT</button>
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

    var count = 1;
    var available = document.getElementById("available").value;
    var countEl = document.getElementById("count");

    function plus(){
      if (count > 0) {
        count++;
        countEl.value = count;
      }
    }
    function minus(){
      if (count > 1) {
        count--;
        countEl.value = count;
      }  
    }


</script>


</body>
</html>