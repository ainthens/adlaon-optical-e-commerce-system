<?php
include('conn.php');

$title = $_POST['eyewearName'];
$category = $_POST['category'];
$price = $_POST['price'];
$stocks = $_POST['stock'];
$productId = $_POST['product_id'];
$productImage = $_POST['product_img'];
$currentImage = $_POST['currentImagePath'];
$imagePathForDB = $currentImage;

if (isset($_FILES['eyewearImage']) && $_FILES['eyewearImage']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/';
    $tmpName = $_FILES['eyewearImage']['tmp_name'];
    echo $tmpName;
    $originalName = basename($_FILES['eyewearImage']['name']);
    $uniqueName = uniqid() . '-' . $originalName;
    $targetPath = $uploadDir . $uniqueName;

    if (move_uploaded_file($tmpName, $targetPath)) 
    {
        $imagePathForDB = $targetPath;
    } 
    else 
    {
        echo("Failed to move uploaded file.");
    }
} else {
    echo("No file uploaded or upload error.");
}
echo "Connected to DB successfully<br>";
echo "Title: $title, Category: $category, Price: $price, Stocks: $stocks<br>";
$stmt = $conn->prepare("UPDATE `products` SET `title`= ?,`category`= ?,`price`=?,`image`=?,`stocks`=? WHERE id = ?");
$stmt->bind_param("ssdsii", $title, $category, $price, $imagePathForDB, $stocks, $productId);

if ($stmt->execute()) {
    echo $tmpName;
    
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
