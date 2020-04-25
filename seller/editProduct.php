<?php
session_start();
$_SESSION['fail'] = 0;
$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$productID = substr(strstr($link, '?'), strlen('?'));

// check user login
if(empty($_SESSION['id2']))
{
    header("Location: sell-with-us.php");
}

include("../validation.php");
$userClass = new UserClass();

$errorMessage = "";
$name = $description = $category = $subCategory = $price = $sale_price = $stock = $sent_in = $condition = "";

try {
  $dbConnection = $userClass->DBConnect();
  $getInfo = $dbConnection->prepare('SELECT * FROM `Products` WHERE `id` = :id');
  $getInfo->bindValue(":id", $productID,PDO::PARAM_INT);
  $getInfo->execute();

  while($row = $getInfo->fetch(PDO::FETCH_ASSOC)) {
      $name = $row['name'];
      $description = $row['description'];
      $category = $row['category'];
      $subCategory = $row['subCategory'];
      $price = $row['price'];
      $sale_price = $row['sale_price'];
      $stock = $row['stock'];
      $sent_in = $row['sent_in'];
      $condition = $row['product_condition'];
  }
}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}

if (isset($_POST['Update'])) {

$productID = $_POST['id'];  
$name = ucwords($_POST['name']);
$description = $_POST['description'];
$category = $_POST['category'];
$subCategory = $_POST['subCategory'];
$price = $_POST['price'];
$sale_price = $_POST['sale_price'];
$stock = $_POST['stock'];
$sentIn = $_POST['sentIn'];
$condition = $_POST['condition'];
$image1 = $image2 = $image3 = $image4 = $image5 = "";
$upload = "upload";
$check = 0;
$folder = "../productImage/";

$i = 0;

while ($i < 5)
{
    if (!file_exists($_FILES[$upload . ($i + 1)]['tmp_name']) || !is_uploaded_file($_FILES[$upload . ($i + 1)]['tmp_name']))
    {
         $check++;
    }

    else {
      $check = $check;
    }

    $i++;
}

if ($check == 5)
{
    if ($price < 0 || $stock <= 0 || $sentIn <= 0)
    {
        echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('No negative values allowed.')
        </SCRIPT>");

        $_SESSION['fail'] = 1;
    }

    else {
        $id = $userClass->updateProduct($name, $description, $category, $subCategory, $price, $sale_price, $stock, $sentIn, $condition, $productID);
           
        if($id){
              echo ("<SCRIPT LANGUAGE='JavaScript'>
              window.alert('Your product has been updated successfully.')
              window.location.href='sellerProducts.php?status=all';
              </SCRIPT>");
          
          }
          else{ 
              echo ("<SCRIPT LANGUAGE='JavaScript'>
              window.alert('Server error.')
              window.location.href='sellerProducts.php?status=all';
              </SCRIPT>");
          }
    }
}

else {
    $i = 0;

    while ($i < 5)
    {
        if ($_FILES[$upload . ($i + 1)]['size'] > 2485760)
        {
            echo ("<SCRIPT LANGUAGE='JavaScript'>
          window.alert('Image number ". ($i+1) . " size has exceed the limit.')
          </SCRIPT>");
             $_SESSION['fail'] = 1;
             break;
        }

        else
          $i++;
    }


      if ($price < 0 || $stock <= 0 || $sentIn <= 0)
    {
        echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('No negative values allowed.')
        </SCRIPT>");

        $_SESSION['fail'] = 1;
    }

    else {
        $id = $userClass->updateProduct($name, $description, $category, $subCategory, $price, $sale_price, $stock, $sentIn, $condition, $productID);
           
        if($id){
          $i = 0;

          while ($i < 5)
          {
              if (file_exists($_FILES[$upload . ($i + 1)]['tmp_name']))
              {
                  move_uploaded_file( $_FILES[$upload . ($i + 1)] ['tmp_name'], $folder . $_FILES[$upload . ($i + 1)]['name']); 
                  $path = $folder . $_FILES[$upload . ($i + 1)]['name'];

                  $storeImg = $userClass->uploadImage($productID, $path);
                  $i++;
              }

              else 
              $i++;

            }

              echo ("<SCRIPT LANGUAGE='JavaScript'>
              window.alert('Your product has been updated successfully.')
              window.location.href='sellerProducts.php?status=all';
              </SCRIPT>");
          
          }
          else{ 
              echo ("<SCRIPT LANGUAGE='JavaScript'>
              window.alert('Server error.')
              window.location.href='sellerProducts.php?status=all';
              </SCRIPT>");
          }
      }
}


}
else if (isset($_POST['Delete'])) {
    $productID = $_POST['id'];  

    $id = $userClass->deleteProduct($productID);
           
        if($id){
              echo ("<SCRIPT LANGUAGE='JavaScript'>
              window.alert('Your product has been deleted.')
              window.location.href='sellerProducts.php?status=all';
              </SCRIPT>");
          
          }
          else{ 
              echo ("<SCRIPT LANGUAGE='JavaScript'>
              window.alert('Server error.')
              window.location.href='sellerProducts.php?status=all';
              </SCRIPT>");
          }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Add New Product</title>

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
      <label>Update Product Details</label>
    </div>
  </div>

  <div class="header2">
    <a href="./sellerDashboard.php"><label>Application Dashboard</label></a>
  </div>

  <!-- Main !-->
  <div class="main">
    <h2>Update Product</h2>

    <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
      <div class="imageSection">
    <?php
    $dbConnection = $userClass->DBConnect();
    $result = $dbConnection->prepare("SELECT * FROM `productImages` WHERE `product_id` = :productID ORDER BY id ASC");
    $result->bindParam(":productID", $productID ,PDO::PARAM_INT);
    $result->execute();

    for($i=0; $row = $result->fetch(); $i++){
      $content = "content";
      $fileUpload = "file-upload";
      $upload = "upload";
      $preview = "preview_image";
      $show = "show";
      $output = "output_image";
      $cancelUpload = "cancelUpload";
  ?>  
        <div id="<?php echo $content . ($i + 1)?>" class="imageContent" style="display: none">
          <img src="../icons/upload.png">
          <label for="<?php echo $fileUpload . ($i + 1)?>" class="btn">Upload image</label>
      <input name="<?php echo $upload . ($i + 1)?>" id="<?php echo $fileUpload . ($i + 1)?>" type="file" accept="image/x-png,image/jpg,image/jpeg" onchange="<?php echo $preview . ($i + 1) . '(this)'?>"/>
        </div>
        <div id="<?php echo $show . ($i + 1)?>" class="displayImage">
          <img id="<?php echo $output . ($i + 1)?>" src="<?php echo $row['source'] ?>"/>
        </div>

    <?php  }
    if ($i < 5) { 
      for($x = $i; $x < 5; $x++) {?>
        <div id="<?php echo $content . ($x + 1)?>" class="imageContent">
          <img src="../icons/upload.png">
          <label for="<?php echo $fileUpload . ($x + 1)?>" class="btn">Upload image</label>
      <input name="<?php echo $upload . ($x + 1)?>" id="<?php echo $fileUpload . ($x + 1)?>" type="file" accept="image/x-png,image/jpg,image/jpeg" onchange="<?php echo $preview . ($x + 1) . '(this)'?>"/>
        </div>
        <div id="<?php echo $show . ($x + 1)?>" class="displayImage" style="display: none">
          <img id="<?php echo $output . ($x + 1)?>" src="#"/>
          <br><br>
          <a onclick="<?php echo $cancelUpload . ($x + 1) . '()' ?>">cancel</a>
        </div>
      <?php } } ?>
      </div>

      <div id="theForm" class="uploadDetails">
          <div class="detailLabel">
            <p><span class="fas fa-file-signature"></span><b>Product Name</b></p>
            <p id="gap"><span class="fas fa-pencil-alt"></span><b>Product Description</b></p>
            <p><span class="fas fa-list"></span><b>Category</b></p>
            <p><span class="fas fa-list"></span><b>Sub Category</b></p>
            <p><span class="fas fa-dollar-sign"></span><b>Price</b></p>
            <p><span class="fas fa-dollar-sign"></span><b>Sale Price</b></p>
            <p><span class="fas fa-layer-group"></span><b>Stock</b></p>
            <p><span class="fas fa-truck"></span><b>Sent in</b></p>
            <p><span class="fas fa-exclamation"></span><b>Condition</b></p>
          </div>

           <div class="detailInput">
            <input type="hidden" name="id" value="<?php echo $productID ?>"/>

            <?php if ($_SESSION['fail'] == 1){ echo "<input style='width: 50.5vw;' type='text' name='name' value='". $_POST['name'] ."' placeholder='Keyword' autocomplete='off' required/>"; } else { echo "<input type='text' name='name' value='". $name ."' autocomplete='off' required/>"; } ?>

            <textarea id="description" name="description" placeholder="Product Description" onfocus="expand(this)" required/><?php if ($_SESSION['fail'] == 1){ echo htmlentities($_POST['description']); } else { echo htmlentities($description); } ?></textarea>

            <select id="category" name="category" onchange="changeSub()">
              <option value="Automotive & Motorcycle" <?php if($category == "Automotive & Motorcycle"){ echo " selected='selected'"; } ?>>Automotive & Motorcycle</option>
              <option value="Baby Fashion" <?php if($category == "Baby's Fashion"){ echo " selected='selected'"; } ?>>Baby's Fashion</option>
              <option value="Babies & Toys" <?php if($category == "Babies & Toys"){ echo " selected='selected'"; } ?>>Babies & Toys</option>
              <option value="Books & Utensils" <?php if($category == "Books & Utensils"){ echo " selected='selected'"; } ?>>Books & Utensils</option>
              <option value="DIY Gifts" <?php if($category == "DIY Gifts"){ echo " selected='selected'"; } ?>>DIY Gifts</option>
              <option value="Electronic Devices" <?php if($category == "Electronic Devices"){ echo " selected='selected'"; } ?>>Electronic Devices</option>
              <option value="Electronic Accessories" <?php if($category == "Electronic Accessories"){ echo " selected='selected'"; } ?>>Electronic Accessories</option>
              <option value="Groceries & Pets" <?php if($category == "Groceries & Pets"){ echo " selected='selected'"; } ?>>Groceries & Pets</option>
              <option value="Men Fashion" <?php if($category == "Men's Fashion"){ echo " selected='selected'"; } ?>>Men's Fashion</option>
              <option value="Sports & Travel" <?php if($category == "Sports & Travel"){ echo " selected='selected'"; } ?>>Sports & Travel</option>
              <option value="Souvenir & Party" <?php if($category == "Souvenir & Party"){ echo " selected='selected'"; } ?>>Souvenir & Party</option>
              <option value="TV & Home Appliances" <?php if($category == "TV & Home Appliances"){ echo " selected='selected'"; } ?>>TV & Home Appliances</option>
              <option value="Vouchers & Tickets" <?php if($category == "Vouchers & Tickets"){ echo " selected='selected'"; } ?>>Vouchers & Tickets</option>
              <option value="Women Fashion" <?php if($category == "Women's Fashion"){ echo " selected='selected'"; } ?>>Women's Fashion</option>
            </select>

            <script type="text/javascript">
              document.getElementById('category').value = "<?php echo $_POST['category'];?>";
            </script>

            <select name="subCategory" id="sub0" style="display: block;">
              <option value="<?php echo $subCategory ?>"><?php echo $subCategory ?></option>
            </select>

            <select id="sub1" style="display: none">
              <option value="Automotive">Automotive</option>
              <option value="Service & Installations">Service & Installations</option>
              <option value="Auto Oils & Fluids">Auto Oils & Fluids</option>
              <option value="Interior Accessories">Interior Accessories</option>
              <option value="Exterior Accessories">Exterior Accessories</option>
              <option value="Car Audio">Car Audio</option>
              <option value="Auto Care">Auto Care</option>
              <option value="Riding Gear">Riding Gear</option>
              <option value="Motor Parts & Accessories">Motor Parts & Accessories</option>
              <option value="Motorcycle">Motorcycle</option>
            </select>

            <select id="sub2" style="display: none">
              <option value="New Born Unisex (0 - 6 months old)">New Born Unisex (0 - 6 months old)</option>
              <option value="New Born Body Suits">New Born Body Suits</option>
              <option value="New Born Sets & Packs">New Born Sets & Packs</option>
              <option value="Girls Clothing">Girls' Clothing</option>
              <option value="Girls Shoes">Girls' Shoes</option>
              <option value="Girls Swimwear">Girls' Swimwear</option>
              <option value="Boys Clothing">Boys' Clothing</option>
              <option value="Boys Shoes">Boys' Shoes</option>
              <option value="Boys Swimwear">Boys' Swimwear</option>
            </select>

            <select id="sub3" style="display: none">
              <option value="Feeding">Feeding</option>
              <option value="Milk Formula & Food">Milk Formula & Food</option>
              <option value="Baby Gear">Baby Gear</option>
              <option value="Diapering & Potty">Diapering & Potty</option>
              <option value="Nursery">Nursery</option>
              <option value="Baby Personal Care">Baby Personal Care</option>
              <option value="Baby & Toddler Toys">Baby & Toddler Toys</option>
              <option value="Collectible, RC & Vehicle">Collectible, RC & Vehicle</option>
              <option value="Sports & Outdoor Play">Sports & Outdoor Play</option>
            </select>

            <select id="sub4" style="display: none">
              <option value="Reading Books">Reading Books</option>
              <option value="Stationaries">Stationaries</option>
              <option value="Magazines">Magazines</option>
              <option value="Organizers">Organizers</option>
              <option value="Comics">Comics</option>
              <option value="Office Supplies">Office Supplies</option>
              <option value="Notebooks & Papers">Notebooks & Papers</option>
              <option value="Drawing & Painting Equipments">Drawing & Painting Equipments</option>
            </select>

            <select id="sub5" style="display: none">
              <option value="DIY">DIY</option>
            </select>

            <select id="sub6" style="display: none">
              <option value="Mobiles">Mobiles</option>
              <option value="Tablets">Tablets</option>
              <option value="Laptops">Laptops</option>
              <option value="Desktops">Desktops</option>
              <option value="Gaming Consoles">Gaming Consoles</option>
              <option value="Car Cameras">Car Cameras</option>
              <option value="Action/Video Cameras">Action/Video Cameras</option>
              <option value="Security Cameras">Security Cameras</option>
              <option value="Digital Cameras">Digital Cameras</option>
              <option value="Gadgets">Gadgets</option>
            </select>

            <select id="sub7" style="display: none">
              <option value="Mobile Accessories">Mobile Accessories</option>
              <option value="Portable Audio">Portable Audio</option>
              <option value="Wearables">Wearables</option>
              <option value="Console Accessories">Console Accessories</option>
              <option value="Camera Accessories">Camera Accessories</option>
              <option value="Computer Accessories">Computer Accessories</option>
              <option value="Storage">Storage</option>
              <option value="Printers">Printers</option>
              <option value="Computer Components">Computer Components</option>
              <option value="Tablet Accessories">Tablet Accessories</option>
            </select>

            <select id="sub8" style="display: none">
              <option value="Beverages">Beverages</option>
              <option value="Cereal & Confectionery">Cereal & Confectionery</option>
              <option value="Dried & Canned Food">Dried & Canned Food</option>
              <option value="Fresh,Frozen & Chilled">Fresh,Frozen & Chilled</option>
              <option value="Laundry & Household">Laundry & Household</option>
              <option value="Cats">Cats</option>
              <option value="Dogs">Dogs</option>
              <option value="Fish">Fish</option>
            </select>

            <select id="sub9" style="display: none">
              <option value="Casual Tops">Casual Tops</option>
              <option value="Jackets & Coats">Jackets & Coats</option>
              <option value="Shirts">Shirts</option>
              <option value="Pants">Pants</option>
              <option value="Jeans">Jeans</option>
              <option value="Snekars">Snekars</option>
              <option value="Formal Shoes">Formal Shoes</option>
              <option value="Boots">Boots</option>
              <option value="Bags">Bags</option>
              <option value="Accessories">Accessories</option>
            </select>

            <select id="sub10" style="display: none">
              <option value="Luggage">Luggage</option>
              <option value="Laptop Bags">Laptop Bags</option>
              <option value="Travel Accessories">Travel Accessories</option>
              <option value="Exercise & Fitness">Exercise & Fitness</option>
              <option value="Outdoor Recreation">Outdoor Recreation</option>
              <option value="Women Clothing & Shoes">Women's Clothing & Shoes</option>
              <option value="Men Clothing & Shoes">Men's Clothing & Shoes</option>
              <option value="Racket Sports">Racket Sports</option>
              <option value="Water Sports">Water Sports</option>
              <option value="Sport Accessories">Sport Accessories</option>
            </select>

            <select id="sub11" style="display: none">
              <option value="Others">Others</option>
              <option value="Event Equipments">Event Equipments</option>
              <option value="Wedding Souvenirs">Wedding Souvenirs</option>
            </select>

            <select id="sub12" style="display: none">
              <option value="TV & Video Devices">TV & Video Devices</option>
              <option value="TV Accessories">TV Accessories</option>
              <option value="Home Audio">Home Audio</option>
              <option value="Large Appliances">Large Appliances</option>
              <option value="Small Kitchen Appliances">Small Kitchen Appliances</option>
              <option value="Cooling & Air Treatment">Cooling & Air Treatment</option>
              <option value="Vacuums & Floor Care">Vacuums & Floor Care</option>
              <option value="Iron & Sewing Machines">Iron & Sewing Machines</option>
              <option value="Parts & Accessories">Parts & Accessories</option>
            </select>

            <select id="sub13" style="display: none">
              <option value="Mobile Reloads & Sim Cards">Mobile Reloads & Sim Cards</option>
              <option value="Retail Vouchers">Retail Vouchers</option>
              <option value="Restaurant & Spa Vouchers">Restaurant & Spa Vouchers</option>
              <option value="Services">Services</option>
              <option value="Bill Payments">Bill Payments</option>
              <option value="Other Vouchers & Tickets">Other Vouchers & Tickets</option>
              <option value="Event & Travel Voucher">Event & Travel Vouchers</option>
            </select>

            <select id="sub14" style="display: none">
              <option value="Dresses">Dresses</option>
              <option value="Tops">Tops</option>
              <option value="Pants & Leggings">Pants & Leggings</option>
              <option value="Jackets & Coats">Jackets & Coats</option>
              <option value="Flat Shoes">Flat Shoes</option>
              <option value="Sandals">Sandals</option>
              <option value="Sneakers">Sneakers</option>
              <option value="Lingerie, Sleep & Lounge">Lingerie, Sleep & Lounge</option>
              <option value="Muslim Wear">Muslim Wear</option>
              <option value="Bags">Bags</option>
            </select>

            <script type="text/javascript">
              document.getElementById('subCategory').value = "<?php echo $_POST['subCategory'];?>";
            </script>

            <div class="holder">
            <label id="holder">RM</label>
            <?php if ($_SESSION['fail'] == 1){ echo "<input style='width: 50.5vw;' type='number' name='price' value='". $_POST['price'] ."' autocomplete='off' required/>"; } else { echo "<input type='number' name='price' value='". $price ."' autocomplete='off' required/>"; } ?>
            </div>

            <div class="holderr">
            <label id="holderr">RM</label>
            <?php if ($_SESSION['fail'] == 1){ echo "<input style='width: 50.5vw;' type='number' name='sale_price' value='". $_POST['sale_price'] ."' autocomplete='off' required/>"; } else { echo "<input type='number' name='sale_price' value='". $sale_price ."' autocomplete='off' required/>"; } ?>
            </div>

            <?php if ($_SESSION['fail'] == 1){ echo "<input style='width: 50.5vw;' type='number' name='stock' value='". $_POST['stock'] ."' autocomplete='off' required/>"; } else { echo "<input type='number' name='stock' value='". $stock ."' autocomplete='off' required/>"; } ?>

            <div class="holder2">
            <label id="holder2">days</label>
            <?php if ($_SESSION['fail'] == 1){ echo "<input style='width: 50.5vw;' type='number' name='sentIn' value='". $_POST['sentIn'] ."' autocomplete='off' required/>"; } else { echo "<input type='number' name='sentIn' value='". $sent_in ."' autocomplete='off' required/>"; } ?>
            </div>

            <select name="condition">
              <option value="new" <?php if($condition == "new"){ echo " selected='selected'"; } ?>>New</option>
              <option value="refurbished" <?php if($condition == "refurbished"){ echo " selected='selected'"; } ?>>Refurbished</option>
            </select>

            <script type="text/javascript">
              document.getElementById('condition').value = "<?php echo $_POST['condition'];?>";
            </script>
          </div>

          <div class="detailButton1">
            <button name="Update" type="submit">Update</button>
          </div>

          <div class="detailButton2">
            <a href="./sellerProducts.php?status=all">

            <button onclick="return confirm('Do you want to cancel update your product?');" type="button">Cancel
            </button>

            </a>
          </div>
      </div>
      <div class="detailButton3">
            <button name="Delete" type="submit" ">Delete Product</button>
      </div>
  </form>
  </div>
</div>

<script type='text/javascript'>

  function preview_image1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    document.getElementById("output_image1").setAttribute('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);

                document.getElementById("content1").style.display = "none";
                document.getElementById("show1").style.display = "block";
            }
        }

    function cancelUpload1() {
      document.getElementById("output_image1").setAttribute('src', "#");
      document.getElementById("content1").style.display = "flex";
        document.getElementById("show1").style.display = "none";
    }

    function preview_image2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    document.getElementById("output_image2").setAttribute('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);

                document.getElementById("content2").style.display = "none";
                document.getElementById("show2").style.display = "block";
            }
        }

    function cancelUpload2() {
      document.getElementById("output_image2").setAttribute('src', "#");
      document.getElementById("content2").style.display = "flex";
        document.getElementById("show2").style.display = "none";
    }

    function preview_image3(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    document.getElementById("output_image3").setAttribute('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);

                document.getElementById("content3").style.display = "none";
                document.getElementById("show3").style.display = "block";
            }
        }

    function cancelUpload3() {
      document.getElementById("output_image3").setAttribute('src', "#");
      document.getElementById("content3").style.display = "flex";
        document.getElementById("show3").style.display = "none";
    }

    function preview_image4(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    document.getElementById("output_image4").setAttribute('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);

                document.getElementById("content4").style.display = "none";
                document.getElementById("show4").style.display = "block";
            }
        }

    function cancelUpload4() {
      document.getElementById("output_image4").setAttribute('src', "#");
      document.getElementById("content4").style.display = "flex";
        document.getElementById("show4").style.display = "none";
    }

    function preview_image5(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    document.getElementById("output_image5").setAttribute('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);

                document.getElementById("content5").style.display = "none";
                document.getElementById("show5").style.display = "block";
            }
        }

    function cancelUpload5() {
      document.getElementById("output_image5").setAttribute('src', "#");
      document.getElementById("content5").style.display = "flex";
        document.getElementById("show5").style.display = "none";
    }

    function expand(area) {
      area.style.color = "#333";
      area.style.height = "11vw";
      document.getElementById("gap").style.paddingBottom = "11vw";
      document.getElementById("theForm").style.height = "65vw";
      document.getElementById("holder").style.top = "34.5vw";
      document.getElementById("holder2").style.top = "47.5vw";
    }

   function changeSub() {
      var sub = " ";
      var i = 0;

      if (document.getElementById("category").value == "Automotive & Motorcycle")
      {
        while (i < 15)
        {
          sub = "sub" + i;
          show = "sub1";

          if (sub == show)
          {
            document.getElementById(sub).style.display = "block";
            document.getElementById(sub).setAttribute('name', 'subCategory');
          }

          else{
            document.getElementById(sub).style.display = "none";
            document.getElementById(sub).setAttribute('name', '');
          }

          i++;
        }
      }

      else if (document.getElementById("category").value == "Baby's Fashion")
      {
        while (i < 15)
        {
          sub = "sub" + i;
          show = "sub2";

          if (sub == show)
          {
            document.getElementById(sub).style.display = "block";
            document.getElementById(sub).setAttribute('name', 'subCategory');
          }

          else{
            document.getElementById(sub).style.display = "none";
            document.getElementById(sub).setAttribute('name', '');
          }

          i++;
        }
      }

      else if (document.getElementById("category").value == "Babies & Toys")
      {
        while (i < 15)
        {
          sub = "sub" + i;
          show = "sub3";

          if (sub == show)
          {
            document.getElementById(sub).style.display = "block";
            document.getElementById(sub).setAttribute('name', 'subCategory');
          }

          else{
            document.getElementById(sub).style.display = "none";
            document.getElementById(sub).setAttribute('name', '');
          }

          i++;
        }
      }

      else if (document.getElementById("category").value == "Books & Utensils")
      {
        while (i < 15)
        {
          sub = "sub" + i;
          show = "sub4";

          if (sub == show)
          {
            document.getElementById(sub).style.display = "block";
            document.getElementById(sub).setAttribute('name', 'subCategory');
          }

          else{
            document.getElementById(sub).style.display = "none";
            document.getElementById(sub).setAttribute('name', '');
          }

          i++;
        }
      }

      else if (document.getElementById("category").value == "DIY Gifts")
      {
        while (i < 15)
        {
          sub = "sub" + i;
          show = "sub5";

          if (sub == show)
          {
            document.getElementById(sub).style.display = "block";
            document.getElementById(sub).setAttribute('name', 'subCategory');
          }

          else{
            document.getElementById(sub).style.display = "none";
            document.getElementById(sub).setAttribute('name', '');
          }

          i++;
        }
      }

      else if (document.getElementById("category").value == "Electronic Devices")
      {
        while (i < 15)
        {
          sub = "sub" + i;
          show = "sub6";

          if (sub == show)
          {
            document.getElementById(sub).style.display = "block";
            document.getElementById(sub).setAttribute('name', 'subCategory');
          }

          else{
            document.getElementById(sub).style.display = "none";
            document.getElementById(sub).setAttribute('name', '');
          }

          i++;
        }
      }

      else if (document.getElementById("category").value == "Electronic Accessories")
      {
        while (i < 15)
        {
          sub = "sub" + i;
          show = "sub7";

          if (sub == show)
          {
            document.getElementById(sub).style.display = "block";
            document.getElementById(sub).setAttribute('name', 'subCategory');
          }

          else{
            document.getElementById(sub).style.display = "none";
            document.getElementById(sub).setAttribute('name', '');
          }

          i++;
        }
      }

      else if (document.getElementById("category").value == "Groceries & Pets")
      {
        while (i < 15)
        {
          sub = "sub" + i;
          show = "sub8";

          if (sub == show)
          {
            document.getElementById(sub).style.display = "block";
            document.getElementById(sub).setAttribute('name', 'subCategory');
          }

          else{
            document.getElementById(sub).style.display = "none";
            document.getElementById(sub).setAttribute('name', '');
          }

          i++;
        }
      }

      else if (document.getElementById("category").value == "Men's Fashion")
      {
        while (i < 15)
        {
          sub = "sub" + i;
          show = "sub9";

          if (sub == show)
          {
            document.getElementById(sub).style.display = "block";
            document.getElementById(sub).setAttribute('name', 'subCategory');
          }

          else{
            document.getElementById(sub).style.display = "none";
            document.getElementById(sub).setAttribute('name', '');
          }

          i++;
        }
      }

      else if (document.getElementById("category").value == "Sports & Travel")
      {
        while (i < 15)
        {
          sub = "sub" + i;
          show = "sub10";

          if (sub == show)
          {
            document.getElementById(sub).style.display = "block";
            document.getElementById(sub).setAttribute('name', 'subCategory');
          }

          else{
            document.getElementById(sub).style.display = "none";
            document.getElementById(sub).setAttribute('name', '');
          }

          i++;
        }
      }

      else if (document.getElementById("category").value == "Souvenir & Party")
      {
        while (i < 15)
        {
          sub = "sub" + i;
          show = "sub11";

          if (sub == show)
          {
            document.getElementById(sub).style.display = "block";
            document.getElementById(sub).setAttribute('name', 'subCategory');
          }

          else{
            document.getElementById(sub).style.display = "none";
            document.getElementById(sub).setAttribute('name', '');
          }


          i++;
        }
      }

      else if (document.getElementById("category").value == "TV & Home Appliances")
      {
        while (i < 15)
        {
          sub = "sub" + i;
          show = "sub12";

          if (sub == show)
          {
            document.getElementById(sub).style.display = "block";
            document.getElementById(sub).setAttribute('name', 'subCategory');
          }

          else{
            document.getElementById(sub).style.display = "none";
            document.getElementById(sub).setAttribute('name', '');
          }

          i++;
        }
      }

      else if (document.getElementById("category").value == "Vouchers & Tickets")
      {
        while (i < 15)
        {
          sub = "sub" + i;
          show = "sub13";

          if (sub == show)
          {
            document.getElementById(sub).style.display = "block";
            document.getElementById(sub).setAttribute('name', 'subCategory');
          }

          else{
            document.getElementById(sub).style.display = "none";
            document.getElementById(sub).setAttribute('name', '');
          }

          i++;
        }
      }

      else if (document.getElementById("category").value == "Women's Fashion")
      {
        while (i < 15)
        {
          sub = "sub" + i;
          show = "sub14";

          if (sub == show)
          {
            document.getElementById(sub).style.display = "block";
            document.getElementById(sub).setAttribute('name', 'subCategory');
          }

          else{
            document.getElementById(sub).style.display = "none";
            document.getElementById(sub).setAttribute('name', '');
          }

          i++;
        }
      }

      else {
        while (i < 15)
        {
          sub = "sub" + i;
          show = "sub0";

          if (sub == show)
          {
            document.getElementById(sub).style.display = "block";
            document.getElementById(sub).setAttribute('name', 'subCategory');
          }

          else{
            document.getElementById(sub).style.display = "none";
            document.getElementById(sub).setAttribute('name', '');
          }

          i++;
        }
      }

    }

</script>

</body>
</html>