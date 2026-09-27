<?php
    include('conn.php');
    session_start();
    $action = $_POST['action'];

    if ($action == 'add_to_cart') {
        $userId = $_POST['user_id'];
        $productTitle = $_POST['product_title'];
        $productPrice = $_POST['product_price'];
        $productId = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $stmt = $conn->prepare("INSERT INTO Cart (user_id, product_title, product_price, quantity, product_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isdii", $userId, $productTitle, $productPrice, $quantity, $productId);
        $stmt->execute();
    } elseif ($action == 'remove_from_cart') {
        $productId = $_POST['product_id'];
        $userId = $_POST['user_id'];
        $stmt = $conn->prepare("DELETE FROM Cart WHERE product_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $productId, $userId);
        $stmt->execute();
    } elseif ($_POST['action'] == 'update_quantity') {
    $userId = intval($_POST['user_id']);
    $productId = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    // Update quantity in cart for this user and product
    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("iii", $quantity, $userId, $productId);
    $stmt->execute();
    $stmt->close();

    echo "Quantity updated";
    exit;
} elseif ($action == 'checkout') {
        $userId = $_POST['user_id'];
        $userStmt = $conn->prepare("SELECT full_name FROM Users WHERE id = ?");
        $userStmt->bind_param("i", $userId);
        $userStmt->execute();
        $userResult = $userStmt->get_result();
        $user = $userResult->fetch_assoc();
        $fullName = $user['full_name'];
        $cartStmt = $conn->prepare("SELECT product_title, product_price, quantity FROM Cart WHERE user_id = ?");
        $cartStmt->bind_param("i", $userId);
        $cartStmt->execute();
        $cartResult = $cartStmt->get_result();

        $orderId = time();

        while ($cartItem = $cartResult->fetch_assoc()) {
            echo "Inserting item: " . $cartItem['product_title'] . "<br>";
            $productTitle = $cartItem['product_title'];
            $productPrice = $cartItem['product_price'];
            $quantity = $cartItem['quantity'];
            $totalAmount = $productPrice * $quantity;
            $status = "Pending";

            $orderStmt = $conn->prepare("INSERT INTO orders (order_id, user_id, full_name, product_title, product_price, quantity, total_amount, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $orderStmt->bind_param("iissdiis",$orderId,$userId, $fullName, $productTitle, $productPrice, $quantity, $totalAmount, $status);
            $orderStmt->execute();

            //$updateStockStmt = $conn->prepare("UPDATE products SET stocks = stocks - ? WHERE title = ?");
            //$updateStockStmt->bind_param("is", $quantity, $productTitle);
            //$updateStockStmt->execute();
        }

        $deleteStmt = $conn->prepare("DELETE FROM Cart WHERE user_id = ?");
        $deleteStmt->bind_param("i", $userId);
        $deleteStmt->execute();
    } elseif ($action == 'get_cart') {
        $userId = $_POST['user_id'];
        $stmt = $conn->prepare("SELECT product_title, product_price, quantity FROM Cart WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $cartItems = [];

        while ($row = $result->fetch_assoc()) {
            $cartItems[] = $row;
        }
        
        echo json_encode($cartItems);
    }
?>
