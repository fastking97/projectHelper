<?php
session_start();
include("../validation.php");
$userClass = new UserClass();

$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$search = substr(strstr($link, '='), strlen('='));
$_SESSION['link'] = $link;

$search = str_replace("%20"," ",$search);
$search = str_replace("%27",'"',$search);

$totalStars = $productCount = 0;

$productCount = $userClass->countSearch2($search);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Search Your Product</title>

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
  <div style="text-align: left; padding-left: 2vw; margin-bottom: 2vw; border-bottom: 2px solid lightgrey" class="sectionn">
    <?php
      if ($productCount == 0 || $productCount == 1)
        echo '<h2>' . $productCount . ' result found for "' . $search . '" </h2>';

      else if ($productCount > 1)
        echo '<h2>' . $productCount . ' results found for "' . $search . '" </h2>';?>
  </div>

  <!-- Main !-->
  <div style="padding: 0;" class="main">

      <div class="productContent">
      <?php
      $dbConnection = $userClass->DBConnect();
      $dbConnection2 = $userClass->DBConnect();

      $result = $dbConnection->prepare("SELECT * FROM `Products` WHERE `name` LIKE '%{$search}%' OR `category` LIKE '%{$search}%' OR `subCategory` LIKE '%{$search}%' ORDER BY id ASC");
      $result->execute();

      for($i=0; $row = $result->fetch(); $i++){
        if (strlen($row["name"]) >= 34)
        $name = mb_strimwidth($row["name"], 0, 65, "...");

        else if (strlen($row["name"]) <= 33)
        $name = $row['name'] . " " . str_repeat("&nbsp;", 53);

        $id = $row['id'];
        $result2 = $dbConnection2->prepare("SELECT * FROM `ProductImages` WHERE `product_id` = :productID");
        $result2->bindParam(":productID", $id ,PDO::PARAM_INT);
        $result2->execute();
        $data=$result2->fetch(PDO::FETCH_OBJ);
    ?>  
      <form method="post">
      <a href="<?php echo './product.php?' . $id ?>">
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
                echo "<label class='salePrice'>RM ". $row['sale_price'] . "</label> ";
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