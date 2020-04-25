<?php
session_start();
include("../validation.php");
$userClass = new UserClass();

$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$status = substr(strstr($link, '='), strlen('='));

// check user login
if(empty($_SESSION['id2']))
{
    header("Location: sell-with-us.php");
}

$sellerID = $_SESSION['id2'];
$id = $total = $count = 0;
$status1 = "all";
$status2 = "live";
$status3 = "soldOut";

if ($status == $status1)
$count = $userClass->totalProduct($sellerID);

else if ($status == $status2)
$count = $userClass->totalProduct2($sellerID);

else if ($status == $status3)
$count = $userClass->totalProduct3($sellerID);

if(isset($_POST['id'])) {
	$id = $_POST['id'];
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Seller Centre</title>

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

<div class="content9">

	<!-- Header !-->
	<div class="headerr">
		<div class="spacing">
			<label>Seller Centre</label>
			<span> &#8250; </span>
			<label>My Products</label>
		</div>
	</div>

	<div class="header2">
		<a href="sellerDashboard.php"><label>Application Dashboard</label></a>
	</div>

	<!-- navigation !-->
	<div id="nav" class="navigation">
		<form method="get">
		<?php 
			if ($status == $status1)
			{
		?>
		<ul>
			<li><button name="status1" class="navBtn active" value="all">All</button></li>
			<li><button name="status2" class="navBtn" value="live">Live</button></li>
			<li><button name="status3" class="navBtn" value="soldOut">Sold Out</button></li>
		</ul>

		<?php
			} 
			else if ($status == $status2)
			{
		?>
		<ul>
			<li><button name="status1" class="navBtn" value="all">All</button></li>
			<li><button name="status2" class="navBtn active" value="live">Live</button></li>
			<li><button name="status3" class="navBtn" value="soldOut">Sold Out</button></li>
		</ul>

		<?php
			} 
			else if ($status == $status3)
			{
		?>
		<ul>
			<li><button name="status1" class="navBtn" value="all">All</button></li>
			<li><button name="status2" class="navBtn" value="live">Live</button></li>
			<li><button name="status3" class="navBtn active" value="soldOut">Sold Out</button></li>
		</ul>
		<?php } ?>
		</form>
	</div>

	<!-- Current !-->
	<div class="current">
		<label><?php echo $count . " products"?></label>
		<hr>
	</div>

	<!-- Filter section !-->
	<div class="filter">
		<div class="searchBox2">
			<form method="get" class="searchBar" action="searchProducts.php">
				<span class="fa fa-search"></span>
				<input class="search-txt" type="text" name="search" placeholder="Find Products">
			</form>
		</div>
	</div>

	<!-- Main !-->
	<div class="main">
		<div class="productContent">
			<div class="product">
				<form action="./upload.php">
					<button class="addProduct" type="submit">
						<img src="../icons/plus.png">
					</button>
					<br><br>
					<label>Add New Product</label>
				</form>
			</div>
			
			<?php
			if ($status == $status1)
			{
			$dbConnection = $userClass->DBConnect();
			$dbConnection2 = $userClass->DBConnect();

			$result = $dbConnection->prepare("SELECT * FROM `Products` WHERE `seller_id` = :sellerID ORDER BY id ASC");
			$result->bindParam(":sellerID", $sellerID ,PDO::PARAM_INT);
			$result->execute();

			for($i=0; $row = $result->fetch(); $i++){
				if (strlen($row["name"]) >= 34)
				$name = mb_strimwidth($row["name"], 0, 65, "...");

				else if (strlen($row["name"]) <= 33)
				$name = $row['name'] . " " . str_repeat("&nbsp;", 65);
				$id = $row['id'];
				$result2 = $dbConnection2->prepare("SELECT * FROM `ProductImages` WHERE `product_id` = :productID");
				$result2->bindParam(":productID", $id ,PDO::PARAM_INT);
				$result2->execute();
				$data=$result2->fetch(PDO::FETCH_OBJ);
		?>	
			<form method="post">
			<a href="<?php echo './editProduct.php?' . $id ?>">
			<div title="<?php echo $row['name'] ?>" class="product2">
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

							$result3 = $dbConnection3->prepare("SELECT * FROM `Review` WHERE `product_id` = :productID");
							$result3->bindParam(":productID", $id ,PDO::PARAM_INT);
							$result3->execute();

							$Count = $result3->rowCount();

							$total = 0;

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
						
					</div>
			</div>
			</a>
			</form>

			<?php
				} 
			}
			else if ($status == $status2)
			{
			$dbConnection = $userClass->DBConnect();
			$dbConnection2 = $userClass->DBConnect();

			$result = $dbConnection->prepare("SELECT * FROM `Products` WHERE `seller_id` = :sellerID AND `stock` > 0 ORDER BY id ASC");
			$result->bindParam(":sellerID", $sellerID ,PDO::PARAM_INT);
			$result->execute();

			for($i=0; $row = $result->fetch(); $i++){
				if (strlen($row["name"]) >= 34)
				$name = mb_strimwidth($row["name"], 0, 65, "...");

				else if (strlen($row["name"]) <= 33)
				$name = $row['name'] . " " . str_repeat("&nbsp;", 65);
				$id = $row['id'];
				$result2 = $dbConnection2->prepare("SELECT * FROM `ProductImages` WHERE `product_id` = :productID");
				$result2->bindParam(":productID", $id ,PDO::PARAM_INT);
				$result2->execute();
				$data=$result2->fetch(PDO::FETCH_OBJ);
		?>	
			<form method="post">
			<a href="<?php echo './editProduct.php?' . $id ?>">
			<div title="<?php echo $row['name'] ?>" class="product2">
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

							$total = 0;

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
					</div>
			</div>
			</a>
			</form>

			<?php
				} 
			}
			else if ($status == $status3)
			{
			$dbConnection = $userClass->DBConnect();
			$dbConnection2 = $userClass->DBConnect();

			$result = $dbConnection->prepare("SELECT * FROM `Products` WHERE `seller_id` = :sellerID AND `stock` = 0 ORDER BY id ASC");
			$result->bindParam(":sellerID", $sellerID ,PDO::PARAM_INT);
			$result->execute();

			for($i=0; $row = $result->fetch(); $i++){
				if (strlen($row["name"]) >= 34)
				$name = mb_strimwidth($row["name"], 0, 65, "...");

				else if (strlen($row["name"]) <= 33)
				$name = $row['name'] . " " . str_repeat("&nbsp;", 65);
				$id = $row['id'];
				$result2 = $dbConnection2->prepare("SELECT * FROM `ProductImages` WHERE `product_id` = :productID");
				$result2->bindParam(":productID", $id ,PDO::PARAM_INT);
				$result2->execute();
				$data=$result2->fetch(PDO::FETCH_OBJ);
		?>	
			<form method="post">
			<a href="<?php echo './editProduct.php?' . $id ?>">
			<div title="<?php echo $row['name'] ?>" class="product2">
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

							$total = 0;

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
						
					</div>
			</div>
			</a>
			</form>
			<?php } } ?>
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

// Add active class to the current button (highlight it)
var btnContainer = document.getElementById("nav");
var btns = btnContainer.getElementsByClassName("navBtn");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function(){
    var current = document.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");
    this.className += " active";
  });
}

</script>


</body>
</html>