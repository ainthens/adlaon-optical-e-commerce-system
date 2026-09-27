<?php
include('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'], $_POST['status'])) {
    $order_id = intval($_POST['order_id']);
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
    $stmt->bind_param("si", $status, $order_id);

    if ($stmt->execute()) {
        echo "Order status updated to '$status'";
    } else {
        echo "Failed to update order.";
    }

    $stmt->close();
    if ($status === 'Shipped Out') {

        // grab every line‑item for this order
        $items = $conn->prepare(
            "SELECT product_title, quantity
             FROM orders
             WHERE order_id = ?"
        );
        $items->bind_param("i", $order_id);
        $items->execute();
        $result = $items->get_result();

        // update stock for each product
        $update = $conn->prepare(
            "UPDATE products SET stocks = stocks - ?, times_bought = times_bought + ? WHERE title = ?"
        );

        while ($row = $result->fetch_assoc()) {
            $qty   = $row['quantity'];
            
            $title = $row['product_title'];
            $update->bind_param("iis", $qty,$qty, $title);
            $update->execute();
        }
        $update->close();
        $items->close();
    }
} else {
    echo "Invalid request.";
}
?>
