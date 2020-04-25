<?php 
session_start();

// check user login
if(empty($_SESSION['id2']))
{
    header("Location: sell-with-us.php");
}

$sellerName = $_SESSION['fullname2'];

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Sell With Us</title>

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

<div class="content7">

	<!-- Header !-->
	<div class="header">
		<div class="userAccount">
			<div class='dropdown1'>
				<i class='fa fa-user'></i><a onclick='Function1()' class='LoginStatus'><?php echo $sellerName ?></a>
					<div id='myDropdown1' class='dropdown-content1'>
						<span class='fa fa-lock'></span><a href='./logoutSeller.php'>Log out</a>
					</div>
			</div>
		</div>
	</div>

	<div class="headerr2">
		<div class='userAccount2'>
			<h4>Seller Centre</h4>
		</div>
	</div>

	<!-- Main !-->
	<div class="main">
		<div class="dashboard">
			<a href="./sellerProducts.php?status=all">
				<div class="menu1">
					<img src="../icons/box.png">
					<label>My<br> Products</label>
				</div>
			</a>
			<a href="./manageOrder.php">
			<div class="menu2">
				<img src="../icons/shopping-bag.png">
				<label>My<br> Orders</label>
			</div>
			</a>
			<a href="./manageProfile.php">
			<div class="menu3">
				<img src="../icons/settings.png">
				<label>Manage Profile</label>
			</div>
			</a>
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