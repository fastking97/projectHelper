<?php
session_start();

include("../validation.php");
$userClass = new UserClass();

if (!isset($_SESSION['id2'])) {
	header("Location: ../seller/sell-with-us.php");
}

$id = $_SESSION['id2'];
$fname = $lname = $gender = $email = $phone = $bankName = $accNum = $recipient = $store = "";
$errorMessage = "";
$selected = 0;

try {
	$dbConnection = $userClass->DBConnect();
	$getInfo = $dbConnection->prepare('SELECT * FROM `Sellers` WHERE `id` = :id');
	$getInfo->bindValue(":id", $id,PDO::PARAM_INT);
	$getInfo->execute();

	while($row = $getInfo->fetch(PDO::FETCH_ASSOC)) {
    	$fname = $row['fname'];
    	$lname = $row['lname'];
    	$gender = $row['gender'];
    	$email = $row['email'];
    	$phone = $row['contact'];
    	$bankName = $row['bankName'];
    	$accNum = $row['accountNumber'];
    	$recipient = $row['recipient'];
    	$store = $row['store'];
	}
}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}

$value = 'value ="' . $bankName . '"';


if (isset($_POST['Update'])) {
 
$fname = ucfirst($_POST['fname']);
$lname = ucwords($_POST['lname']);
$gender = $_POST['gender'];
$email = $_POST['email'];
$dob = date('Y-m-d', strtotime($_POST['bday']));
$phone = $_POST['phone'];
$bankName = $_POST['bankName'];
$bankOther = ucwords($_POST['bankOther']);
$accNum = $_POST['accountNum'];
$recipient = ucwords($_POST['recipient']);
$store = $_POST['storeName'];

/* Regular expression check */
// Allow +, - and . in phone number
$filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);

/*$pattern = "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";*/
$email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email);
//$password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);

if ($dob != "1970-01-01" && $_POST['bankName'] != "other") {
    $update = $userClass->sellerUpdate1($fname, $lname, $gender, $email, $dob, $phone, $bankName, $accNum, $recipient, $store, $id);

    if($update){
  
	   echo ("<SCRIPT LANGUAGE='JavaScript'>
	    window.alert('Your profile is successfully updated.')
	    window.location.href='sellerDashboard.php';
	    </SCRIPT>");
	  
	 }
	 else{
	  $errorMessage = "Server Error";
	 }
}

else if ($dob != "1970-01-01" && $_POST['bankName'] == "other") {
    $update = $userClass->sellerUpdate2($fname, $lname, $gender, $email, $dob, $phone, $bankOther, $accNum, $recipient, $store, $id);

    if($update){
  
	   echo ("<SCRIPT LANGUAGE='JavaScript'>
	    window.alert('Your profile is successfully updated.')
	    window.location.href='sellerDashboard.php';
	    </SCRIPT>");
	  
	 }
	 else{
	  $errorMessage = "Server Error";
	 }
}

else if ($dob == "1970-01-01" && $_POST['bankName'] != "other") {
    $update = $userClass->sellerUpdate3($fname, $lname, $gender, $email, $phone, $bankName, $accNum, $recipient, $store, $id);

    if($update){
  
	   echo ("<SCRIPT LANGUAGE='JavaScript'>
	    window.alert('Your profile is successfully updated.')
	    window.location.href='sellerDashboard.php';
	    </SCRIPT>");
	  
	 }
	 else{
	  $errorMessage = "Server Error";
	 }
}

else if ($dob == "1970-01-01" && $_POST['bankName'] == "other") {
    $update = $userClass->sellerUpdate4($fname, $lname, $gender, $email, $phone, $bankOther, $accNum, $recipient, $store, $id);

    if($update){
  
	   echo ("<SCRIPT LANGUAGE='JavaScript'>
	    window.alert('Your profile is successfully updated.')
	    window.location.href='sellerDashboard.php';
	    </SCRIPT>");
	  
	 }
	 else{
	  $errorMessage = "Server Error";
	 }
}

else{
 $errorMessage = "Please enter the valid details";
} 
 
}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Manage Profile</title>

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

<div class="content8">

	<!-- Header !-->
    <div class="headerr">
      <div class="spacing">
        <label>Seller Centre</label>
        <span> &#8250; </span>
        <label>Manage Profile</label>
      </div>
    </div>

    <div class="header2">
      <a href="./sellerDashboard.php"><label>Application Dashboard</label></a>
    </div>

	<!-- Section !-->
	<div class="section">
		<h2><b>MANAGE PROFILE</b></h2>
		<h3>Change Your Basic Information Settings</h3>
	</div>

	<!-- Main !-->
	<div class="mainn">
		<div class="login">
			<span class="error"> <?php echo $errorMessage;?> </span>
			<br>

			<form method="post">
				<div class="manageProfileForm">
					<div class="formLabel">
						<p><b>First Name</b></p>
						<p><b>Last Name</b></p>
						<p><b>Gender</b></p>
						<p><b>Email</b></p>
						<p><b>Date of Birth</b></p>
						<p><b>Contact Number</b></p>
						<p><b>Bank Name</b></p>
						<div id="ifYes" style="display: none;">
			              <p for="bankName"><b>Other</b></p>
			            </div>
						<p><b>Account Number</b></p>
						<p><b>Recipient</b></p>
						<label><b>Store Name</b></label>
					</div>

					<div class="formInput">
						<input type="text" name="fname" value="<?php echo $fname;?>" autocomplete="off" required/>
						<input type="text" name="lname" value="<?php echo $lname;?>" autocomplete="off" required/>
						<select name="gender">
							<option value="male" <?php if($gender == "male"){ echo " selected='selected'"; } ?>>Male</option>
							<option value="female" <?php if($gender == "female"){ echo " selected='selected'"; } ?>>Female</option>
						</select>
						<input type="email" name="email" value="<?php echo $email;?>" autocomplete="off" required/>
						<input type="date" name="bday" class="dob">
						<input type="text" name="phone" value="<?php echo $phone;?>" autocomplete="off" required/>
						<select name="bankName" onchange="yesnoCheck(this);">
			              <option value="Maybank" <?php if($bankName == "Maybank"){ echo " selected='selected'"; $selected = 1; } ?>>Maybank</option>
			              <option value="CIMB Bank" <?php if($bankName == "CIMB Bank"){ echo " selected='selected'"; $selected = 1; } ?>>CIMB Bank</option>
			              <option value="Public Bank Berhad" <?php if($bankName == "Public Bank Berhad"){ echo " selected='selected'"; $selected = 1; } ?>>Public Bank Berhad</option>
			              <option value="RHB Bank" <?php if($bankName == "RHB Bank"){ echo " selected='selected'"; $selected = 1; } ?>>RHB Bank</option>
			              <option value="Hong Leong Bank" <?php if($bankName == "Hong Leong Bank"){ echo " selected='selected'"; $selected = 1; } ?>>Hong Leong Bank</option>
			              <option value="AmBank Group" <?php if($bankName == "AmBank Group"){ echo " selected='selected'"; $selected = 1; } ?>>AmBank Group</option>
			              <option value="United Overseas Bank" <?php if($bankName == "United Overseas Bank"){ echo " selected='selected'"; $selected = 1; } ?>>United Overseas Bank</option>
			              <option value="Bank Rakyat" <?php if($bankName == "Bank Rakyat"){ echo " selected='selected'"; $selected = 1; } ?>>Bank Rakyat</option>
			              <option value="OCBC Bank Berhad" <?php if($bankName == "OCBC Bank Berhad"){ echo " selected='selected'"; $selected = 1; } ?>>OCBC Bank Berhad</option>
			              <option value="HSBC Bank Berhad" <?php if($bankName == "HSBC Bank Berhad"){ echo " selected='selected'"; $selected = 1; } ?>>HSBC Bank Berhad</option>
			              <option value="other">Other</option>
			            </select>
			            <div id="ifYes2" style="display: none;">
			              <input type="text" name="bankOther" <?php if($selected == 0){ echo $value; } ?> autocomplete="off"/>
			            </div>
						<input type="number" name="accountNum" value="<?php echo $accNum;?>" autocomplete="off" required/>
						<input type="text" name="recipient" value="<?php echo $recipient;?>" autocomplete="off" required/>
						<input type="text" name="storeName" value="<?php echo $store;?>" autocomplete="off" required/>
					</div>
				</div>

	            <button name="Update" class="signUp">UPDATE</button>
	        </form>
		</div>
	</div>
</div>


<script>
function yesnoCheck(that) {
        if (that.value == "other") {
            document.getElementById("ifYes").style.display = "block";
            document.getElementById("ifYes2").style.display = "block";
            document.getElementById("position").style.marginBottom = "5.6vw";
        } else {
            document.getElementById("ifYes").style.display = "none";
            document.getElementById("ifYes2").style.display = "none";
            document.getElementById("position").style.marginBottom = "0.8vw";
        }
    }

</script>


</body>
</html>