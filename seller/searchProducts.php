<?php
session_start();
include("../validation.php");
$userClass = new UserClass();

$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$search = substr(strstr($link, '='), strlen('='));

$sellerID = $_SESSION['id2'];
$totalStars = $productCount = 0;

// check user login
if(empty($_SESSION['id2']))
{
    header("Location: sell-with-us.php");
}

$productCount = $userClass->countSearch($search, $sellerID);

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

<div class="content10">

  <!-- Header !-->
  <div class="headerr">
    <div class="spacing">
      <label>Seller Centre</label>
      <span> &#8250; </span>
      <a href="./sellerProducts.php?status=all"><label>My Products</label></a>
      <span> &#8250; </span>
      <label>Search Results</label>
    </div>
  </div>

  <div class="header2">
    <a href="./sellerDashboard.php"><label>Application Dashboard</label></a>
  </div>

  <!-- Main !-->
  <div style="padding: 0;" class="main">
    <?php
      if ($productCount == 0 || $productCount == 1)
        echo '<h2>' . $productCount . ' result found for "' . $search . '" </h2>
              <hr>
              <br>';

      else if ($productCount > 1)
        echo '<h2>' . $productCount . ' results found for "' . $search . '" </h2>
              <hr>
              <br>';?>


      <div class="productContent">
      <?php
      $dbConnection = $userClass->DBConnect();
      $dbConnection2 = $userClass->DBConnect();

      $result = $dbConnection->prepare("SELECT * FROM `Products` WHERE `seller_id` = :id AND `name` LIKE '%{$search}%' OR `category` LIKE '%{$search}%' OR `subCategory` LIKE '%{$search}%' ORDER BY id ASC");
      $result->bindParam(':id', $sellerID,PDO::PARAM_INT); 
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

</body>
</html>