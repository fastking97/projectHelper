<?php
session_start();

include("../validation.php");
$userClass = new UserClass();
$id = $_SESSION['id2'];

$total = 0;

if (!isset($_SESSION['id2'])) {
	header("Location: sell-with-us.php");
}

if (isset($_POST['Submit'])) {
	$action = $_POST['action'];
	$userID = $_POST['userID'];
	$quantity = $_POST['quantity'];
	$productID = $_POST['productID'];
	$date = $_POST['checkout'];

	if ($date == "0000-00-00")
	{
		$userClass->updateDate($userID, $productID, $action, $quantity);
		$userClass->updateDate2($userID, $productID, $action);
	}

	else
	{
		$userClass->updateStatus($userID, $productID, $action);
		$userClass->updateStatus2($userID, $productID, $action);
	}
}

else if (isset($_POST['Accept'])) {
	$action = "Order Processing";
	$userID = $_POST['userID'];
	$quantity = $_POST['quantity'];
	$productID = $_POST['productID'];
	$date = $_POST['checkout'];

	if ($date == "0000-00-00")
	{
		$userClass->updateDate($userID, $productID, $action, $quantity);
		$userClass->updateDate2($userID, $productID, $action);
	}

	else
	{
		$userClass->updateStatus($userID, $productID, $action);
		$userClass->updateStatus2($userID, $productID, $action);
	}
}

else if (isset($_POST['Delete'])) {
	$userID = $_POST['userID'];
	$productID = $_POST['productID'];

	$userClass->deleteOrder($userID, $productID);

}

else if (isset($_POST['Remove'])) {
	$userID = $_POST['userID'];
	$productID = $_POST['productID'];
	$receipt = $_POST['receiptSource'];

	$userClass->deleteReceipt($userID, $productID);
	$userClass->deleteReceipt2($userID, $productID);
}

else if (isset($_POST['Track'])) {
	$carrier = $_POST['Carrier'];
	$number = $_POST['Tracking'];
	$userID = $_POST['userID'];
	$productID = $_POST['productID'];

	$userClass->addTrackinginfo($carrier, $number, $userID, $productID);
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Manage Order</title>

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

<div class="content10">

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

	<!-- Main !-->
	<div style="padding-bottom: 3vw; padding-top: 2vw;" class="mainn">
		<table style="text-align: center;" border="1" cellspacing="5" cellpadding="5" width="100%">
	<thead>
		<tr>
			<th></th>
			<th width="30%">Product Name</th>
			<th width="10%">Category</th>
			<th width="10%">Price</th>
			<th width="7%;">Quantity</th>
			<th width="20%">Estimation of Arrival</th>
			<th width="30%">Shipping Address</th>
			<th width="30%">Delivery Information</th>
			<th>Transfer Receipt</th>
			<th width="10%">Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>

	<?php
			$dbConnection = $userClass->DBConnect();

			$result = $dbConnection->prepare("SELECT * FROM `SellerOrder` WHERE `seller_id` = :id");
			$result->bindParam(":id", $id ,PDO::PARAM_STR);
			$result->execute();

			$Count = $result->rowCount();

			if ($Count == 0)
			{
				echo ("<SCRIPT LANGUAGE='JavaScript'>
                    window.alert('You don't have any order.')
                    window.location.href='sellerDashboard.php';
                    </SCRIPT>");
			}

			else {
			for($i=0; $row = $result->fetch(); $i++){

				$productID = $row['product_id'];
				$quantity = $row['quantity'];
				$userID = $row['user_id'];
				$date = $row['checkoutDate'];

			$dbConnection2 = $userClass->DBConnect();
			$result2 = $dbConnection2->prepare("SELECT * FROM `Products` WHERE `id` = :id ORDER BY id ASC");
			$result2->bindParam(':id', $productID,PDO::PARAM_INT);
			$result2->execute();
			for($x=0; $row2 = $result2->fetch(); $x++){
				$seller_id = $row2['seller_id'];

			$result3 = $dbConnection->prepare("SELECT * FROM `ProductImages` WHERE `product_id` = :id");
			$result3->bindParam(":id", $productID,PDO::PARAM_INT);
			$result3->execute();
			$data=$result3->fetch(PDO::FETCH_OBJ);
			$cartID = $row['id'];
	?>

	<form method="post">
		<input type="hidden" name="productID" value="<?php echo $productID ?>"/>
		<input type="hidden" name="userID" value="<?php echo $userID ?>"/>
		<input type="hidden" name="quantity" value="<?php echo $quantity ?>"/>
		<input type="hidden" name="checkout" value="<?php echo $date ?>"/>
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

			<?php
				date_default_timezone_set('Asia/Jakarta');
	  			$current = date("d-m-Y", strtotime($row['checkoutDate']));
	  			$duration = date("d-m-Y", strtotime($row['checkoutDate']. "+" . $row2['sent_in'] . "days"));

	  			if ($row["status"] == "hold") {
			?>
			<td><label>hold</label></td>

			<?php } else if ($row["status"] == "arrived") { ?>
			<td><label>arrived</label></td>

			<?php 
			}	else { ?>
			<td><label><?php echo $current ?> <br> - <br> <?php echo $duration ?></label></td>

			<?php 
			}	
				$result4 = $dbConnection->prepare("SELECT * FROM `Users` WHERE `id` = :id");
				$result4->bindParam(':id', $userID,PDO::PARAM_INT);
				$result4->execute();
				$data2=$result4->fetch(PDO::FETCH_OBJ);
			?>
			<td><label><?php echo $data2->address ?></label></td>

			<?php if ($row['status'] != "hold" && empty($row['trackingCarrier']) || empty($row['trackingNumber'])) { ?>
			<td>
				<label style="color: blue"><b>Delivery carrier</b></label>
				<br>
				<input type="text" name="Carrier" autocomplete="off">
				<br><br>
				<label style="color: blue"><b>Tracking Number</b></label>
				<input type="text" name="Tracking" autocomplete="off">
				<br><br>
				<button type="submit" name="Track">Submit</button>
			</td>

			<?php } else { ?>

			<td>
				<label style="color: blue"><b>Delivery carrier</b></label>
				<br>
				<label><?php echo $row['trackingCarrier'] ?></label>
				<br><br>
				<label style="color: blue"><b>Tracking Number</b></label>
				<label><?php echo $row['trackingNumber'] ?></label>
			</td>

			<?php 
				} if (empty($row["transfer_receipt"]) && $row["status"] != "arrived") {
			?>
			<td>
				<label>None</label>
			</td>

			<?php } else if ($row["transfer_receipt"] != " " && $row["status"] != "arrived") { ?>
			<td>
				<input type="hidden" name="receiptSource" value="<?php echo $productID ?>"/>
				<a class="lightbox" href="<?php echo '#viewID' . $i; ?>">
				<div><img style="width: 20vw; height: 15vw;" src="<?php echo $row['transfer_receipt'];?>"></div>
				</a>
				<br><br>

				<?php if($row['status'] == "hold") { ?>
				<button type="submit" name="Accept">Accept Receipt</button>
				<button type="submit" name="Remove">Remove Receipt</button>

				<?php } ?>

				<div class="lightbox-target" id="<?php echo 'viewID' . $i; ?>">
				   <div><img style="width: 50vw; height: 35vw;" src="<?php echo $row['transfer_receipt'];?>"></div>
				<a class="lightbox-close" href=""></a>
				</div>
			</td>

			<?php } else if ($row['transfer_receipt'] == " " && $row["status"] != "arrived"){ ?>
			<td><label>None</label></td>

			<?php } else { ?>
			<td><label>Completed</label></td>

			<?php } if ($row["status"] == "arrived") { ?>
			<td>
				<label><?php echo $row["status"]; ?></label>
				<br>
				<?php
					$result5 = $dbConnection->prepare("SELECT `id` FROM `Comments` WHERE `user_id` = :id");
					$result5->bindParam(':id', $id,PDO::PARAM_INT);
					$result5->execute();
					$Count = $result5->rowCount();

					if ($Count != 1) {
				?>
				<?php } ?>
			</td>
			<?php } else if ($row["status"] == "hold") { ?>

			<td><label>Waiting for payment</label></td>
			<?php }  else { ?>

			<td><label><?php echo $row["status"]; ?></label></td>
			<?php } if ($row["status"] != "arrived") { ?>
			<td>
				<select name="action">
					<option value="delivering">Delivering</option>
					<option value="arrived">Arrived</option>
				</select>
				<br><br>
				<button name="Submit" style="cursor: pointer;" type="submit">Confirm</button>
			</td>

			<?php } else { ?>
			<td>
				<button name="Delete" style="cursor: pointer;" type="submit">Delete</button>
			</td>

			<?php } ?>
		</tr>
		</form>	
	</tbody>
	<?php } } } ?>
	</table>
	</div>
</div>

</body>
</html>