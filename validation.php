<?php
Class UserClass{

// connect to mysql database 
public function DBConnect(){

$dbhost ="localhost"; // set the hostname
$dbname ="E-Commerce" ; // set the database name
$dbuser ="root" ; // set the mysql username
$dbpass ="";  // set the mysql password


try {
$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass); 
$dbConnection->exec("set names utf8");
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
return $dbConnection;

}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
 
 
 
} 


// logic and validation for user registration page
public function userRegistration($fname, $lname, $gender ,$email, $password, $address, $dob) {

try{

$dbConnection = $this->DBConnect();
$stmt = $dbConnection->prepare('SELECT * FROM `Users` WHERE `email` = :email ');
$stmt->bindParam(":email", $email,PDO::PARAM_STR);
$stmt->execute();

$Count = $stmt->rowCount();

if($Count < 1){
// insert the new record when match not found...
$stmt = $dbConnection->prepare('INSERT INTO `Users` (fname, lname, gender, email , password, address, dob) 
VALUES(:fname, :lname, :gender, :email , :password, :address, :dob)');

$hash_password= hash('sha256', $password); //Password encryption
$stmt->bindParam(':fname', $fname,PDO::PARAM_STR ); 
$stmt->bindParam(':lname', $lname,PDO::PARAM_STR ); 
$stmt->bindParam(':gender', $gender,PDO::PARAM_STR );
$stmt->bindParam(':email', $email,PDO::PARAM_STR); 
$stmt->bindParam(':password', $hash_password,PDO::PARAM_STR ); 
$stmt->bindParam(':address', $address,PDO::PARAM_STR); 
$stmt->bindParam(':dob', $dob,PDO::PARAM_STR); 
$stmt->execute();

$Count = $stmt->rowCount();

if($Count  == 1 ) {
$uid=$dbConnection->lastInsertId(); // Last inserted row id
$dbConnection = null;

return true;  

}
else{
$dbConnection = null;
return false; 
}
 
}
else{
 //echo "Email-ID already exits";
$dbConnection = null;
return false; 
}
}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
 
} 


// logic and validation for seller registration page
public function sellerRegistration($fname, $lname, $gender, $email, $password, $dob, $image, $phone, $bankName, $accNum, $recipient, $store, $sellerStatus) {

try{

$dbConnection = $this->DBConnect();
$stmt = $dbConnection->prepare('SELECT * FROM `Sellers` WHERE `email` = :email OR `store` = :store ');
$stmt->bindParam(":email", $email,PDO::PARAM_STR);
$stmt->bindParam(":store", $store,PDO::PARAM_STR);
$stmt->execute();

$Count = $stmt->rowCount();

if($Count < 1){
// insert the new record when match not found...
$stmt = $dbConnection->prepare('INSERT INTO `Sellers` (fname, lname, gender, email, password, dob, studentID, contact, bankName, accountNumber, recipient, store, sellerStatus) 
VALUES(:fname, :lname, :gender, :email , :password, :dob, :studentID, :contact, :bankName, :accNum, :recipient, :store, :sellerStatus)');

$hash_password= hash('sha256', $password); //Password encryption
$stmt->bindParam(':fname', $fname,PDO::PARAM_STR ); 
$stmt->bindParam(':lname', $lname,PDO::PARAM_STR ); 
$stmt->bindParam(':gender', $gender,PDO::PARAM_STR );
$stmt->bindParam(':email', $email,PDO::PARAM_STR); 
$stmt->bindParam(':password', $hash_password,PDO::PARAM_STR ); 
$stmt->bindParam(':dob', $dob,PDO::PARAM_STR);
$stmt->bindParam(':studentID', $image,PDO::PARAM_STR);
$stmt->bindParam(':contact', $phone,PDO::PARAM_STR); 
$stmt->bindParam(':bankName', $bankName,PDO::PARAM_STR); 
$stmt->bindParam(':accNum', $accNum,PDO::PARAM_INT);
$stmt->bindParam(':recipient', $recipient,PDO::PARAM_STR); 
$stmt->bindParam(':store', $store,PDO::PARAM_STR);  
$stmt->bindParam(':sellerStatus', $sellerStatus,PDO::PARAM_STR);
$stmt->execute();

$Count = $stmt->rowCount();

if($Count  == 1 ) {
$uid=$dbConnection->lastInsertId(); // Last inserted row id
$dbConnection = null;

return true;
}
else{
$dbConnection = null;
return false; 
}
 
}
else{
 //echo "Email-ID already exits";
$dbConnection = null;
return false; 
}
}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
 
} 

 
// logic and validation for user login page
public function userLogin($email,$password){
 
 try{
  $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('SELECT * FROM `Users` 
  WHERE `email` = :email and `password` = :password');
  $hash_password= hash('sha256', $password); 
  $stmt->bindParam(":email", $email,PDO::PARAM_STR);
  $stmt->bindParam(":password", $hash_password,PDO::PARAM_STR);
  $stmt->execute();

  $Count = $stmt->rowCount();
  $data=$stmt->fetch(PDO::FETCH_OBJ);
  if($Count == 1){
   session_start();
   $_SESSION['id'] = $data->id; // Storing user session value
   $_SESSION['fullname'] = $data->fname . ' ' . $data->lname; // Storing user session value
   $dbConnection = null ;
            return true;
      
  }
  else{
   $dbConnection = null ;
            return false ;
   
  }
  
 }
 catch (PDOException $e) {
  echo 'Connection failed: ' . $e->getMessage();
 }
 
} 


// logic and validation for user login page
public function sellerLogin($email,$password){
 try{
  $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('SELECT * FROM `Sellers` 
  WHERE `email` = :email and `password` = :password');
  $hash_password= hash('sha256', $password); 
  $stmt->bindParam(":email", $email,PDO::PARAM_STR);
  $stmt->bindParam(":password", $hash_password,PDO::PARAM_STR);
  $stmt->execute();

  $Count = $stmt->rowCount();
  $data=$stmt->fetch(PDO::FETCH_OBJ);
  if($Count == 1 && $data->sellerStatus == "approved"){
   session_start();
   $_SESSION['id2'] = $data->id; // Storing user session value
   $_SESSION['fullname2'] = $data->fname . ' ' . $data->lname; // Storing user session value
   $dbConnection = null ;
            return 0;
      
  }

  else if($Count == 1 && $data->sellerStatus == "hold"){
   $dbConnection = null ;
            return -1;
      
  }

  else if($Count == 1 && $data->sellerStatus == "banned"){
   $dbConnection = null ;
            return -2;
      
  }

  else if($Count == 1 && $data->sellerStatus == "disapproved"){
    try{
      $dbConnection = $this->DBConnect();
            $stmt = $dbConnection->prepare('SELECT `studentID` FROM `Sellers` 
      WHERE `email` = :email');
      $stmt->bindParam(":email", $email,PDO::PARAM_STR);
      $stmt->execute();

      $Count = $stmt->rowCount();
      $data=$stmt->fetch(PDO::FETCH_OBJ);
      if($Count == 1){
       unlink($data->studentID);

       $dbConnection = null;
          
      }
      else{
       $dbConnection = null ;
      }
      
     }
     catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
     }

    try {
    $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('DELETE FROM `Sellers` 
    WHERE `email` = :email');
    $stmt->bindParam(":email", $email,PDO::PARAM_STR);
    $stmt->execute();
    }

    catch(PDOException $e)
    {
      echo 'Connection failed: ' . $e->getMessage();
    }
   $dbConnection = null ;
            return -3 ;
   
  }
  
 }
 catch (PDOException $e) {
  echo 'Connection failed: ' . $e->getMessage();
 }
 
}

// logic and validation for user login page
public function adminLogin($username,$password){
 
 try{
  $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('SELECT * FROM `Admins` 
  WHERE `username` = :username and `password` = :password');
  $hash_password= hash('sha256', $password);
  $stmt->bindParam(":username", $username,PDO::PARAM_STR);
  $stmt->bindParam(":password", $hash_password,PDO::PARAM_STR);
  $stmt->execute();

  $Count = $stmt->rowCount();
  $data=$stmt->fetch(PDO::FETCH_OBJ);
  if($Count == 1){
   session_start();
   $_SESSION['id3'] = $data->id; // Storing user session value
   $_SESSION['username'] = $data->username; // Storing user session value
   $dbConnection = null ;
            return true;
      
  }
  else{
   $dbConnection = null ;
            return false ;
   
  }
  
 }
 catch (PDOException $e) {
  echo 'Connection failed: ' . $e->getMessage();
 }
 
}


public function userUpdate1($fname, $lname, $gender, $email, $address, $dob, $id) {

try{

$dbConnection = $this->DBConnect();

// insert the new record when match not found...
$stmt = $dbConnection->prepare('UPDATE `Users` SET fname = :fname, lname = :lname, gender = :gender, email = :email, address = :address, dob = :dob WHERE `id` = :id');

$stmt->bindParam(':fname', $fname,PDO::PARAM_STR ); 
$stmt->bindParam(':lname', $lname,PDO::PARAM_STR );
$stmt->bindParam(':gender', $gender,PDO::PARAM_STR ); 
$stmt->bindParam(':email', $email,PDO::PARAM_STR);
$stmt->bindParam(':address', $address,PDO::PARAM_STR );  
$stmt->bindParam(':dob', $dob,PDO::PARAM_STR); 
$stmt->bindValue(':id', $id,PDO::PARAM_INT); 
$stmt->execute();

$Count = $stmt->rowCount();

if($Count  == 1 ) {
$uid=$dbConnection->lastInsertId(); // Last inserted row id

session_start();
$_SESSION['id'] = $id;
$_SESSION['fullname'] = $fname . ' ' . $lname; // Storing user session value
$dbConnection = null;

return true;  

}
else{
$dbConnection = null;
return false; 
}
}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
 
} 


public function userUpdate2($fname, $lname, $gender, $email, $address, $id) {

try{

$dbConnection = $this->DBConnect();

// insert the new record when match not found...
$stmt = $dbConnection->prepare('UPDATE `Users` SET fname = :fname, lname = :lname, gender = :gender, email = :email, address = :address, WHERE `id` = :id');

$stmt->bindParam(':fname', $fname,PDO::PARAM_STR ); 
$stmt->bindParam(':lname', $lname,PDO::PARAM_STR );
$stmt->bindParam(':gender', $gender,PDO::PARAM_STR ); 
$stmt->bindParam(':email', $email,PDO::PARAM_STR);
$stmt->bindParam(':address', $address,PDO::PARAM_STR );  
$stmt->bindParam(':dob', $dob,PDO::PARAM_STR); 
$stmt->bindValue(':id', $id,PDO::PARAM_INT); 
$stmt->execute();

$Count = $stmt->rowCount();

if($Count  == 1 ) {
$uid=$dbConnection->lastInsertId(); // Last inserted row id

session_start();
$_SESSION['id'] = $id;
$_SESSION['fullname'] = $fname . ' ' . $lname; // Storing user session value
$dbConnection = null;

return true;  

}
else{
$dbConnection = null;
return false; 
}
}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
 
} 

public function sellerUpdate1($fname, $lname, $gender, $email, $dob, $phone, $bankName, $accNum, $recipient, $store, $id) {

try{

$dbConnection = $this->DBConnect();

// insert the new record when match not found...
$stmt = $dbConnection->prepare('UPDATE `Sellers` SET fname = :fname, lname = :lname, gender = :gender, email = :email, dob = :dob, contact = :contact, bankName = :bankName, accountNumber = :accNum, recipient = :recipient, store = :store WHERE `id` = :id');

$stmt->bindParam(':fname', $fname,PDO::PARAM_STR ); 
$stmt->bindParam(':lname', $lname,PDO::PARAM_STR ); 
$stmt->bindParam(':gender', $gender,PDO::PARAM_STR ); 
$stmt->bindParam(':email', $email,PDO::PARAM_STR); 
$stmt->bindParam(':dob', $dob,PDO::PARAM_STR);
$stmt->bindParam(':contact', $phone,PDO::PARAM_STR); 
$stmt->bindParam(':bankName', $bankName,PDO::PARAM_STR );
$stmt->bindParam(':accNum', $accNum,PDO::PARAM_STR );
$stmt->bindParam(':recipient', $recipient,PDO::PARAM_STR );
$stmt->bindParam(':store', $store,PDO::PARAM_STR );   
$stmt->bindValue(':id', $id,PDO::PARAM_INT); 
$stmt->execute();

$Count = $stmt->rowCount();

if($Count  == 1 ) {
$uid=$dbConnection->lastInsertId(); // Last inserted row id

session_start();
$_SESSION['id2'] = $id;
$_SESSION['fullname2'] = $fname . ' ' . $lname; // Storing user session value
$dbConnection = null;

return true;  

}
else{
$dbConnection = null;
return false; 
}
}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
 
} 

public function sellerUpdate2($fname, $lname, $gender, $email, $dob, $phone, $bankOther, $accNum, $recipient, $store, $id) {

try{

$dbConnection = $this->DBConnect();

// insert the new record when match not found...
$stmt = $dbConnection->prepare('UPDATE `Sellers` SET fname = :fname, lname = :lname, gender = :gender, email = :email, dob = :dob, contact = :contact, bankName = :bankName, accountNumber = :accNum, recipient = :recipient, store = :store WHERE `id` = :id');

$stmt->bindParam(':fname', $fname,PDO::PARAM_STR ); 
$stmt->bindParam(':lname', $lname,PDO::PARAM_STR ); 
$stmt->bindParam(':gender', $gender,PDO::PARAM_STR ); 
$stmt->bindParam(':email', $email,PDO::PARAM_STR); 
$stmt->bindParam(':dob', $dob,PDO::PARAM_STR);
$stmt->bindParam(':contact', $phone,PDO::PARAM_STR); 
$stmt->bindParam(':bankName', $bankOther,PDO::PARAM_STR );
$stmt->bindParam(':accNum', $accNum,PDO::PARAM_STR );
$stmt->bindParam(':recipient', $recipient,PDO::PARAM_STR );
$stmt->bindParam(':store', $store,PDO::PARAM_STR );   
$stmt->bindValue(':id', $id,PDO::PARAM_INT); 
$stmt->execute();

$Count = $stmt->rowCount();

if($Count  == 1 ) {
$uid=$dbConnection->lastInsertId(); // Last inserted row id

session_start();
$_SESSION['id2'] = $id;
$_SESSION['fullname2'] = $fname . ' ' . $lname; // Storing user session value
$dbConnection = null;

return true;  

}
else{
$dbConnection = null;
return false; 
}
}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
 
} 


public function sellerUpdate3($fname, $lname, $gender, $email, $phone, $bankName, $accNum, $recipient, $store, $id) {

try{

$dbConnection = $this->DBConnect();

// insert the new record when match not found...
$stmt = $dbConnection->prepare('UPDATE `Sellers` SET fname = :fname, lname = :lname, gender = :gender, email = :email, contact = :contact, bankName = :bankName, accountNumber = :accNum, recipient = :recipient, store = :store WHERE `id` = :id');

$stmt->bindParam(':fname', $fname,PDO::PARAM_STR ); 
$stmt->bindParam(':lname', $lname,PDO::PARAM_STR ); 
$stmt->bindParam(':gender', $gender,PDO::PARAM_STR ); 
$stmt->bindParam(':email', $email,PDO::PARAM_STR); 
$stmt->bindParam(':contact', $phone,PDO::PARAM_STR); 
$stmt->bindParam(':bankName', $bankName,PDO::PARAM_STR );
$stmt->bindParam(':accNum', $accNum,PDO::PARAM_STR );
$stmt->bindParam(':recipient', $recipient,PDO::PARAM_STR );
$stmt->bindParam(':store', $store,PDO::PARAM_STR );   
$stmt->bindValue(':id', $id,PDO::PARAM_INT); 
$stmt->execute();

$Count = $stmt->rowCount();

if($Count  == 1 ) {
$uid=$dbConnection->lastInsertId(); // Last inserted row id

session_start();
$_SESSION['id2'] = $id;
$_SESSION['fullname2'] = $fname . ' ' . $lname; // Storing user session value
$dbConnection = null;

return true;  

}
else{
$dbConnection = null;
return false; 
}
}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
 
} 

public function sellerUpdate4($fname, $lname, $gender, $email, $phone, $bankOther, $accNum, $recipient, $store, $id) {

try{

$dbConnection = $this->DBConnect();

// insert the new record when match not found...
$stmt = $dbConnection->prepare('UPDATE `Sellers` SET fname = :fname, lname = :lname, gender = :gender, email = :email, contact = :contact, bankName = :bankName, accountNumber = :accNum, recipient = :recipient, store = :store WHERE `id` = :id');

$stmt->bindParam(':fname', $fname,PDO::PARAM_STR ); 
$stmt->bindParam(':lname', $lname,PDO::PARAM_STR ); 
$stmt->bindParam(':gender', $gender,PDO::PARAM_STR ); 
$stmt->bindParam(':email', $email,PDO::PARAM_STR); 
$stmt->bindParam(':contact', $phone,PDO::PARAM_STR); 
$stmt->bindParam(':bankName', $bankOther,PDO::PARAM_STR );
$stmt->bindParam(':accNum', $accNum,PDO::PARAM_STR );
$stmt->bindParam(':recipient', $recipient,PDO::PARAM_STR );
$stmt->bindParam(':store', $store,PDO::PARAM_STR );   
$stmt->bindValue(':id', $id,PDO::PARAM_INT); 
$stmt->execute();

$Count = $stmt->rowCount();

if($Count  == 1 ) {
$uid=$dbConnection->lastInsertId(); // Last inserted row id

session_start();
$_SESSION['id2'] = $id;
$_SESSION['fullname2'] = $fname . ' ' . $lname; // Storing user session value
$dbConnection = null;

return true;  

}
else{
$dbConnection = null;
return false; 
}
}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
 
}


public function uploadProduct($name, $description, $category, $subCategory, $price, $stock, $sentIn, $condition, $sellerID, &$productID) {
    date_default_timezone_set('Asia/Jakarta');
    $date = date('Y-m-d');

  //Store product information
  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('INSERT INTO `Products` (name, description, category, subCategory, price, stock, sent_in, product_condition, post_date, seller_id) 
        VALUES(:name, :description, :category, :subCategory, :price, :stock, :sentIn, :condition, :postDate, :sellerID)');

        $stmt->bindParam(':name', $name,PDO::PARAM_STR);  
        $stmt->bindParam(':description', $description,PDO::PARAM_STR);
        $stmt->bindParam(':category', $category,PDO::PARAM_STR);  
        $stmt->bindParam(':subCategory', $subCategory,PDO::PARAM_STR);
        $stmt->bindParam(':price', $price,PDO::PARAM_INT);  
        $stmt->bindParam(':stock', $stock,PDO::PARAM_INT);
        $stmt->bindParam(':sentIn', $sentIn,PDO::PARAM_INT);  
        $stmt->bindParam(':condition', $condition,PDO::PARAM_STR);
        $stmt->bindParam(':postDate', $date,PDO::PARAM_STR);  
        $stmt->bindParam(':sellerID', $sellerID,PDO::PARAM_INT);
        $stmt->execute();

        $Count = $stmt->rowCount();

        if($Count  == 1 ) {
          $productID=$dbConnection->lastInsertId(); // Last inserted row id

          $dbConnection = null;

        return true;  
        }
        else{
          $dbConnection = null;
          return false; 
        }
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }

}

public function updateProduct($name, $description, $category, $subCategory, $price, $sale_price, $stock, $sentIn, $condition, $productID) {
  //Store product information
  try{
        $dbConnection = $this->DBConnect();

        $stmt = $dbConnection->prepare('UPDATE `Products` SET `name` = :name, `description` = :description, `category` = :category, `subCategory` = :subCategory, `price` = :price, `sale_price` = :sale_price, `stock` = :stock, `sent_in` = :sentIn, `product_condition` = :condition WHERE `id` = :id');

        $stmt->bindParam(':name', $name,PDO::PARAM_STR);  
        $stmt->bindParam(':description', $description,PDO::PARAM_STR);
        $stmt->bindParam(':category', $category,PDO::PARAM_STR);  
        $stmt->bindParam(':subCategory', $subCategory,PDO::PARAM_STR);
        $stmt->bindParam(':price', $price,PDO::PARAM_INT);  
        $stmt->bindParam(':sale_price', $sale_price,PDO::PARAM_INT); 
        $stmt->bindParam(':stock', $stock,PDO::PARAM_INT);
        $stmt->bindParam(':sentIn', $sentIn,PDO::PARAM_INT);  
        $stmt->bindParam(':condition', $condition,PDO::PARAM_STR); 
        $stmt->bindParam(':id', $productID,PDO::PARAM_INT);
        $stmt->execute();

        $Count = $stmt->rowCount();

        if($Count  == 1 ) {
          $uid=$dbConnection->lastInsertId(); // Last inserted row id

          $dbConnection = null;

        return true;  
        }
        else{
          $dbConnection = null;
          return false; 
        }
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }

}


public function uploadImage($productID, $source) {
  //Store product information
  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('INSERT INTO `ProductImages` (product_id, source) 
        VALUES(:productID, :source)');

        $stmt->bindParam(':productID', $productID,PDO::PARAM_STR);  
        $stmt->bindParam(':source', $source,PDO::PARAM_STR);
        $stmt->execute();

        $Count = $stmt->rowCount();

        if($Count  == 1 ) {
          $uid=$dbConnection->lastInsertId(); // Last inserted row id
          $dbConnection = null;

        return true;  
        }
        else{
          $dbConnection = null;
          return false; 
        }
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }
}


public function approveSeller($id) {
  try{
        $dbConnection = $this->DBConnect();

        $stmt = $dbConnection->prepare('UPDATE `Sellers` SET sellerStatus = "approved" WHERE `id` = :id');
 
        $stmt->bindValue(':id', $id,PDO::PARAM_INT); 
        $stmt->execute();

        $Count = $stmt->rowCount();

        if($Count  == 1 ) {
          $uid=$dbConnection->lastInsertId(); // Last inserted row id
          $dbConnection = null;

          return true;  
      }
        else{
          $dbConnection = null;
          return false; 
      }
        }
          catch (PDOException $e) {
          echo 'Connection failed: ' . $e->getMessage();
      }
}


public function disapproveSeller($id) {
  try{
        $dbConnection = $this->DBConnect();

        $stmt = $dbConnection->prepare('UPDATE `Sellers` SET sellerStatus = "disapproved" WHERE `id` = :id');
 
        $stmt->bindValue(':id', $id,PDO::PARAM_INT); 
        $stmt->execute();

        $Count = $stmt->rowCount();

        if($Count  == 1 ) {
          $uid=$dbConnection->lastInsertId(); // Last inserted row id
          $dbConnection = null;

          return true;  
      }
        else{
          $dbConnection = null;
          return false; 
      }
        }
          catch (PDOException $e) {
          echo 'Connection failed: ' . $e->getMessage();
      }
}

public function deleteToken1($email) {

try{

$dbConnection = $this->DBConnect();

$stmt = $dbConnection->prepare('UPDATE `PasswordReset1` SET token = "", expires = 0 WHERE `email` = :email');

$stmt->bindParam(':email', $email,PDO::PARAM_STR); 
$stmt->execute();

$Count = $stmt->rowCount();

if($Count  == 1 ) {
$uid=$dbConnection->lastInsertId(); // Last inserted row id

$dbConnection = null;

return true;  

}
else{
$dbConnection = null;
return false; 
}
}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
 
} 


public function insertToken1($email, $token, $expires) {

try{

$dbConnection = $this->DBConnect();

$stmt = $dbConnection->prepare('UPDATE `PasswordReset1` SET token = :token, expires = :expires WHERE `email` = :email');

$stmt->bindParam(':email', $email,PDO::PARAM_STR);  
$stmt->bindParam(':token', $token,PDO::PARAM_STR); 
$stmt->bindParam(':expires', $expires,PDO::PARAM_INT); 
$stmt->execute();

$Count = $stmt->rowCount();

if($Count  == 1 ) {
$uid=$dbConnection->lastInsertId(); // Last inserted row id

$dbConnection = null;

return true;  

}
else{
$dbConnection = null;
return false; 
}
}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
 
} 

public function checkToken1(&$email, $token){
 
 try{
  $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('SELECT * FROM `PasswordReset1` 
  WHERE `token` = :token');

  $stmt->bindParam(":token", $token,PDO::PARAM_STR);
  $stmt->execute();

  $Count = $stmt->rowCount();
  $data=$stmt->fetch(PDO::FETCH_OBJ);
  if($Count == 1){
   $email = $data->email;
   $expiry = $data->expires; 
   
   // Take current time
  date_default_timezone_set('Asia/Jakarta');
  $current = strtotime(date("H:i:s"));

  if ($expiry >= $current) {
      $dbConnection = null ;
      return 0;
  }

  else {
      $dbConnection = null ;
      return -1;
  }
   
      
  }
  else{
   $dbConnection = null ;
            return -2 ;
   
  }
  
 }
 catch (PDOException $e) {
  echo 'Connection failed: ' . $e->getMessage();
 }
 
} 



public function deleteToken2($email) {

try{

$dbConnection = $this->DBConnect();

$stmt = $dbConnection->prepare('UPDATE `PasswordReset2` SET token = "", expires = 0 WHERE `email` = :email');

$stmt->bindParam(':email', $email,PDO::PARAM_STR); 
$stmt->execute();

$Count = $stmt->rowCount();

if($Count  == 1 ) {
$uid=$dbConnection->lastInsertId(); // Last inserted row id

$dbConnection = null;

return true;  

}
else{
$dbConnection = null;
return false; 
}
}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
 
} 


public function insertToken2($email, $token, $expires) {

try{

$dbConnection = $this->DBConnect();

// insert the new record when match not found...
$stmt = $dbConnection->prepare('UPDATE `PasswordReset2` SET token = :token, expires = :expires WHERE `email` = :email');

$stmt->bindParam(':email', $email,PDO::PARAM_STR);  
$stmt->bindParam(':token', $token,PDO::PARAM_STR); 
$stmt->bindParam(':expires', $expires,PDO::PARAM_INT); 
$stmt->execute();

$Count = $stmt->rowCount();

if($Count  == 1 ) {
$uid=$dbConnection->lastInsertId(); // Last inserted row id
$recovery2 = $email;

$dbConnection = null;

return true;  

}
else{
$dbConnection = null;
return false; 
}
}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
 
} 


public function checkToken2(&$email, $token){
 
 try{
  $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('SELECT * FROM `PasswordReset2` 
  WHERE `token` = :token');

  $stmt->bindParam(":token", $token,PDO::PARAM_STR);
  $stmt->execute();

  $Count = $stmt->rowCount();
  $data=$stmt->fetch(PDO::FETCH_OBJ);
  if($Count == 1){
   $email = $data->email;
   $expiry = $data->expires; 
   
   // Take current time
  date_default_timezone_set('Asia/Jakarta');
  $current = strtotime(date("H:i:s"));

  if ($expiry >= $current) {
      $dbConnection = null ;
      return 0;
  }

  else {
      $dbConnection = null ;
      return -1;
  }
   
      
  }
  else{
   $dbConnection = null ;
            return -2 ;
   
  }
  
 }
 catch (PDOException $e) {
  echo 'Connection failed: ' . $e->getMessage();
 }
 
} 


public function emailRecovery1($email){
    try{
            $dbConnection = $this->DBConnect();
            $stmt = $dbConnection->prepare('INSERT INTO `PasswordReset1` (`email`) 
            VALUES(:email)');

            $stmt->bindParam(':email', $email,PDO::PARAM_STR ); 
            $stmt->execute();

            $Count = $stmt->rowCount();

            if($Count  == 1 ) {
            $uid=$dbConnection->lastInsertId(); // Last inserted row id
            $dbConnection = null;

            return true;  

            }
            else{
            $dbConnection = null;
            return false; 
            }
             
            
            }
            catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            }  
}


public function emailRecovery2($email){
    try{
            $dbConnection = $this->DBConnect();
            $stmt = $dbConnection->prepare('INSERT INTO `PasswordReset2` (`email`) 
            VALUES(:email)');

            $stmt->bindParam(':email', $email,PDO::PARAM_STR ); 
            $stmt->execute();

            $Count = $stmt->rowCount();

            if($Count  == 1 ) {
            $uid=$dbConnection->lastInsertId(); // Last inserted row id
            $dbConnection = null;

            return true;  

            }
            else{
            $dbConnection = null;
            return false; 
            }
             
            
            }
            catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            }  
}

public function updatePassword1($email, $password) {

try{

$dbConnection = $this->DBConnect();

// insert the new record when match not found...
$stmt = $dbConnection->prepare('UPDATE `Users` SET `password` = :password WHERE `email` = :email');

$hash_password = hash('sha256', $password);
$stmt->bindParam(':email', $email,PDO::PARAM_STR); 
$stmt->bindParam(':password', $hash_password,PDO::PARAM_STR); 
$stmt->execute();

$Count = $stmt->rowCount();

if($Count  == 1 ) {
$uid=$dbConnection->lastInsertId(); // Last inserted row id

$dbConnection = null;

return true;  

}
else{
$dbConnection = null;
return false; 
}
}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
 
} 


public function updatePassword2($email, $password) {

try{

$dbConnection = $this->DBConnect();

// insert the new record when match not found...
$stmt = $dbConnection->prepare('UPDATE `Sellers` SET `password` = :password WHERE `email` = :email');

$hash_password = hash('sha256', $password);
$stmt->bindParam(':email', $email,PDO::PARAM_STR); 
$stmt->bindParam(':password', $hash_password,PDO::PARAM_STR); 
$stmt->execute();

$Count = $stmt->rowCount();

if($Count  == 1 ) {
$uid=$dbConnection->lastInsertId(); // Last inserted row id

$dbConnection = null;

return true;  

}
else{
$dbConnection = null;
return false; 
}
}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
 
} 


public function totalProduct($sellerID) {

try{

$dbConnection = $this->DBConnect();

$stmt = $dbConnection->prepare("SELECT * FROM `Products` WHERE `seller_id` = :sellerID ORDER BY id ASC");
$stmt->bindParam(":sellerID", $sellerID ,PDO::PARAM_INT);
$stmt->execute();

$Count = $stmt->rowCount();
return $Count;

}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
 
}

public function totalProduct2($sellerID) {

try{

$dbConnection = $this->DBConnect();

$stmt = $dbConnection->prepare("SELECT * FROM `Products` WHERE `seller_id` = :sellerID AND `stock` > 0 ORDER BY id ASC");
$stmt->bindParam(":sellerID", $sellerID ,PDO::PARAM_INT);
$stmt->execute();

$Count = $stmt->rowCount();
return $Count;

}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
 
}

public function totalProduct3($sellerID) {

try{

$dbConnection = $this->DBConnect();

$stmt = $dbConnection->prepare("SELECT * FROM `Products` WHERE `seller_id` = :sellerID AND `stock` = 0 ORDER BY id ASC");
$stmt->bindParam(":sellerID", $sellerID ,PDO::PARAM_INT);
$stmt->execute();

$Count = $stmt->rowCount();
return $Count;

}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
 
}

public function deleteProduct($productID) {

try {
    $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('DELETE FROM `Products` 
    WHERE `id` = :productID');
    $stmt->bindParam(":productID", $productID,PDO::PARAM_STR);
    $stmt->execute();
    }

    catch(PDOException $e)
    {
      echo 'Connection failed: ' . $e->getMessage();
    }

try {
    $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('DELETE FROM `ProductImages` 
    WHERE `product_id` = :productID');
    $stmt->bindParam(":productID", $productID,PDO::PARAM_STR);
    $stmt->execute();
    for($i=0; $row = $stmt->fetch(); $i++){
        unlink($row['source']);
    }

  }

    catch(PDOException $e)
    {
      echo 'Connection failed: ' . $e->getMessage();
    }

    return true;
 
}


public function countSearch($search, $sellerID){
      $productCount = 0;
      $dbConnection = $this->DBConnect();

      $result = $dbConnection->prepare("SELECT * FROM `Products` WHERE `seller_id` = :id AND `name` LIKE '%{$search}%' OR `category` LIKE '%{$search}%' OR `subCategory` LIKE '%{$search}%' ORDER BY id ASC");
      $result->bindParam(':id', $sellerID,PDO::PARAM_INT); 
      $result->execute();
      $productCount += $result->rowCount();

      return $productCount;
} 


public function countSearch2($search){
      $productCount = 0;
      $dbConnection = $this->DBConnect();

      $result = $dbConnection->prepare("SELECT * FROM `Products` WHERE `name` LIKE '%{$search}%' OR `category` LIKE '%{$search}%' OR `subCategory` LIKE '%{$search}%' ORDER BY id ASC");
      $result->execute();
      $productCount += $result->rowCount();

      return $productCount;
}

public function contactUsForm($name, $email, $subject, $message) {
  //Store product information
  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('INSERT INTO `ContactUs` (name, email, subject, message, status) 
        VALUES(:name, :email, :subject, :message, "unread")');

        $stmt->bindParam(':name', $name,PDO::PARAM_STR);  
        $stmt->bindParam(':email', $email,PDO::PARAM_STR);
        $stmt->bindParam(':subject', $subject,PDO::PARAM_STR);
        $stmt->bindParam(':message', $message,PDO::PARAM_STR);
        $stmt->execute();

        $Count = $stmt->rowCount();

        if($Count  == 1 ) {
          $uid=$dbConnection->lastInsertId(); // Last inserted row id
          $dbConnection = null;

        return true;  
        }
        else{
          $dbConnection = null;
          return false; 
        }
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }
} 

public function reportSeller($name, $email, $subject, $message, $sellerID) {
  //Store product information
  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('INSERT INTO `UserComplaint` (name, email, subject, message, seller_id, status) 
        VALUES(:name, :email, :subject, :message, :id, "unread")');

        $stmt->bindParam(':name', $name,PDO::PARAM_STR);  
        $stmt->bindParam(':email', $email,PDO::PARAM_STR);
        $stmt->bindParam(':subject', $subject,PDO::PARAM_STR);
        $stmt->bindParam(':message', $message,PDO::PARAM_STR);
        $stmt->bindParam(':id', $sellerID,PDO::PARAM_INT);
        $stmt->execute();

        $Count = $stmt->rowCount();

        if($Count  == 1 ) {
          $uid=$dbConnection->lastInsertId(); // Last inserted row id
          $dbConnection = null;

        return true;  
        }
        else{
          $dbConnection = null;
          return false; 
        }
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }
} 


public function readMessage($id) {
  try{
        $dbConnection = $this->DBConnect();

        $stmt = $dbConnection->prepare('DELETE FROM `UserComplaint` WHERE `id` = :id');
 
        $stmt->bindValue(':id', $id,PDO::PARAM_INT); 
        $stmt->execute();

          return true; 
      }
          catch (PDOException $e) {
          echo 'Connection failed: ' . $e->getMessage();
      }
}


public function banSeller($id) {
  try{
        $dbConnection = $this->DBConnect();

        $stmt = $dbConnection->prepare('SELECT * FROM `UserComplaint` WHERE `id` = :id');
 
        $stmt->bindValue(':id', $id,PDO::PARAM_INT); 
        $stmt->execute();
        $data=$stmt->fetch(PDO::FETCH_OBJ);

        $sellerID = $data->seller_id;

        $stmt = $dbConnection->prepare('UPDATE `Sellers` SET `sellerStatus` = "banned" WHERE id = :id');
 
        $stmt->bindValue(':id', $sellerID,PDO::PARAM_INT); 
        $stmt->execute();

          return true; 
      }
          catch (PDOException $e) {
          echo 'Connection failed: ' . $e->getMessage();
      }
}

public function unbanSeller($id) {
  try{
        $dbConnection = $this->DBConnect();

        $stmt = $dbConnection->prepare('SELECT * FROM `UserComplaint` WHERE `id` = :id');
 
        $stmt->bindValue(':id', $id,PDO::PARAM_INT); 
        $stmt->execute();
        $data=$stmt->fetch(PDO::FETCH_OBJ);

        $sellerID = $data->seller_id;

        $stmt = $dbConnection->prepare('UPDATE `Sellers` SET `sellerStatus` = "approved" WHERE id = :id');
 
        $stmt->bindValue(':id', $sellerID,PDO::PARAM_INT); 
        $stmt->execute();

          return true; 
      }
          catch (PDOException $e) {
          echo 'Connection failed: ' . $e->getMessage();
      }
}

public function banSeller2($id) {
  try{
        $dbConnection = $this->DBConnect();

        $stmt = $dbConnection->prepare('UPDATE `Sellers` SET `sellerStatus` = "banned" WHERE id = :id');
 
        $stmt->bindValue(':id', $id,PDO::PARAM_INT); 
        $stmt->execute();

          return true; 
      }
          catch (PDOException $e) {
          echo 'Connection failed: ' . $e->getMessage();
      }
}

public function unbanSeller2($id) {
  try{
        $dbConnection = $this->DBConnect();

        $stmt = $dbConnection->prepare('UPDATE `Sellers` SET `sellerStatus` = "approved" WHERE id = :id');
 
        $stmt->bindValue(':id', $id,PDO::PARAM_INT); 
        $stmt->execute();

          return true; 
      }
          catch (PDOException $e) {
          echo 'Connection failed: ' . $e->getMessage();
      }
}

public function checkCart($id) {
  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('SELECT * FROM `Cart` WHERE `user_id` = :id');

        $stmt->bindParam(':id', $id,PDO::PARAM_INT);
        $stmt->execute();

        $Count = $stmt->rowCount();

        if($Count == 0 ) {
          $uid=$dbConnection->lastInsertId(); // Last inserted row id
          $dbConnection = null;

        return true;  
        }
        else{
          $dbConnection = null;
          return false; 
        }
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }
} 

public function addItem($id, $productID, $quantity) {
  //Store product information

  $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('SELECT * FROM `Cart` WHERE `product_id` = :productID');

        $stmt->bindParam(':productID', $productID,PDO::PARAM_INT);
        $stmt->execute();

        $Count = $stmt->rowCount();

        if($Count == 1 ) {

            try{
          $dbConnection = $this->DBConnect();
          $stmt = $dbConnection->prepare('UPDATE `Cart` SET quantity = quantity + :quantity WHERE product_id = :id');

          $stmt->bindParam(':id', $productID,PDO::PARAM_INT);
          $stmt->bindParam(':quantity', $quantity,PDO::PARAM_INT);
          $stmt->execute();

          $Count = $stmt->rowCount();

          if($Count  == 1 ) {
            $uid=$dbConnection->lastInsertId(); // Last inserted row id
            $dbConnection = null;

          return true;  
          }
          else{
            $dbConnection = null;
            return false; 
          }
          
        }
          catch (PDOException $e) {
          echo 'Connection failed: ' . $e->getMessage();
          }
          
        } else {
          try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('INSERT `Cart` (user_id, product_id, quantity) 
        VALUES(:id, :productID, :quantity)');

        $stmt->bindParam(':id', $id,PDO::PARAM_INT);
        $stmt->bindParam(':productID', $productID,PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity,PDO::PARAM_INT);
        $stmt->execute();

        $Count = $stmt->rowCount();

        if($Count  == 1 ) {
          $uid=$dbConnection->lastInsertId(); // Last inserted row id
          $dbConnection = null;

        return true;  
        }
        else{
          $dbConnection = null;
          return false; 
        }
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }
        }
} 


public function removeItem($cartID) {
  try{
        $dbConnection = $this->DBConnect();

        $stmt = $dbConnection->prepare('DELETE FROM `Cart` WHERE `id` = :id');
 
        $stmt->bindValue(':id', $cartID,PDO::PARAM_INT); 
        $stmt->execute();

          return true; 
      }
          catch (PDOException $e) {
          echo 'Connection failed: ' . $e->getMessage();
      }   
} 

public function removeItem2($id) {
  try{
        $dbConnection = $this->DBConnect();

        $stmt = $dbConnection->prepare('DELETE FROM `Cart` WHERE `user_id` = :id');
 
        $stmt->bindValue(':id', $id,PDO::PARAM_INT); 
        $stmt->execute();

          return true; 
      }
          catch (PDOException $e) {
          echo 'Connection failed: ' . $e->getMessage();
      }   
} 


public function addCheckout($id, $productID, $quantity) {
  //Store product information
  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('INSERT `Checkout` (user_id, product_id, quantity, status) 
        VALUES(:id, :productID, :quantity, "hold")');

        $stmt->bindParam(':id', $id,PDO::PARAM_INT);
        $stmt->bindParam(':productID', $productID,PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity,PDO::PARAM_INT);
        $stmt->execute();
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }
} 

public function addOrder($id, $productID, $quantity) {
   $dbConnection = $this->DBConnect();
   $stmt = $dbConnection->prepare('SELECT * FROM `Products` WHERE `id` = :id');

   $stmt->bindParam(':id', $productID,PDO::PARAM_INT);
   $stmt->execute();
   $data=$stmt->fetch(PDO::FETCH_OBJ);

   $sellerID = $data->seller_id;

  //Store product information for seller
  try{
        $stmt2 = $dbConnection->prepare('INSERT `SellerOrder` (user_id, product_id, seller_id, quantity, status) 
        VALUES(:id, :productID, :sellerID, :quantity, "hold")');

        $stmt2->bindParam(':id', $id,PDO::PARAM_INT);
        $stmt2->bindParam(':productID', $productID,PDO::PARAM_INT);
        $stmt2->bindParam(':sellerID', $sellerID,PDO::PARAM_INT);
        $stmt2->bindParam(':quantity', $quantity,PDO::PARAM_INT);
        $stmt2->execute();
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }
} 


public function addComment($id, $productID, $productRating, $detail, $reviewName) {

  //Store user comment
  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('INSERT `Comments` (user_id, product_id, rating, comment, display_name) 
        VALUES(:id, :productID, :rating, :detail, :reviewName)');

        $stmt->bindParam(':id', $id,PDO::PARAM_INT);
        $stmt->bindParam(':productID', $productID,PDO::PARAM_INT);
        $stmt->bindParam(':rating', $productRating,PDO::PARAM_INT);
        $stmt->bindParam(':detail', $detail,PDO::PARAM_STR);
        $stmt->bindParam(':reviewName', $reviewName,PDO::PARAM_STR);
        $stmt->execute();
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }
} 


public function checkProduct($productID) {
    try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('SELECT * FROM `Review` WHERE `product_id` = :id');

        $stmt->bindParam(':id', $productID,PDO::PARAM_INT);
        $stmt->execute();

        $Count = $stmt->rowCount();

        if($Count == 1 ) {
          $dbConnection = null;
          return true; 
        }
        else{
          $dbConnection = null;
          return false; 
        }
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }
} 

public function updateDate($userID, $productID, $action, $quantity) {
  date_default_timezone_set('Asia/Jakarta');
  $date = date("Y-m-d");

  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('UPDATE `SellerOrder` SET `checkoutDate` = :checkoutDate, `status` = :action WHERE `user_id` = :id AND `product_id` = :productID AND `status` != "arrived"');

        $stmt->bindParam(':id', $userID,PDO::PARAM_INT);
        $stmt->bindParam(':productID', $productID,PDO::PARAM_INT);
        $stmt->bindParam(':checkoutDate', $date,PDO::PARAM_STR);
        $stmt->bindParam(':action', $action,PDO::PARAM_STR);
        $stmt->execute();
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }

  try{
        $stmt2 = $dbConnection->prepare('UPDATE `Products` SET `stock` = `stock` - :quantity WHERE `id` = :productID');

        $stmt2->bindParam(':productID', $productID,PDO::PARAM_INT);
        $stmt2->bindParam(':quantity', $quantity,PDO::PARAM_INT);
        $stmt2->execute();
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }
}

public function updateDate2($userID, $productID, $action) {
  date_default_timezone_set('Asia/Jakarta');
  $date = date("Y-m-d");

  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('UPDATE `Checkout` SET `checkoutDate` = :checkoutDate, `status` = :action WHERE `user_id` = :id AND `product_id` = :productID AND `status` = "hold" OR `status` = "processing" OR `status` = "delivering"');

        $stmt->bindParam(':id', $userID,PDO::PARAM_INT);
        $stmt->bindParam(':productID', $productID,PDO::PARAM_INT);
        $stmt->bindParam(':checkoutDate', $date,PDO::PARAM_STR);
        $stmt->bindParam(':action', $action,PDO::PARAM_STR);
        $stmt->execute();
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }
}


public function updateStatus($userID, $productID, $action) {
  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('UPDATE `SellerOrder` SET `status` = :status WHERE `user_id` = :id AND `product_id` = :productID');

        $stmt->bindParam(':id', $userID,PDO::PARAM_INT);
        $stmt->bindParam(':productID', $productID,PDO::PARAM_INT);
        $stmt->bindParam(':status', $action,PDO::PARAM_STR);
        $stmt->execute();
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }
}

public function updateStatus2($userID, $productID, $action) {
  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('UPDATE `Checkout` SET `status` = :status WHERE `user_id` = :id AND `product_id` = :productID');

        $stmt->bindParam(':id', $userID,PDO::PARAM_INT);
        $stmt->bindParam(':productID', $productID,PDO::PARAM_INT);
        $stmt->bindParam(':status', $action,PDO::PARAM_STR);
        $stmt->execute();
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }
}


public function updateReview($productID, $productRating) {
  if ($productRating == 1) {
  //update product review
  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('UPDATE `Review` SET `star1` = `star1` + 1 WHERE product_id = :id');

        $stmt->bindParam(':id', $productID,PDO::PARAM_INT);
        $stmt->execute();
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }

  }

  else if ($productRating == 2) {
  //update product review
  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('UPDATE `Review` SET `star2` = `star2` + 1 WHERE product_id = :id');

        $stmt->bindParam(':id', $productID,PDO::PARAM_INT);
        $stmt->execute();
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }

  }

  else if ($productRating == 3) {
  //update product review
  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('UPDATE `Review` SET `star3` = `star3` + 1 WHERE product_id = :id');

        $stmt->bindParam(':id', $productID,PDO::PARAM_INT);
        $stmt->execute();
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }

  }

  else if ($productRating == 4) {
  //update product review
  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('UPDATE `Review` SET `star4` = `star4` + 1 WHERE product_id = :id');

        $stmt->bindParam(':id', $productID,PDO::PARAM_INT);
        $stmt->execute();
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }

  }

  else if ($productRating == 5) {
  //update product review
  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('UPDATE `Review` SET `star5` = `star5` + 1 WHERE product_id = :id');

        $stmt->bindParam(':id', $productID,PDO::PARAM_INT);
        $stmt->execute();
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }

  }
} 


public function insertReview($productID, $productRating) {
  if ($productRating == 1) {
  //update product review
  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('INSERT `Review` (product_id, star1) 
        VALUES(:productID, "1")');

        $stmt->bindParam(':productID', $productID,PDO::PARAM_INT);
        $stmt->execute();
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }

  }

  else if ($productRating == 2) {
  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('INSERT `Review` (product_id, star2) 
        VALUES(:productID, "1")');

        $stmt->bindParam(':productID', $productID,PDO::PARAM_INT);
        $stmt->execute();
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }

  }

  else if ($productRating == 3) {
  //update product review
  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('INSERT `Review` (product_id, star3) 
        VALUES(:productID, "1")');

        $stmt->bindParam(':productID', $productID,PDO::PARAM_INT);
        $stmt->execute();
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }

  }

  else if ($productRating == 4) {
  //update product review
  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('INSERT `Review` (product_id, star4) 
        VALUES(:productID, "1")');

        $stmt->bindParam(':productID', $productID,PDO::PARAM_INT);
        $stmt->execute();
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }

  }

  else if ($productRating == 5) {
  //update product review
  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('INSERT `Review` (product_id, star5) 
        VALUES(:productID, "1")');

        $stmt->bindParam(':productID', $productID,PDO::PARAM_INT);
        $stmt->execute();
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }

  }
} 


public function deleteOrder($userID, $productID) {
  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('DELETE FROM `SellerOrder` WHERE `user_id` = :id AND `product_id` = :productID');

        $stmt->bindParam(':id', $userID,PDO::PARAM_INT);
        $stmt->bindParam(':productID', $productID,PDO::PARAM_INT);
        $stmt->execute();

        $Count = $stmt->rowCount();
        $data=$stmt->fetch(PDO::FETCH_OBJ);

        if ($Count == 1)
          unlink($data->transfer_receipt);
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }
}


public function uploadReceipt($userID, $productID, $image) {

  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('UPDATE `Checkout` SET `transfer_receipt` = :image WHERE product_id = :productID AND user_id = :userID');

        $stmt->bindParam(':image', $image,PDO::PARAM_STR);
        $stmt->bindParam(':productID', $productID,PDO::PARAM_INT);
        $stmt->bindParam(':userID', $userID,PDO::PARAM_INT);
        $stmt->execute();
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }

  }


  public function uploadReceipt2($userID, $productID, $image) {

  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('UPDATE `SellerOrder` SET `transfer_receipt` = :image WHERE product_id = :productID AND user_id = :userID');

        $stmt->bindParam(':image', $image,PDO::PARAM_STR);
        $stmt->bindParam(':productID', $productID,PDO::PARAM_INT);
        $stmt->bindParam(':userID', $userID,PDO::PARAM_INT);
        $stmt->execute();
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }

  }


  public function deleteReceipt($userID, $productID) {

  try{
        $dbConnection = $this->DBConnect();
         $stmt = $dbConnection->prepare('UPDATE `SellerOrder` SET `transfer_receipt` = " " WHERE product_id = :productID AND user_id = :userID');

        $stmt->bindParam(':productID', $productID,PDO::PARAM_INT);
        $stmt->bindParam(':userID', $userID,PDO::PARAM_INT);
        $stmt->execute();
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }

  }


   public function deleteReceipt2($userID, $productID) {

  try{
        $dbConnection = $this->DBConnect();
         $stmt = $dbConnection->prepare('UPDATE `Checkout` SET `transfer_receipt` = " " WHERE product_id = :productID AND user_id = :userID');

        $stmt->bindParam(':productID', $productID,PDO::PARAM_INT);
        $stmt->bindParam(':userID', $userID,PDO::PARAM_INT);
        $stmt->execute();
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }

  }


  public function deleteSeller($id) {

try {
    $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('DELETE FROM `Sellers` 
    WHERE `id` = :id');
    $stmt->bindParam(":id", $id,PDO::PARAM_INT);
    $stmt->execute();
    }

    catch(PDOException $e)
    {
      echo 'Connection failed: ' . $e->getMessage();
    }
    
    return true;
 
}

public function sellerInbox($id, $subject, $message) {
  $admin = "Admin";

  //Store Inbox message
  try{
        $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('INSERT INTO `Inbox` (name, subject, message, seller_id) 
        VALUES(:admin, :subject, :message, :sellerID)');

        $stmt->bindParam(':admin', $admin,PDO::PARAM_STR);  
        $stmt->bindParam(':subject', $subject,PDO::PARAM_STR);
        $stmt->bindParam(':message', $message,PDO::PARAM_STR);
        $stmt->bindParam(':sellerID', $id,PDO::PARAM_INT);
        $stmt->execute();

        $Count = $stmt->rowCount();

        if($Count  == 1 ) {
          $uid=$dbConnection->lastInsertId(); // Last inserted row id
          $dbConnection = null;

        return true;  
        }
        else{
          $dbConnection = null;
          return false; 
        }
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        }
}

public function updateID($id, $IDNum) {

  try{
        $dbConnection = $this->DBConnect();
         $stmt = $dbConnection->prepare('UPDATE `Sellers` SET `IDNum` = :IDNum WHERE id = :id');

        $stmt->bindParam(':IDNum', $IDNum,PDO::PARAM_INT);
        $stmt->bindParam(':id', $id,PDO::PARAM_INT);
        $stmt->execute();
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        return false;
        }

        return true;

  }


public function addTrackinginfo($carrier, $number, $userID, $productID) {

  try{
        $dbConnection = $this->DBConnect();
         $stmt = $dbConnection->prepare('UPDATE `SellerOrder` SET `trackingCarrier` = :carrier, `trackingNumber` = :num WHERE product_id = :productID AND user_id = :userID');

        $stmt->bindParam(':carrier', $carrier,PDO::PARAM_STR); 
        $stmt->bindParam(':num', $number,PDO::PARAM_STR); 
        $stmt->bindParam(':productID', $productID,PDO::PARAM_INT);
        $stmt->bindParam(':userID', $userID,PDO::PARAM_INT);
        $stmt->execute();
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        return false;
        }

        return true;

  }

public function deletePic($userID, $productID) {

try {
    $dbConnection = $this->DBConnect();
    $stmt = $dbConnection->prepare('SELECT * FROM `Checkout` WHERE `user_id` = :id AND `product_id` = :productID');
    $stmt->bindParam(":id", $userID,PDO::PARAM_INT);
    $stmt->bindParam(":productID", $productID,PDO::PARAM_INT);
    $stmt->execute();
    for($i=0; $row = $stmt->fetch(); $i++){
        unlink($row['transfer_receipt']);
        $row['transfer_receipt'] = 'test';
    }

  }

    catch(PDOException $e)
    {
      echo 'Connection failed: ' . $e->getMessage();
    }

  $empty = "0";

  try{
        $dbConnection = $this->DBConnect();
         $stmt = $dbConnection->prepare('UPDATE `Checkout` SET `transfer_receipt` = :empty WHERE product_id = :productID AND user_id = :userID');

        $stmt->bindParam(':empty', $empty,PDO::PARAM_STR); 
        $stmt->bindParam(':productID', $productID,PDO::PARAM_INT);
        $stmt->bindParam(':userID', $userID,PDO::PARAM_INT);
        $stmt->execute();
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        return false;
        }

        return true;
 
}

public function updateAddress($id, $address) {

  try{
        $dbConnection = $this->DBConnect();
         $stmt = $dbConnection->prepare('UPDATE `Users` SET `address` = :address WHERE id = :id');

        $stmt->bindParam(':id', $id,PDO::PARAM_INT);
        $stmt->bindParam(':address', $address,PDO::PARAM_STR);
        $stmt->execute();
        
      }
        catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        return false;
        }

        return true;
 
}
 
}

?>