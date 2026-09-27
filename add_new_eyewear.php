<?php
include('conn.php');

$title = $_POST['eyewearName'];
$category = $_POST['category'];
$price = $_POST['price'];
$stocks = $_POST['stock'];

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
        die("Failed to move uploaded file.");
    }
} else {
    die("No file uploaded or upload error.");
}
echo "Connected to DB successfully<br>";
echo "Title: $title, Category: $category, Price: $price, Stocks: $stocks<br>";
$stmt = $conn->prepare("INSERT INTO products (title, category, price, image, stocks) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssdsi", $title, $category, $price, $imagePathForDB, $stocks);

if ($stmt->execute()) {
    echo $tmpName;
    
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
