<?php

include("../validation.php");
$userClass = new UserClass();

$errorMessage = "";

if (isset($_POST['Register'])) {
 
 
$fname = ucfirst($_POST['fname']);
$lname = ucwords($_POST['lname']);
$gender = $_POST['gender'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$dob = date('Y-m-d', strtotime($_POST['bday']));
$phone = $_POST['phone'];
$bankName = $_POST['bankName'];
$bankOther = ucwords($_POST['other']);
$accNum = $_POST['accountNum'];
$recipient = ucwords($_POST['recipient']);
$store = $_POST['storeName'];
$sellerStatus = "hold";
$image = "";

// Allow +, - and . in phone number
$filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);

/* Regular expression check */
$email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email);
//$password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);

$folder = "uploads/"; 

$image = $_FILES['student_id']['name']; 

$path = $folder . $image; 

if (!file_exists($_FILES['student_id']['tmp_name']) || !is_uploaded_file($_FILES['student_id']['tmp_name']))
{
   echo ("<SCRIPT LANGUAGE='JavaScript'>
                window.alert('Please upload your student ID.')
                window.location.href='signupSeller.php';
                </SCRIPT>");
}

if ($_POST['gender'] == "none") {
        echo ("<SCRIPT LANGUAGE='JavaScript'>
                window.alert('Please select your bank name.')
                window.location.href='signupSeller.php';
                </SCRIPT>");
}

if ($_POST['password'] != $_POST['confirm_password'])
{
	$errorMessage = "Password is not match!";
}

if ($_POST['bankName'] == "none") {
        echo ("<SCRIPT LANGUAGE='JavaScript'>
                window.alert('Please select your bank name.')
                window.location.href='signupSeller.php';
                </SCRIPT>");
}

else if($email_check && $_POST['gender'] != "none" && $_POST['password'] == $_POST['confirm_password'] && $_POST['bankName'] != "other"){

 	 move_uploaded_file( $_FILES['student_id'] ['tmp_name'], $path); 
     $id = $userClass->sellerRegistration($fname, $lname, $gender, $email, $password, $dob, $path, $phone, $bankName, $accNum, $recipient, $store, $sellerStatus);
 
 if($id){
   $userClass->emailRecovery2($email);
   echo ("<SCRIPT LANGUAGE='JavaScript'>
                window.location.href='sell-with-us.php';
                </SCRIPT>");
  
 }
 else{
  $errorMessage = "Email or store name already exists";
 }
 
 
}

else if($email_check && $_POST['gender'] != "none" && $_POST['password'] == $_POST['confirm_password'] && $_POST['bankName'] == "other"){

   move_uploaded_file( $_FILES['student_id'] ['tmp_name'], $path); 
     $id = $userClass->sellerRegistration($fname, $lname, $gender, $email, $password, $dob, $path, $phone, $bankOther, $accNum, $recipient, $store, $sellerStatus);
 
 if($id){
  
   header("Location: ../user/sell-with-us.php");
  
 }
 else{
  $errorMessage = "Email or store name already exists";
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
	<title>Create an Account</title>

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
  <div class="header">
    <div class="userAccount">
      <h4>Seller Centre</h4>
    </div>
  </div>

  <div class="header2">
      <a href="../user/homepage.php"><label>Application Homepage</label></a>
  </div>

  <!-- Section !-->
  <div class="section">
    <h2><b>CREATE AN ACCOUNT</b></h2>
  </div>

  <!-- Main !-->
  <div class="main">
    <div class="login">
      <span class="error"> <?php echo $errorMessage;?> </span>
      <h3>Just one step away to sell with us.</h3>

      <br><br>

      <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

        <div class="signupSellerForm">
          <div class="formLabel">
            <p><b>First Name</b></p>
            <p><b>Last Name</b></p>
            <p><b>Gender</b></p>
            <p><b>Email</b></p>
            <p><b>Password Strength</b></p>
            <p><b>Password</b></p>
            <p><b>Confirm Password</b></p>
            <p><b>Date of Birth</b></p>
            <p><b>Student ID</b></p>
            <p><b>Contact Number</b></p>
            <p><b>Bank Name</b></p>
            <div id="ifYes" style="display: none;">
              <p for="bankName"><b>Other</b></p>
            </div>
            <p><b>Account No</b></p>
            <p><b>Recipient Name</b></p>
            <label><b>Store Name</b></label>
          </div>

          <div class="formInput">
            <input type="text" name="fname" autocomplete="off" required/>
            <input type="text" name="lname" autocomplete="off" required/>
            <select name="gender">
              <option value="none">-- Select  --</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
            <input type="email" name="email" autocomplete="off" required/>
            <label id="msg"></label>
            <input id="pwd" type="password" name="password" autocomplete="off" onkeyup='validatePassword(this.value);' required/>
            <input id="pwd2" type="password" name="confirm_password" autocomplete="off" required/>
            <input type="date" name="bday" class="dob" required>
            <input type="file" name="student_id" class="studentID" accept="image/x-png,image/jpg,image/jpeg" />
            <input type="text" name="phone" value="+60" autocomplete="off" required/>
            <select name="bankName" onchange="yesnoCheck(this);">
              <option value="none">-- Select  --</option>
              <option value="Maybank">Maybank</option>
              <option value="CIMB Bank">CIMB Bank</option>
              <option value="Public Bank Berhad">Public Bank Berhad</option>
              <option value="RHB Bank">RHB Bank</option>
              <option value="Hong Leong Bank">Hong Leong Bank</option>
              <option value="AmBank Group">AmBank Group</option>
              <option value="United Overseas Bank">United Overseas Bank</option>
              <option value="Bank Rakyat">Bank Rakyat</option>
              <option value="OCBC Bank Berhad">OCBC Bank Berhad</option>
              <option value="HSBC Bank Berhad">HSBC Bank Berhad</option>
              <option value="other">Other</option>
            </select>
            <div id="ifYes2" style="display: none;">
              <input type="text" name="other" autocomplete="off"/>
            </div>
            <input type="number" name="accountNum" autocomplete="off" required/>
            <input type="text" name="recipient" autocomplete="off" required/>
            <input type="text" name="storeName" autocomplete="off" required/>
          </div>

          <div id="position" class="formButton2">
            <input onclick="valueChange(); showPwd();" type="button" value="SHOW" id="showPwdBtn"></input>
          </div>

        </div>
          <button name="Register" class="signUp">SIGN UP</button>
          </form>
    </div>
  </div>
</div>


<script>
function valueChange()
{
    var elem = document.getElementById("showPwdBtn");
    if (elem.value=="SHOW") {
      elem.value = "HIDE";
      document.getElementById("showPwdBtn").style.background = "#32CD32";
    }
    else {
      elem.value = "SHOW";
      document.getElementById("showPwdBtn").style.background = "#333";
    } 
}

function showPwd() {
    var x = document.getElementById("pwd");
    var y = document.getElementById("pwd2");
    if (x.type === "password" && y.type === "password") {
        x.type = "text";
        y.type = "text";
    } else {
        x.type = "password";
        y.type = "password";
    }
}

function validatePassword(password) {
                
                // Do not show anything when the length of password is zero.
                if (password.length === 0) {
                    document.getElementById("msg").innerHTML = "";
                    document.getElementById("position").style.marginBottom = "0.8vw";
                    document.getElementById("msg").style.marginBottom = "0";
                    return;
                }
                
                // Display it
                var color = "";
                var strength = "";

                if (password.length < 8)
                {
                  strength = "Very Weak";
                    color = "red";
                    document.getElementById("position").style.marginBottom = "0.8vw";
                    document.getElementById("msg").style.marginTop = "0";
                    document.getElementById("msg").style.marginBottom = "-1.5vw";
                }

                else if (password.length >= 8 && password.length < 16)
                {
                  strength = "Moderate";
                    color = "orange";
                    document.getElementById("position").style.marginBottom = "0.8vw";
                    document.getElementById("msg").style.marginTop = "0";
                    document.getElementById("msg").style.marginBottom = "-1.5vw";
                }

                else if (password.length >= 16)
                {
                  strength = "Strong";
                    color = "green";
                    document.getElementById("position").style.marginBottom = "0.8vw";
                    document.getElementById("msg").style.marginTop = "0";
                    document.getElementById("msg").style.marginBottom = "-1.5vw";
                }
                
                document.getElementById("msg").innerHTML = strength;
                document.getElementById("msg").style.color = color;
}

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