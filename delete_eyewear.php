<?php
include('conn.php');
$productId = $_POST['productId'];
$stmt = "delete from products where id = ". $productId . "";
if(mysqli_query($conn,$stmt))
{
    echo "Successfully Deleted";
}
else{
    echo "error";
}

?>