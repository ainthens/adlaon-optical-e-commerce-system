<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$productId = $_POST['product_id']; 
$userId = $_SESSION['user_id'];


?>