<?php
session_start(); 
$_SESSION['id2']=''; 
$_SESSION['fullname2']=''; 
session_unset(); 

$url='../user/homepage.php';
header("Location: $url"); // Page redirecting to homepage.php 
 
?>