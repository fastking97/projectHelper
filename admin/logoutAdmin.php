<?php
session_start(); 
$_SESSION['id3']=''; 
$_SESSION['username']=''; 
$_SESSION['seller']='';
session_unset(); 

$url='./adminLogin.php';
header("Location: $url"); // Page redirecting to homepage.php 
 
?>