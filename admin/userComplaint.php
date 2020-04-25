<?php 
session_start();

// check user login
if(empty($_SESSION['id3']))
{
    header("Location: adminLogin.php");
}

include("../validation.php");
$userClass = new UserClass();

$adminName = $_SESSION['username'];
$dir = "../seller/";

if (isset($_POST['Read'])) {
	$id = $_POST['id'];

	$update = $userClass->readMessage($id);

	if($update) {
		echo ("<SCRIPT LANGUAGE='JavaScript'>
                    window.alert('Message status is successfully updated.')
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
	<title>Admin</title>

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
				<i class='fa fa-user'></i><a onclick='Function1()' class='LoginStatus'><?php echo $adminName ?></a>
					<div id='myDropdown1' class='dropdown-content1'>
						<span class='fa fa-lock'></span><a href='./logoutAdmin.php'>Log out</a>
					</div>
			</div>
		</div>
	</div>

	<div class="header2">
    	<a href="./adminDashboard.php"><label>Admin Dashboard</label></a>
  	</div>

	<!-- Main !-->
	<div id="display" class="main">
		<table border="1" cellspacing="5" cellpadding="5" width="100%">
	<thead>
		<tr>
			<th>Name</th>
			<th>Email</th>
			<th>Subject</th>
			<th>Message</th>
			<th>Store Name</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$dbConnection = $userClass->DBConnect();
		$result = $dbConnection->prepare("SELECT * FROM `UserComplaint` WHERE `status` = 'unread' ORDER BY id ASC");
		$result->execute();
		for($i=0; $row = $result->fetch(); $i++){
			$id = $row['id'];
			$sellerID = $row['seller_id'];
	?>	
		<form method="post">
		<tr>
			<td><label><?php echo $row["name"]; ?></label></td>
			<td><label><?php echo $row['email']; ?></label></td>
			<td><label><?php echo $row['subject']; ?></label></td>
			<td><label><?php echo $row['message']; ?></label></td>
			<?php 
			$result2 = $dbConnection->prepare("SELECT * FROM `Sellers` WHERE `id` = :id");
			$result2->bindParam(":id", $sellerID,PDO::PARAM_INT);
			$result2->execute();
			$data=$result2->fetch(PDO::FETCH_OBJ);

			?>
			<td><label><?php echo $data->store; ?></label></td>
			<td>
				<input type="hidden" name="id" value="<?php echo $id ?>"/>
				<input type="submit" name="Read" value="Read" >
			</td>
		</tr>
		</form>
		<?php } ?>
	</tbody>
</table>
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