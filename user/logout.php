<?php
session_start(); 
$_SESSION['id']=''; 
$_SESSION['fullname']=''; 
$_SESSION['link']='';
session_unset(); 

$url='homepage.php';
header("Location: $url"); // Page redirecting to homepage.php 
 
?>